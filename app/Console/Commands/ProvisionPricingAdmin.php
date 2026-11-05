<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class ProvisionPricingAdmin extends Command
{
    protected $signature = 'pricing:admin';

    protected $description = 'Create or explicitly promote a pricing administrator using private interactive prompts';

    public function handle(): int
    {
        $email = Str::lower(trim((string) $this->ask('Email')));
        $existing = User::query()->where('email', $email)->first();
        $name = trim((string) $this->ask('Name', $existing?->name));
        $password = $this->secret($existing
            ? 'Password (leave blank to keep the existing password)'
            : 'Password (at least 12 characters)');
        $password = is_string($password) && $password !== '' ? $password : null;
        $confirmation = $password !== null ? $this->secret('Confirm password') : null;

        $validator = Validator::make([
            'name' => $name,
            'email' => $email,
            'password' => $password,
            'password_confirmation' => $confirmation,
        ], [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255'],
            'password' => [$existing ? 'nullable' : 'required', 'string', 'min:12', 'confirmed'],
        ]);

        if ($validator->fails()) {
            foreach ($validator->errors()->all() as $error) {
                $this->error($error);
            }

            return self::FAILURE;
        }

        DB::transaction(function () use ($email, $name, $password): void {
            $user = User::query()->where('email', $email)->lockForUpdate()->first() ?? new User;
            $attributes = ['name' => $name, 'email' => $email, 'is_admin' => true];
            if ($password !== null) {
                $attributes['password'] = $password;
            }

            // This server-side command is the only publicized role-grant path.
            // is_admin deliberately stays outside User's mass-assignable fields.
            $user->forceFill($attributes)->save();
        });

        $this->info('Pricing administrator is ready. Sign in at /login.');

        return self::SUCCESS;
    }
}
