# Automatic pricing production deployment

## Daily publishing

1. Work on `main` in `Rodud/tasaeer-admin`. Commit application code, both lockfiles
   when dependencies change, tests and relevant documentation. Do not include
   environment files, databases, credentials or generated dependencies/assets.
2. Review and test the complete `main` change. Open a pull request from `main`
   into `production` and merge it after review. Opening a PR does not deploy.
3. Within approximately one minute after the currently running poll finishes,
   the pricing server notices the new `production` SHA. A push to `main` alone
   does not change the live site. A direct authorized push to `production` uses
   exactly the same server gates as a merged pull request.
4. Inspect the deployment result and verify the live page. No SSH connection
   is required to trigger a normal release.

## How delivery works

This public repository is fetched over verified HTTPS from its fixed GitHub URL.
The server needs no GitHub token, SSH deploy key, webhook secret, inbound upload
endpoint or GitHub Actions runner. GitHub Actions billing/availability is not a
delivery dependency: the server itself runs all mandatory verification steps.
`togoo-pricing-deploy.timer` checks only `refs/heads/production` every 60 seconds;
unchanged SHAs do not install dependencies, rebuild or reload any service.

The root-owned worker implementation is installed in `/etc/togoo-pricing-deploy`.
It runs as the non-login `togoo-pricing-deploy` account, scoped to this application's
directories, with no sudo permission, CPU/memory limits and a deployment lock.
It cannot update its own root-owned implementation from an application commit.
Changes to that infrastructure require a separately reviewed operator rollout.

## Release gates and steps

1. Fetch the exact production commit into a private bare repository and validate
   its code archive. Reject traversal, links, environment files, cached runtime
   configuration, database dumps and dependency directories.
2. Create a fresh release while the current site keeps serving. Composer validate
   and locked-dependency audit must pass. Install the locked development packages.
3. Run `npm ci --ignore-scripts`, the high/critical npm vulnerability gate, and
   `npm run build` using the pinned Node/npm toolchain. Require a build manifest.
4. Run all Pest tests and Python deployment tests. Tests use fresh, disposable
   storage and SQLite `:memory:` without the production `.env` or storage links.
   The SQLite extension is loaded only into the test CLI process; no global PHP
   or FPM configuration is changed.
5. Install locked production Composer packages and verify platform requirements.
   Replace disposable storage with links to this site's shared `.env` and data.
   Build package, configuration, route and view caches. Check database identity
   and the administrative authorization boundaries.
6. Recheck that production still points to this SHA. If it advanced during the
   build, discard this unactivated candidate and build the latest on the next poll.
7. Back up **website_pricing only**, privately, using a short-lived 0600 client
   options file. Credentials are never put in command arguments or logs.
8. Run `migrate --force` for this application, write `REVISION`, and switch the
   `current` symlink atomically. Reload **togoo-pricing-php.service only** through
   a fixed root-owned reload broker. Verify local HTTPS using normal certificate
   validation, the public calculator, login, administrative redirects, closed
   registration, database access and route authorization.
9. On success, retain the former release as `previous` and record the SHA/result.

No deployment step restarts or reloads Nginx, MariaDB, Redis, Control Plane,
ToGoo Website, Subscription, pro or customer Node services. No legacy host is
contacted. Application data and the administrator accounts remain in the
existing database; code releases never import or seed a replacement database.

## Migration and failure rules

The site stays online during preparation and migrations. Use backward-compatible
expand/contract migrations: add new nullable/defaulted fields before requiring
them, and defer destructive changes until old code is no longer needed. Deployment
cannot make an arbitrary destructive migration reversible. Never run fresh,
reset, seed or automatic schema rollback on this production database.

A preparation/test failure leaves the current site untouched. A failure after
activation switches back to the previous code release, reloads only pricing PHP,
and checks its health. Database migrations are **not** reversed automatically;
the backup is retained for an operator's explicit recovery decision. An interrupted
worker is reconciled on the next run. A failed SHA is not rebuilt indefinitely;
correct the problem and merge a new commit, or explicitly retry the current SHA.
Backups, deployment logs and result records are private and are not automatically
purged. Manage retention only through an approved maintenance operation.

## Observe and retry

```bash
sudo systemctl status togoo-pricing-deploy.timer togoo-pricing-deploy.service
sudo journalctl -u togoo-pricing-deploy.service -n 30 --no-pager
sudo cat /var/lib/togoo-pricing-deploy/last-attempt.json
sudo cat /var/lib/togoo-pricing-deploy/last-success.json
sudo cat /var/www/togoo-pricing/current/REVISION
```

Private per-release logs, results and database backups are under
`/var/lib/togoo-pricing-deploy/{logs,results,backups}`. Do not share their contents
without review. A failed systemd unit alone is not proof the public site is down;
inspect the recorded stage/rollback result and HTTP health.

To retry after correcting a host/tool/network problem without changing code:

```bash
sudo -u togoo-pricing-deploy /usr/bin/python3 -B /etc/togoo-pricing-deploy/worker.py --retry
```

This still fetches and tests only the current production head and respects the
deployment lock. It accepts no arbitrary SHA, repository, command or service name.
For a normal rollback, revert the problem in `main` and merge that complete branch
back to `production`. The fix/revert passes the same tests as every other release.

## One-time setup and acceptance

An authorized operator installs the reviewed bundle with
`ops/deployment/install-automatic.bash`, including the matching packaged CLI-only
SQLite extension. The installer creates only the pricing deploy account, state
directories, fixed scripts and systemd units; it does not alter Nginx or other
applications. It leaves the timer disabled until the reviewed production branch
exists. Then enable it with `sudo systemctl enable --now togoo-pricing-deploy.timer`.

Acceptance must include an actual subsequent documentation-only `main` to
`production` merge, automatic success, matching live `REVISION`, and a hash
comparison proving this document arrived in the live release. A manual file copy
or manual worker invocation is not that acceptance test.
