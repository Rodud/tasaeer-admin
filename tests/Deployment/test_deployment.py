import importlib.util
import io
import json
import os
from pathlib import Path
import sys
import tarfile
import tempfile
import unittest
from unittest.mock import patch

DEPLOYMENT = Path(__file__).resolve().parents[2] / 'ops/deployment'
sys.path.insert(0, str(DEPLOYMENT))
import archive_guard
import worker

SHA = 'a' * 40
OTHER_SHA = 'b' * 40


class ArchiveTests(unittest.TestCase):
    def setUp(self):
        self.temp = tempfile.TemporaryDirectory()
        self.base = Path(self.temp.name)
        self.archive = self.base / 'release.tar.gz'
        self.destination = self.base / 'release'
        self.destination.mkdir()

    def tearDown(self):
        self.temp.cleanup()

    def make_archive(self, extra=None):
        required = ['artisan', 'composer.lock', 'package-lock.json', 'public/index.php', 'tests/Pest.php', '.env.example']
        with tarfile.open(self.archive, 'w:gz') as output:
            for name in required:
                entry = tarfile.TarInfo(name)
                entry.size = 2
                output.addfile(entry, io.BytesIO(b'{}'))
            if extra:
                name, kind = extra
                entry = tarfile.TarInfo(name)
                if kind == 'symlink':
                    entry.type = tarfile.SYMTYPE
                    entry.linkname = '/etc/passwd'
                    output.addfile(entry)
                else:
                    entry.size = 1
                    output.addfile(entry, io.BytesIO(b'x'))

    def test_valid_code_archive(self):
        self.make_archive()
        archive_guard.extract(self.archive, self.destination)
        self.assertTrue((self.destination / 'artisan').is_file())

    def test_rejects_unsafe_or_persistent_content(self):
        cases = ['../escape', '/etc/escape', '.env', '.env.production', 'vendor/autoload.php',
                 'node_modules/file', 'database/data.sql', 'database/database.sqlite',
                 'storage/logs/data.log', 'bootstrap/cache/config.php', 'public/hot', '.git/config', 'a\\b']
        for name in cases:
            with self.subTest(name=name):
                self.make_archive((name, 'file'))
                with self.assertRaises(ValueError):
                    archive_guard.extract(self.archive, self.destination)
                self.assertEqual(list(self.destination.iterdir()), [])

    def test_rejects_links(self):
        self.make_archive(('link', 'symlink'))
        with self.assertRaises(ValueError):
            archive_guard.extract(self.archive, self.destination)

    def test_rejects_duplicate_files(self):
        self.make_archive(('artisan', 'file'))
        with self.assertRaises(ValueError):
            archive_guard.extract(self.archive, self.destination)

    def test_rejects_nonempty_destination(self):
        self.make_archive()
        (self.destination / 'keep').write_text('persistent')
        with self.assertRaises(ValueError):
            archive_guard.extract(self.archive, self.destination)
        self.assertEqual((self.destination / 'keep').read_text(), 'persistent')


class FakeDeployment(worker.Deployment):
    def __init__(self, root, state, fail_at=None, head=SHA):
        super().__init__(root, state, state / 'fixed-control')
        self.fail_at = fail_at
        self.head = head
        self.events = []

    def event(self, name):
        self.events.append(name)
        if self.fail_at == name:
            raise RuntimeError('fixture_failure')

    def fetch_archive(self, sha, archive):
        self.event('fetch')
        with tarfile.open(archive, 'w:gz') as output:
            for name in ['artisan', 'composer.lock', 'package-lock.json', 'public/index.php', 'tests/Pest.php']:
                entry = tarfile.TarInfo(name)
                entry.size = 2
                output.addfile(entry, io.BytesIO(b'{}'))

    def build(self, release):
        self.event('build')
        if (release / '.env').exists():
            raise AssertionError('production environment exposed before testing')

    def backup(self, release):
        self.event('backup')

    def run(self, arguments, **kwargs):
        if 'migrate' in arguments:
            self.event('migrate')
        else:
            raise AssertionError('unexpected real command in deployment test')

    def remote_head(self):
        return self.head

    def reload_php(self):
        self.events.append('reload')

    def health(self, release):
        if release.name.startswith('auto-'):
            self.event('health')
        else:
            self.events.append('rollback_health')

    def switch(self, release, name='current'):
        # Windows tests may lack symlink creation privileges. Model the atomic
        # pointer here; separate Linux acceptance exercises the actual symlink.
        self.events.append('switch_' + name + ':' + release.name)
        self.pointers[name] = release.resolve()

    def release_path(self, path):
        # Production path validation is tested independently below.
        return Path(path).resolve()


class WorkerTests(unittest.TestCase):
    def setUp(self):
        self.temp = tempfile.TemporaryDirectory()
        self.base = Path(self.temp.name)
        self.root, self.state = self.base / 'app', self.base / 'state'
        self.current = self.root / 'current'
        self.current.mkdir(parents=True)
        (self.current / 'artisan').write_text('fixture')
        (self.root / 'releases').mkdir()
        for name in ['results', 'logs', 'jobs', 'backups']:
            (self.state / name).mkdir(parents=True, exist_ok=True)

    def tearDown(self):
        self.temp.cleanup()

    def deployer(self, **kwargs):
        obj = FakeDeployment(self.root, self.state, **kwargs)
        obj.pointers = {'current': self.current.resolve()}
        return obj

    def test_success_runs_gates_in_order(self):
        obj = self.deployer()
        result = obj.deploy(SHA)
        self.assertEqual(result['status'], 'succeeded')
        self.assertEqual(obj.events[:4], ['fetch', 'build', 'backup', 'migrate'])
        self.assertIn('health', obj.events)
        self.assertEqual((obj.pointers['current'] / 'REVISION').read_text().strip(), SHA)
        self.assertEqual(worker.read_json(self.state / 'last-success.json')['sha'], SHA)

    def test_failed_build_never_backs_up_migrates_or_switches(self):
        obj = self.deployer(fail_at='build')
        self.assertEqual(obj.deploy(SHA)['status'], 'failed')
        self.assertEqual(obj.events, ['fetch', 'build'])
        self.assertEqual(obj.pointers['current'], self.current.resolve())
        self.assertEqual(list((self.root / 'releases').iterdir()), [])

    def test_migration_failure_does_not_activate(self):
        obj = self.deployer(fail_at='migrate')
        self.assertEqual(obj.deploy(SHA)['status'], 'failed')
        self.assertEqual(obj.events, ['fetch', 'build', 'backup', 'migrate'])
        self.assertEqual(obj.pointers['current'], self.current.resolve())

    def test_health_failure_rolls_back_code_without_schema_rollback(self):
        obj = self.deployer(fail_at='health')
        result = obj.deploy(SHA)
        self.assertEqual(result['status'], 'failed')
        self.assertTrue(result['rolled_back'])
        self.assertEqual(obj.pointers['current'], self.current.resolve())
        self.assertEqual(obj.events.count('migrate'), 1)
        self.assertIn('rollback_health', obj.events)

    def test_advanced_production_is_not_activated(self):
        obj = self.deployer(head=OTHER_SHA)
        self.assertEqual(obj.deploy(SHA)['status'], 'superseded')
        self.assertEqual(obj.events, ['fetch', 'build'])

    def test_failed_sha_is_not_rebuilt_without_explicit_retry(self):
        first = self.deployer(fail_at='build')
        first.deploy(SHA)
        second = self.deployer()
        self.assertEqual(second.deploy(SHA)['status'], 'failed')
        self.assertEqual(second.events, [])
        self.assertEqual(second.deploy(SHA, retry=True)['status'], 'succeeded')

    def test_same_successful_sha_is_a_noop(self):
        (self.current / 'REVISION').write_text(SHA)
        worker.atomic_json(self.state / 'last-success.json', {'sha': SHA})
        obj = self.deployer()
        self.assertEqual(obj.deploy(SHA)['status'], 'unchanged')
        self.assertEqual(obj.events, [])

    def test_invalid_commit_rejected_before_commands(self):
        obj = self.deployer()
        for value in ['main', '../bad', 'a' * 39, ';reboot']:
            with self.subTest(value=value), self.assertRaises(RuntimeError):
                obj.deploy(value)
        self.assertEqual(obj.events, [])

    def test_real_release_guard_rejects_outside_project(self):
        obj = worker.Deployment(self.root, self.state)
        with self.assertRaises(RuntimeError):
            obj.release_path(self.current)

    def test_production_advancing_after_migration_does_not_activate_stale_code(self):
        obj = self.deployer()
        with patch.object(obj, 'remote_head', side_effect=[SHA, OTHER_SHA]):
            result = obj.deploy(SHA)
        self.assertEqual(result['status'], 'superseded')
        self.assertEqual(obj.events, ['fetch', 'build', 'backup', 'migrate'])

    def test_remote_identity_cannot_select_another_branch(self):
        obj = worker.Deployment(self.root, self.state)
        with patch.object(obj, 'run', return_value=SHA + '\trefs/heads/main'):
            with self.assertRaises(RuntimeError):
                obj.remote_head()

    @unittest.skipIf(os.name == 'nt', 'Native symlink acceptance runs on Linux')
    def test_native_activation_and_health_failure_rollback(self):
        prior = self.root / 'releases' / 'original'
        self.current.rename(prior)
        self.current.symlink_to(prior)
        obj = self.deployer(fail_at='health')
        obj.switch = lambda target, name='current': worker.Deployment.switch(obj, target, name)
        obj.release_path = lambda target: worker.Deployment.release_path(obj, target)
        result = obj.deploy(SHA)
        self.assertTrue(result['rolled_back'])
        self.assertEqual(self.current.resolve(), prior.resolve())

    @unittest.skipIf(os.name == 'nt', 'Native symlink acceptance runs on Linux')
    def test_interrupted_activation_recovers_previous_release(self):
        prior = self.root / 'releases' / 'original'
        self.current.rename(prior)
        candidate = self.root / 'releases' / ('auto-fixture-' + SHA[:12])
        candidate.mkdir()
        (candidate / 'artisan').write_text('fixture')
        self.current.symlink_to(candidate)
        worker.atomic_json(self.state / 'last-attempt.json', {
            'status': 'running', 'sha': SHA, 'previous': prior.name,
            'release': candidate.name, 'stage': 'health'})
        obj = self.deployer()
        obj.switch = lambda target, name='current': worker.Deployment.switch(obj, target, name)
        obj.release_path = lambda target: worker.Deployment.release_path(obj, target)
        obj.recover_interrupted()
        self.assertEqual(self.current.resolve(), prior.resolve())
        self.assertEqual(worker.read_json(self.state / 'results' / (SHA + '.json'))['status'], 'failed')

    def test_service_is_unprivileged_and_only_pricing_is_writable(self):
        service = (DEPLOYMENT / 'togoo-pricing-deploy.service').read_text()
        self.assertIn('User=togoo-pricing-deploy', service)
        self.assertIn('NoNewPrivileges=true', service)
        self.assertIn('ReadWritePaths=/var/www/togoo-pricing /var/lib/togoo-pricing-deploy', service)
        broker = (DEPLOYMENT / 'reload-broker.py').read_text()
        self.assertIn("'reload', 'togoo-pricing-php.service'", broker)
        self.assertNotIn('nginx', broker)


if __name__ == '__main__':
    unittest.main()
