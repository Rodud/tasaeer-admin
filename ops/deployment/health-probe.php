<?php
declare(strict_types=1);

$release = $argv[1] ?? '';
if (PHP_SAPI !== 'cli' || !preg_match('#\A/var/www/togoo-pricing/releases/[a-zA-Z0-9-]+\z#D', $release)) {
    exit(2);
}
try {
    require $release.'/vendor/autoload.php';
    $app = require $release.'/bootstrap/app.php';
    $app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();
    $config = config('database.connections.'.config('database.default'));
    if (($config['driver'] ?? '') !== 'mysql' || ($config['database'] ?? '') !== 'website_pricing') {
        throw new RuntimeException('unexpected_database');
    }
    Illuminate\Support\Facades\DB::select('SELECT 1');
    if (!Illuminate\Support\Facades\Schema::hasColumn('users', 'is_admin') || !Illuminate\Support\Facades\Gate::has('access-admin')) {
        throw new RuntimeException('administration_gate_missing');
    }
    $ordinary = (new App\Models\User)->forceFill(['is_admin' => false]);
    $administrator = (new App\Models\User)->forceFill(['is_admin' => true]);
    if (Illuminate\Support\Facades\Gate::forUser($ordinary)->allows('access-admin')
        || !Illuminate\Support\Facades\Gate::forUser($administrator)->allows('access-admin')
        || $ordinary->isFillable('is_admin')) {
        throw new RuntimeException('administration_role_boundary_failed');
    }
    $protected = ['admin', 'admin/quotes', 'admin/pricing', 'admin/pricing/{pricingLane}', 'quotes', 'quotes/{quote}', 'quotes.csv', 'profile'];
    foreach ($app['router']->getRoutes() as $route) {
        if ($route->uri() === 'register') {
            throw new RuntimeException('public_registration_enabled');
        }
        if (in_array($route->uri(), $protected, true) && !($route->uri() === 'quotes' && in_array('POST', $route->methods(), true))) {
            $middleware = $route->gatherMiddleware();
            if (!in_array('auth', $middleware, true) || !in_array('can:access-admin', $middleware, true)) {
                throw new RuntimeException('administration_route_unprotected');
            }
        }
    }
    echo "pricing_database_and_authorization_ready\n";
} catch (Throwable $error) {
    fwrite(STDERR, "pricing_database_or_authorization_probe_failed\n");
    exit(1);
}
