#!/usr/bin/env python3
"""Public GitHub production polling; isolated, unprivileged pricing deployment."""
import argparse
import base64
import gzip
import json
import os
from pathlib import Path
import re
import secrets
import shutil
import subprocess
import sys
import time

from archive_guard import extract

REPOSITORY = 'https://github.com/Rodud/tasaeer-admin.git'
PRODUCTION_REF = 'refs/heads/production'
ROOT = Path('/var/www/togoo-pricing')
STATE = Path('/var/lib/togoo-pricing-deploy')
CONTROL = Path('/etc/togoo-pricing-deploy')
PHP = '/usr/bin/php8.5'
COMPOSER = '/opt/togoo/toolchain/bin/composer'
NODE = '/opt/togoo/toolchain/bin/node'
NPM = '/opt/togoo/toolchain/bin/npm'


def valid_sha(value):
    return isinstance(value, str) and re.fullmatch(r'[0-9a-f]{40}', value) is not None


def atomic_json(path, data):
    temporary = path.with_name(path.name + '.new')
    with temporary.open('w', encoding='utf-8') as output:
        json.dump(data, output)
    temporary.chmod(0o640)
    temporary.replace(path)


def read_json(path):
    return json.loads(path.read_text()) if path.is_file() else {}


class Deployment:
    def __init__(self, root=ROOT, state=STATE, control=CONTROL):
        self.root, self.state, self.control = Path(root), Path(state), Path(control)
        self.environment = {
            'HOME': str(self.state), 'COMPOSER_HOME': str(self.state / 'composer'),
            'COMPOSER_NO_INTERACTION': '1', 'GIT_TERMINAL_PROMPT': '0',
            'GIT_CONFIG_NOSYSTEM': '1', 'GIT_CONFIG_GLOBAL': '/dev/null',
            'PATH': '/opt/togoo/toolchain/bin:/usr/bin:/bin', 'LANG': 'C.UTF-8',
            'NPM_CONFIG_CACHE': str(self.state / 'npm-cache'),
        }
        self.result = {}
        self.log = None

    def run(self, arguments, cwd=None, environment=None, timeout=600, capture=False):
        output = subprocess.run(arguments, cwd=cwd,
            env=environment if environment is not None else self.environment,
            stdin=subprocess.DEVNULL, stdout=subprocess.PIPE if capture else self.log,
            stderr=self.log, timeout=timeout, check=False)
        if output.returncode:
            raise RuntimeError('release_step_failed')
        return output.stdout.decode().strip() if capture else None

    def remote_head(self):
        value = self.run(['/usr/bin/git', '-c', 'credential.helper=', 'ls-remote',
            '--exit-code', REPOSITORY, PRODUCTION_REF], timeout=40, capture=True)
        parts = value.split()
        if len(parts) != 2 or not valid_sha(parts[0]) or parts[1] != PRODUCTION_REF:
            raise RuntimeError('invalid_production_reference')
        return parts[0]

    def stage(self, name, **extra):
        self.result.update(stage=name, **extra)
        atomic_json(self.state / 'last-attempt.json', self.result)
        if self.log:
            self.log.write(('\nSTEP ' + name + '\n').encode())

    def release_path(self, path):
        path = Path(path)
        if path.is_symlink() or path.resolve().parent != (self.root / 'releases').resolve():
            raise RuntimeError('unsafe_release_path')
        if not (path / 'artisan').is_file():
            raise RuntimeError('incomplete_release_path')
        return path.resolve()

    def switch(self, release, name='current'):
        release = self.release_path(release)
        temporary = self.root / (name + '.deploy-' + secrets.token_hex(6))
        temporary.symlink_to(release)
        temporary.replace(self.root / name)

    def reload_php(self):
        nonce = secrets.token_hex(32)
        atomic_json(self.state / 'reload.request', {'nonce': nonce})
        deadline = time.monotonic() + 40
        while time.monotonic() < deadline:
            result = read_json(Path('/run/togoo-pricing-deploy/reload-result.json'))
            if result.get('nonce') == nonce:
                if not result.get('success'):
                    raise RuntimeError('pricing_php_reload_failed')
                return
            time.sleep(0.25)
        raise RuntimeError('pricing_php_reload_timeout')

    def health(self, release):
        self.run([PHP, str(self.control / 'health-probe.php'), str(release)], timeout=30)
        for path, expected in [('/', 200), ('/up', 200), ('/login', 200),
                ('/pricing-data', 200), ('/api/pricing', 200), ('/register', 404),
                ('/admin', 302), ('/quotes', 302), ('/quotes.csv', 302)]:
            status = self.run(['/usr/bin/curl', '--noproxy', '*', '--silent', '--show-error',
                '--connect-timeout', '4', '--max-time', '15', '--resolve',
                'pricing.rodud.com:443:127.0.0.1', '--output', '/dev/null',
                '--write-out', '%{http_code}', 'https://pricing.rodud.com' + path],
                timeout=20, capture=True)
            if status != str(expected):
                raise RuntimeError('pricing_http_health_failed')

    def build(self, release):
        # The test checkout has no production .env or storage symlinks.
        for name in ['framework/cache/data', 'framework/sessions', 'framework/views', 'logs', 'app/private', 'app/public']:
            (release / 'storage' / name).mkdir(parents=True, exist_ok=True)
        test_env = dict(self.environment, APP_ENV='testing', APP_DEBUG='false',
            APP_KEY='base64:' + base64.b64encode(secrets.token_bytes(32)).decode(),
            DB_CONNECTION='sqlite', DB_DATABASE=':memory:', DB_URL='',
            DB_HOST='', DB_USERNAME='', DB_PASSWORD='', SESSION_DRIVER='array',
            CACHE_STORE='array', QUEUE_CONNECTION='sync', MAIL_MAILER='array',
            LOG_CHANNEL='single', BCRYPT_ROUNDS='4')
        def run(arguments, timeout=600):
            return self.run(arguments, cwd=release, environment=test_env, timeout=timeout)
        self.stage('validate_locked_dependencies')
        run([COMPOSER, 'validate', '--strict'])
        run([COMPOSER, 'audit', '--locked', '--no-interaction'])
        run([COMPOSER, 'install', '--prefer-dist', '--no-interaction', '--no-progress', '--no-scripts'])
        run([PHP, 'artisan', 'package:discover', '--no-interaction'])
        self.stage('build_frontend')
        run([NPM, 'ci', '--ignore-scripts'], timeout=360)
        run([NPM, 'audit', '--audit-level=high'], timeout=90)
        run([NPM, 'run', 'build'], timeout=240)
        if not (release / 'public/build/manifest.json').is_file():
            raise RuntimeError('frontend_manifest_missing')
        self.stage('test_isolated_release')
        run([PHP, '-d', 'extension=' + str(self.control / 'pdo_sqlite.so'),
            'vendor/bin/pest', '--compact', '--fail-on-warning'], timeout=240)
        run(['/usr/bin/python3', '-B', '-m', 'unittest', 'discover',
            '-s', 'tests/Deployment', '-p', 'test_*.py', '-v'], timeout=90)
        self.stage('install_production_dependencies')
        run([COMPOSER, 'install', '--no-dev', '--prefer-dist', '--no-interaction',
            '--no-progress', '--no-scripts', '--optimize-autoloader'])
        run([COMPOSER, 'check-platform-reqs', '--no-dev'])
        # Only this freshly built, validated release's disposable directories.
        for name in ['node_modules', 'storage']:
            disposable = release / name
            if disposable.is_symlink() or disposable.resolve().parent != release.resolve():
                raise RuntimeError('unsafe_build_cleanup')
            if disposable.is_dir():
                shutil.rmtree(disposable)
        if (release / '.env').exists() or (release / '.env').is_symlink():
            raise RuntimeError('unexpected_release_environment')
        (release / '.env').symlink_to(self.root / 'shared/.env')
        (release / 'storage').symlink_to(self.root / 'shared/storage')
        (release / 'public/storage').symlink_to(self.root / 'shared/storage/app/public')
        # Writable generated caches belong only to the pricing application group.
        cache = release / 'bootstrap/cache'
        cache.chmod(0o2770)
        for cached in cache.glob('*.php'):
            cached.unlink()
        self.stage('cache_production_configuration')
        for command in ['package:discover', 'config:cache', 'route:cache', 'view:cache']:
            self.run([PHP, 'artisan', command, '--no-interaction'], cwd=release, timeout=90)
        self.run([PHP, str(self.control / 'health-probe.php'), str(release)], timeout=30)

    def backup(self, release):
        backup = self.state / 'backups' / ('db-' + time.strftime('%Y%m%dT%H%M%SZ', time.gmtime()) + '-' + secrets.token_hex(4) + '.sql')
        self.run([PHP, str(self.control / 'backup-database.php'), str(release), str(backup)], timeout=120)
        with backup.open('rb') as source, gzip.open(str(backup) + '.gz', 'wb') as output:
            shutil.copyfileobj(source, output)
        Path(str(backup) + '.gz').chmod(0o600)
        backup.unlink()
        self.result['backup'] = backup.name + '.gz'

    def fetch_archive(self, sha, archive):
        repository = self.state / 'source.git'
        if not repository.exists():
            self.run(['/usr/bin/git', 'init', '--bare', str(repository)], timeout=30)
        self.run(['/usr/bin/git', '-C', str(repository), '-c', 'credential.helper=',
            '-c', 'core.hooksPath=/dev/null', 'fetch', '--no-tags', REPOSITORY,
            PRODUCTION_REF + ':' + PRODUCTION_REF], timeout=120)
        fetched = self.run(['/usr/bin/git', '-C', str(repository), 'rev-parse', PRODUCTION_REF], capture=True, timeout=15)
        if fetched != sha:
            raise RuntimeError('production_changed_during_fetch')
        self.run(['/usr/bin/git', '-C', str(repository), 'archive', '--format=tar.gz',
            '--output=' + str(archive), sha], timeout=40)

    def recover_interrupted(self):
        previous = read_json(self.state / 'last-attempt.json')
        if previous.get('status') != 'running':
            return
        prior = self.release_path(self.root / 'releases' / previous['previous'])
        current = self.release_path((self.root / 'current').resolve())
        if current.name == previous.get('release'):
            self.switch(prior)
            self.reload_php()
            self.health(prior)
        previous.update(status='failed', stage='interrupted_worker_recovered',
            completed_at=int(time.time()), rolled_back=current != prior)
        atomic_json(self.state / 'last-attempt.json', previous)
        if valid_sha(previous.get('sha')):
            atomic_json(self.state / 'results' / (previous['sha'] + '.json'), previous)

    def deploy(self, sha, retry=False):
        if not valid_sha(sha):
            raise RuntimeError('invalid_commit')
        last = read_json(self.state / 'last-success.json')
        current = self.release_path((self.root / 'current').resolve())
        existing = read_json(self.state / 'results' / (sha + '.json'))
        if (last.get('sha') == sha or existing.get('status') == 'succeeded') and (current / 'REVISION').is_file() and (current / 'REVISION').read_text().strip() == sha:
            if last.get('sha') != sha:
                atomic_json(self.state / 'last-success.json', existing)
            return {'status': 'unchanged', 'sha': sha}
        if existing.get('status') == 'failed' and not retry:
            return existing
        release = self.root / 'releases' / ('auto-' + time.strftime('%Y%m%dT%H%M%SZ', time.gmtime()) + '-' + sha[:12] + '-' + secrets.token_hex(3))
        archive = self.state / 'jobs' / (release.name + '.tar.gz')
        self.result = {'sha': sha, 'status': 'running', 'started_at': int(time.time()),
            'previous': current.name, 'release': release.name, 'stage': 'fetch_production'}
        activated = False
        try:
            with (self.state / 'logs' / (release.name + '.log')).open('ab', buffering=0) as self.log:
                self.stage('fetch_production')
                self.fetch_archive(sha, archive)
                release.mkdir(mode=0o755)
                release.chmod(0o755)
                extract(archive, release)
                self.build(release)
                self.stage('confirm_current_production')
                if self.remote_head() != sha:
                    self.result.update(status='superseded', stage='production_advanced_before_activation')
                    return self.result
                self.stage('backup_database')
                self.backup(release)
                # Backward-compatible migrations only: the old site stays online.
                self.stage('migrate')
                self.run([PHP, 'artisan', 'migrate', '--force', '--no-interaction'], cwd=release, timeout=180)
                (release / 'REVISION').write_text(sha + '\n')
                (release / 'REVISION').chmod(0o644)
                if self.remote_head() != sha:
                    self.result.update(status='superseded', stage='production_advanced_after_migration')
                    return self.result
                self.stage('activate')
                self.switch(release)
                activated = True
                self.reload_php()
                self.stage('health')
                self.health(release)
                self.switch(current, 'previous')
                self.result.update(status='succeeded', stage='healthy')
        except Exception as error:
            self.result.update(status='failed', error=type(error).__name__)
            if activated:
                try:
                    with (self.state / 'logs' / (release.name + '.log')).open('ab', buffering=0) as self.log:
                        self.switch(current)
                        self.reload_php()
                        self.health(current)
                    self.result['rolled_back'] = True
                except Exception:
                    self.result['rollback_failed'] = True
            # Failure keeps all database backups; schema is never rolled back.
        finally:
            self.log = None
            self.result['completed_at'] = int(time.time())
            atomic_json(self.state / 'last-attempt.json', self.result)
            atomic_json(self.state / 'results' / (sha + '.json'), self.result)
            if self.result.get('status') == 'succeeded':
                atomic_json(self.state / 'last-success.json', self.result)
            archive.unlink(missing_ok=True)
            if release.exists() and not activated and self.result.get('status') != 'succeeded':
                if not release.is_symlink() and release.parent.resolve() == (self.root / 'releases').resolve() and release.name.startswith('auto-'):
                    shutil.rmtree(release)
        return self.result


def main():
    import fcntl
    parser = argparse.ArgumentParser()
    parser.add_argument('--retry', action='store_true', help='Retry only the current production commit after correcting a failure')
    options = parser.parse_args()
    os.umask(0o027)
    with (STATE / 'worker.lock').open('a') as lock:
        try:
            fcntl.flock(lock, fcntl.LOCK_EX | fcntl.LOCK_NB)
        except BlockingIOError:
            print(json.dumps({'status': 'already_running'}))
            return
        deployment = Deployment()
        deployment.recover_interrupted()
        outcome = deployment.deploy(deployment.remote_head(), retry=options.retry)
        print(json.dumps({k: outcome.get(k) for k in ['sha', 'status', 'stage', 'rolled_back', 'rollback_failed']}))
        if outcome.get('status') == 'failed':
            sys.exit(1)


if __name__ == '__main__':
    main()
