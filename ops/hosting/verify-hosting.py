import urllib.request,urllib.error,json,re,hashlib,subprocess
from pathlib import Path

def get(url):
 with urllib.request.urlopen(urllib.request.Request(url,headers={'User-Agent':'ToGoo-Migration-Acceptance/1.0'}),timeout=20) as r:return r.status,r.headers,r.read()
checks={}
for base,header,expected in [('https://pricing.rodud.com','X-ToGoo-Pricing-Origin','cp-isolated-20261105'),('https://www.pricing.rodud.com','X-ToGoo-Pricing-Origin','cp-isolated-20261105'),('https://pro.togoo.sa','X-ToGoo-Pro-Origin','cp-static-20261105')]:
 code,headers,body=get(base+'/');assert code==200 and headers.get(header)==expected,base
 checks[base]='200 / new origin / trusted TLS'
for path in ['/login','/pricing-data','/api/pricing','/up']:
 code,headers,body=get('https://pricing.rodud.com'+path);assert code==200,path
 if 'pricing' in path: assert isinstance(json.loads(body)['lanes'],list)
for path in ['/admin','/admin/quotes','/admin/pricing']:
 with urllib.request.urlopen(urllib.request.Request('https://pricing.rodud.com'+path,headers={'User-Agent':'ToGoo-Migration-Acceptance/1.0'}),timeout=20) as r:assert r.url.endswith('/login'),path
manifest=json.loads(Path('/etc/togoo-pricing/pro-source-manifest.json').read_text())
for name,m in manifest.items():
 content=Path('/var/www/togoo-pro/current/public',name).read_bytes();assert hashlib.sha256(content).hexdigest()==m['sha256'],name
 code,h,public=get('https://pro.togoo.sa/'+name)
 if name.endswith('.html'):
  clean=lambda x:re.sub(r'>\s+<','><',re.sub(r'<script\b[^>]*\bsrc="https://static.cloudflareinsights.com/[^"]*"[^>]*>\s*</script>','',x.decode(),flags=re.S))
  assert clean(public)==clean(content),name
 elif name!='robots.txt':assert public==content,name
for path in ['/.env','/.git/config','/index.html.bak','/probe.php']:
 try:get('https://pricing.rodud.com'+path);raise AssertionError('sensitive path served: '+path)
 except urllib.error.HTTPError as e:assert e.code in [403,404]
for url in ['https://portal.togoo.sa/up','https://togoo.sa/','https://subscription.togoo.sa/agreement','https://www.rodudapp.com/']:
 assert get(url)[0]==200,url;checks[url]='200'
print(json.dumps({'checks':checks,'static_files_unchanged':len(manifest),'pricing_pages_and_auth_redirects':'pass','sensitive_paths':'denied'}))
