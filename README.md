# Rodud transport pricing portal

Public Arabic/English transport quote calculator at https://pricing.rodud.com.
Customers select a route, truck and cargo, receive an estimate, and can submit
their contact details and open a WhatsApp message for the operations team.
Administrators manage quote statuses and lane prices through `/admin`.

- Application: Laravel 13 / PHP 8.5; Blade / Vite frontend.
- Repository: https://github.com/Rodud/tasaeer-admin
- Development branch: `main`.
- Live release branch: `production`.
- [How to test, publish, monitor and recover a release](docs/AUTOMATIC_DEPLOYMENT.md).
- [Create or promote an administrator privately](ops/hosting/ADMIN_ACCESS.md).

Public registration is disabled. Administrative pages, exports and updates
require an explicitly provisioned administrator. The public calculator does
not require a customer account.

## Local verification

Use PHP 8.5, Composer 2.10.2, Node 24.19.0 and npm 11.17.0. Keep older workstation
runtimes unchanged. Install dependencies from both lockfiles, build the frontend,
and run `vendor/bin/pest --fail-on-warning` with an ephemeral test APP_KEY and
SQLite support. Tests use SQLite `:memory:`, not the production database.
Run `python -B -m unittest discover -s tests/Deployment -p "test_*.py" -v` for
deployment failure, isolation and archive validation tests.

Never commit `.env`, credentials, database dumps, vendor or generated build files.
The files in `ops/hosting/` record the original one-time migration; routine
updates use only the fixed installation in `ops/deployment/`. Do not rerun
migration, legacy forwarding, certificate bootstrap or Nginx setup scripts
to publish application changes.
