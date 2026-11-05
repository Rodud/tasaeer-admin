# Original hosting/migration record

These files describe the one-time migration of the pricing application and the
original pro static page. They are not the routine update mechanism. See
`docs/AUTOMATIC_DEPLOYMENT.md` for normal production releases.

- Pricing has its own PHP-FPM service, socket, database, environment and storage.
- Pro is an independent static site; code deployments of pricing do not update it.
- `pro-site/public/` preserves the eight original public files. The old public
  directory's symlink to an Nginx configuration file was intentionally excluded.
- The migration preserved existing application data and APP_KEY. Private database
  dumps, environmental configuration and certificate keys are not in this repo.
- `source-forward.py`, ACME bootstrap helpers and Nginx activation scripts are
  historical operator tools. They require explicit source/host authorization;
  never run them as application deployment steps.
- A temporary HTTP compatibility bridge was retired after the hostname-specific
  strict origin TLS rule was enabled. It is not part of the final configuration.
- The owner reports Google Cloud health-based automatic recovery on the old
  source server. Verify the actual probe and thresholds before any future
  authorized migration; routine production updates never contact that host.

Migration acceptance compared exact business-table counts and content hashes,
checked trusted HTTPS on the public hosts, verified renewal dry-runs, and checked
the existing co-hosted sites. Date: 2026-11-05. Historical evidence does not
replace a new health check before an operator action.
