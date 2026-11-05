<?php
// CLI only. Credentials stay in a short-lived 0600 file, never argv or logs.
declare(strict_types=1);
$release = $argv[1] ?? '';
$output = $argv[2] ?? '';
if (PHP_SAPI !== 'cli' || !preg_match('#\A/var/www/togoo-pricing/releases/auto-[a-zA-Z0-9-]+\z#D', $release) || !preg_match('#\A/var/lib/togoo-pricing-deploy/backups/db-[0-9a-fTZ-]+\.sql\z#D', $output)) { exit(2); }
require $release.'/vendor/autoload.php';
$app = require $release.'/bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();
$config = config('database.connections.'.config('database.default'));
if (($config['driver'] ?? '') !== 'mysql' || ($config['database'] ?? '') !== 'website_pricing') { exit(3); }
$option = fn ($v) => '"'.str_replace(['\\', '"', "\n", "\r"], ['\\\\', '\\"', '\\n', '\\r'], (string) $v).'"';
umask(0077);
$defaults = tempnam(dirname($output), '.mysql-');
try {
    chmod($defaults, 0600);
    $lines = ['[client]', 'host='.$option($config['host']), 'port='.(int)($config['port'] ?? 3306), 'user='.$option($config['username']), 'password='.$option($config['password'])];
    file_put_contents($defaults, implode("\n", $lines)."\n");
    $file = fopen($output, 'xb');
    $process = proc_open(['/usr/bin/mariadb-dump', '--defaults-extra-file='.$defaults, '--single-transaction', '--skip-lock-tables', '--no-tablespaces', '--skip-comments', 'website_pricing'], [0 => ['pipe', 'r'], 1 => $file, 2 => ['pipe', 'w']], $pipes);
    if (!is_resource($process)) { throw new RuntimeException(); }
    fclose($pipes[0]);
    stream_get_contents($pipes[2]);
    fclose($pipes[2]);
    $status = proc_close($process);
    fclose($file);
    if ($status !== 0 || filesize($output) < 100) { throw new RuntimeException(); }
    echo "pricing_database_backup_ready\n";
} catch (Throwable $e) { if (is_file($output)) { unlink($output); } fwrite(STDERR, "pricing_database_backup_failed\n"); exit(1); }
finally { if (is_file($defaults)) { unlink($defaults); } }
