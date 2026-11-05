import sys,subprocess,json,hashlib,re
schema=sys.argv[1]
assert schema in ['tasaeer','website_pricing']
names=['users','quotes','pricing_lanes','pricing_settings','migrations','jobs','job_batches','failed_jobs','password_reset_tokens']
result={}
for table in names:
 r=subprocess.run(['mariadb','--batch','--skip-column-names','--raw','-e',f'SELECT * FROM `{schema}`.`{table}` ORDER BY 1'],capture_output=True)
 if r.returncode:raise RuntimeError('database proof failed')
 count=subprocess.check_output(['mariadb','--batch','--skip-column-names','-e',f'SELECT COUNT(*) FROM `{schema}`.`{table}`'],text=True).strip()
 result[table]={'rows':int(count),'sha256':hashlib.sha256(r.stdout).hexdigest()}
print(json.dumps(result,sort_keys=True))
