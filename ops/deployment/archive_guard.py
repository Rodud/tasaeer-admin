"""Extract a Git code archive without importing credentials or persistent data."""
from pathlib import Path, PurePosixPath
import shutil
import tarfile


def extract(archive, destination):
    destination = Path(destination)
    if not destination.is_dir() or any(destination.iterdir()):
        raise ValueError('release_directory_not_empty')
    with tarfile.open(archive, 'r:gz') as source:
        members = source.getmembers()
        if len(members) > 20000 or sum(m.size for m in members) > 268435456:
            raise ValueError('archive_limit')
        seen = set()
        for member in members:
            path = PurePosixPath(member.name)
            if (path.is_absolute() or '..' in path.parts or '\\' in member.name
                    or member.name in seen or not (member.isdir() or member.isfile())):
                raise ValueError('unsafe_archive_member')
            seen.add(member.name)
            if not path.parts:
                continue
            if (path.parts[0] in ['vendor', 'node_modules', '.git']
                    or any(p.startswith('.env') and p != '.env.example' for p in path.parts)
                    or (path.parts[0] == 'database' and path.suffix in ['.sqlite', '.sql'])
                    or (path.parts[0] == 'bootstrap' and 'cache' in path.parts and member.isfile() and path.name != '.gitignore')
                    or (path.parts[0] == 'storage' and member.isfile() and path.name != '.gitignore')
                    or member.name == 'public/hot' or member.name.startswith('public/storage/')):
                raise ValueError('private_or_generated_archive_content')
        for member in members:
            target = destination / member.name
            if member.isdir():
                target.mkdir(parents=True, exist_ok=True)
                target.chmod(0o755)
            else:
                target.parent.mkdir(parents=True, exist_ok=True)
                with source.extractfile(member) as input_file, target.open('xb') as output:
                    shutil.copyfileobj(input_file, output)
                target.chmod(0o644)
    for name in ['artisan', 'composer.lock', 'package-lock.json', 'public/index.php', 'tests/Pest.php']:
        if not (destination / name).is_file():
            raise ValueError('incomplete_source_release')
