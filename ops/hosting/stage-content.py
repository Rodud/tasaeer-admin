import os,sys,tarfile,shutil,json,re,subprocess,secrets,grp,hashlib
from pathlib import Path,PurePosixPath
assert os.geteuid()==0
base=Path('/var/www/togoo-pricing'); release=base/'releases/20261105-da841e905f49'
pro=Path('/var/www/togoo-pro/releases/20261105-original')
assert not (base/'current').exists() and not Path('/var/www/togoo-pro/current').exists()
def extract(source,dest):
 dest.mkdir(parents=True,mode=0o755,exist_ok=True)
 with tarfile.open(source) as tar:
  for m in tar:
   path=PurePosixPath(m.name)
   if path.is_absolute() or '..' in path.parts: raise RuntimeError('unsafe archive path')
   if m.issym() and str(path)=='public/storage':continue
   if m.issym() and str(path)=='rodud-go' and m.linkname=='/etc/nginx/sites-available/rodud-go':continue
   if not(m.isdir() or m.isfile()):raise RuntimeError('unsupported archive member')
   q=dest.joinpath(*path.parts)
   if m.isdir():q.mkdir(exist_ok=True,parents=True);os.chmod(q,0o755)
   else:
    q.parent.mkdir(exist_ok=True,parents=True)
    if q.exists():
     with tar.extractfile(m) as i:
      if hashlib.sha256(i.read()).digest()!=hashlib.sha256(q.read_bytes()).digest():raise RuntimeError('existing staging file differs')
    else:
     with tar.extractfile(m) as i,q.open('xb') as o:shutil.copyfileobj(i,o)
    os.chmod(q,0o644)
extract('/var/lib/togoo-pricing/incoming/pricing.tar.gz',release)
extract('/var/lib/togoo-pricing/incoming/pro.tar.gz',pro/'public')
assert (release/'artisan').is_file() and (release/'.env').is_file()
# Retain the existing application key and business settings. Never log env values.
password=secrets.token_hex(32)
sql="CREATE DATABASE `website_pricing` CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci; CREATE USER 'togoo_pricing'@'localhost' IDENTIFIED BY '"+password+"'; GRANT ALL PRIVILEGES ON `website_pricing`.* TO 'togoo_pricing'@'localhost';"
r=subprocess.run(['mariadb'],input=sql,text=True,capture_output=True)
if r.returncode: raise RuntimeError('isolated database/account creation failed')
env=(release/'.env').read_text()
replacements={'APP_ENV':'production','APP_DEBUG':'false','APP_URL':'https://pricing.rodud.com','APP_MAINTENANCE_DRIVER':'file','DB_HOST':'localhost','DB_PORT':'3306','DB_DATABASE':'website_pricing','DB_USERNAME':'togoo_pricing','DB_PASSWORD':password,'CACHE_STORE':'database','QUEUE_CONNECTION':'database','SESSION_DRIVER':'database','SESSION_DOMAIN':'pricing.rodud.com','SESSION_COOKIE':'togoo_pricing_session','SESSION_SECURE_COOKIE':'true'}
for k,v in replacements.items():
 line=k+'='+v
 pattern=r'^\s*'+k+r'\s*=.*$'
 env=re.sub(pattern,lambda m:line,env,flags=re.M) if re.search(pattern,env,re.M) else env.rstrip()+'\n'+line+'\n'
shared=base/'shared';envpath=shared/'.env';envpath.write_text(env);os.chmod(envpath,0o640);os.chown(envpath,0,grp.getgrnam('togoo-pricing').gr_gid)
(release/'.env').unlink();(release/'.env').symlink_to(envpath)
shutil.move(str(release/'storage'),str(shared/'storage'));(release/'storage').symlink_to(shared/'storage')
for d in ['framework/cache/data','framework/sessions','framework/views','logs','app/private','app/public']:(shared/'storage'/d).mkdir(parents=True,exist_ok=True)
(release/'public/storage').symlink_to(shared/'storage/app/public')
(release/'bootstrap/cache').mkdir(parents=True,exist_ok=True)
subprocess.run(['chown','-R','togoo-pricing:togoo-pricing',str(release),str(shared/'storage')],check=True)
# Shared storage stays private to this application; Nginx may read public uploads.
subprocess.run(['chmod','-R','u+rwX,g+rX,o-rwx',str(shared/'storage')],check=True)
os.chmod(shared/'storage',0o751);os.chmod(shared/'storage/app',0o751)
for q in [shared/'storage/app/public']:
 for root,dirs,files in os.walk(q):
  os.chmod(root,0o755)
  for f in files:os.chmod(Path(root,f),0o644)
(base/'current').symlink_to(release)
Path('/var/www/togoo-pro/current').symlink_to(pro)
manifest={str(x.relative_to(pro/'public')):{'bytes':x.stat().st_size,'sha256':hashlib.sha256(x.read_bytes()).hexdigest()} for x in (pro/'public').rglob('*') if x.is_file()}
Path('/etc/togoo-pricing/pro-source-manifest.json').write_text(json.dumps(manifest))
print(json.dumps({'source_revision':'da841e905f49','pro_files':len(manifest),'database':'website_pricing','isolation':'dedicated account and env; APP_KEY preserved'}))
