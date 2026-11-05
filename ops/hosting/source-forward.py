import re,sys,shutil,subprocess
from pathlib import Path
origin=sys.argv[1]
assert re.fullmatch(r'(?:\d{1,3}\.){3}\d{1,3}',origin)
site=Path('/etc/nginx/sites-enabled/tasaeer-admin')
backup=Path('/root/togoo-pricing-migration-20261105/nginx.before')
backup.parent.mkdir(mode=0o700,exist_ok=True)
assert not backup.exists(), 'source forwarding already configured'
original=site.read_text();backup.write_text(original);backup.chmod(0o600)
blocks=[];start=0
for m in re.finditer(r'(?m)^server\s*\{',original):
 if m.start()<start:continue
 depth=0;end=None
 for i in range(original.index('{',m.start()),len(original)):
  if original[i]=='{':depth+=1
  elif original[i]=='}':
   depth-=1
   if depth==0:end=i+1;break
 assert end is not None
 blocks.append(original[m.start():end]);start=end
changed=[];count=0
for block in blocks:
 if not re.search(r'server_name\s+pricing\.rodud\.com(?:\s|;)',block):changed.append(block);continue
 tls='listen 443 ssl;\n ssl_certificate /etc/letsencrypt/live/pricing.rodud.com/fullchain.pem;\n ssl_certificate_key /etc/letsencrypt/live/pricing.rodud.com/privkey.pem;' if re.search(r'listen\s+443',block) else 'listen 80;'
 changed.append('''server {
 %s
 server_name pricing.rodud.com www.pricing.rodud.com;
 location / {
  proxy_pass https://%s;
  proxy_set_header Host pricing.rodud.com;
  proxy_set_header X-Forwarded-Proto https;
  proxy_set_header X-Forwarded-For $proxy_add_x_forwarded_for;
  proxy_ssl_server_name on;
  proxy_ssl_name pricing.rodud.com;
  proxy_ssl_verify on;
  proxy_ssl_verify_depth 3;
  proxy_ssl_trusted_certificate /etc/ssl/certs/ca-certificates.crt;
  proxy_connect_timeout 5s;
  proxy_read_timeout 60s;
 }
}'''%(tls,origin));count+=1
assert count==2
site.write_text('\n'.join(changed)+'\n')
if subprocess.run(['nginx','-t']).returncode:
 shutil.copyfile(backup,site);raise RuntimeError('source configuration restored after failed validation')
subprocess.run(['systemctl','reload','nginx'],check=True)
print('SOURCE_PRICING_FORWARDING_TO_NEW_ORIGIN')
