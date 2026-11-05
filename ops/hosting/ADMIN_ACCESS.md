# Pricing administrator access

Public visitors use the quote calculator without accounts. Public registration
is disabled. Administrative pages, data exports and mutations require both an
authenticated session and an explicit `users.is_admin` flag. Existing accounts
are not promoted by the migration. Login accepts administrators only.

On the pricing host, run this in your own interactive SSH terminal:

```bash
sudo -u togoo-pricing /usr/bin/php8.5 /var/www/togoo-pricing/current/artisan pricing:admin
```

Enter your email, name and password directly in the terminal. Password prompts
are hidden; a new password must be at least 12 characters and match its hidden
confirmation. For an existing account, an empty password keeps its current
password. The command creates or promotes only the specified account. It does
not print credentials or accept them as shell arguments.

Then open `https://pricing.rodud.com/login`. Public registration must continue
to return 404. Ordinary accounts, including pre-existing sessions, must receive
403 on administrative endpoints. Do not grant roles through request payloads.

Deploy this additive migration and code together to the isolated pricing
application. Never restart shared Nginx or any other hosted application's
services for this change. No automatic deployment from GitHub is configured yet.
