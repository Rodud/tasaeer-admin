<?php

use App\Models\PricingLane;
use App\Models\Quote;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

it('denies ordinary accounts even when their password is valid and a role is submitted', function () {
    $user = User::factory()->create();
    expect($user->fresh()->is_admin)->toBeFalse();
    $this->post('/login', ['email' => $user->email, 'password' => 'password', 'is_admin' => true])
        ->assertSessionHasErrors('email');
    $this->assertGuest();
});

it('denies existing non-admin sessions on every administrative read surface', function (string $path) {
    $this->actingAs(User::factory()->create())->get($path)->assertForbidden();
})->with(['/admin', '/admin/quotes', '/admin/pricing', '/quotes', '/quotes.csv', '/profile']);

it('prevents non-admin sessions changing prices and quote statuses', function () {
    $lane = PricingLane::create(['origin' => 'A', 'destination' => 'B', 'distance_km' => 1, 'price' => 400]);
    $quote = Quote::create(['ref' => 'Q-TEST', 'name' => 'Fixture', 'phone' => '0500000000',
        'origin' => 'A', 'destination' => 'B', 'truck_type' => 'Truck', 'cargo_type' => 'Cargo', 'weight_band' => 'Light']);
    $this->actingAs(User::factory()->create());
    $this->patch('/admin/pricing/'.$lane->id, ['price' => 1])->assertForbidden();
    $this->patch('/quotes/'.$quote->id, ['status' => 'مؤكد'])->assertForbidden();
    expect((float) $lane->fresh()->price)->toBe(400.0);
    expect($quote->fresh()->status)->toBe('جديد');
});

it('allows explicit administrators to read all administration pages', function (string $path) {
    $this->actingAs(User::factory()->create(['is_admin' => true]))->get($path)->assertOk();
})->with(['/admin', '/admin/quotes', '/admin/pricing', '/quotes', '/quotes.csv', '/profile']);

it('rechecks permissions for an existing session after revocation', function () {
    $user = User::factory()->create(['is_admin' => true]);
    $this->actingAs($user)->get('/admin')->assertOk();
    $user->forceFill(['is_admin' => false])->save();
    $this->get('/admin')->assertForbidden();
});

it('does not allow the administration flag through mass assignment', function () {
    $user = new User;
    $user->fill(['name' => 'Fixture', 'email' => 'fixture@example.test', 'password' => 'fixture-password', 'is_admin' => true]);
    expect($user->isFillable('is_admin'))->toBeFalse();
    expect($user->getAttributes())->not->toHaveKey('is_admin');
});

it('provisions an administrator through secret interactive prompts', function () {
    $this->artisan('pricing:admin')
        ->expectsQuestion('Email', 'OWNER@example.test')
        ->expectsQuestion('Name', 'Owner')
        ->expectsQuestion('Password (at least 12 characters)', 'fixture-admin-password')
        ->expectsQuestion('Confirm password', 'fixture-admin-password')
        ->assertSuccessful();
    $user = User::where('email', 'owner@example.test')->firstOrFail();
    expect($user->is_admin)->toBeTrue();
    expect(Hash::check('fixture-admin-password', $user->password))->toBeTrue();
    $this->post('/login', ['email' => $user->email, 'password' => 'fixture-admin-password'])
        ->assertRedirect('/admin');
});

it('promotes an existing account without changing its password or duplicating it', function () {
    $user = User::factory()->create();
    $hash = $user->password;
    $this->artisan('pricing:admin')
        ->expectsQuestion('Email', $user->email)
        ->expectsQuestion('Name', 'Owner')
        ->expectsQuestion('Password (leave blank to keep the existing password)', '')
        ->assertSuccessful();
    expect($user->fresh()->is_admin)->toBeTrue();
    expect($user->fresh()->password)->toBe($hash);
    $this->assertDatabaseCount('users', 1);
});

it('rejects invalid administrator credentials without creating an account', function (string $password, string $confirmation) {
    $this->artisan('pricing:admin')
        ->expectsQuestion('Email', 'invalid@example.test')
        ->expectsQuestion('Name', 'Invalid')
        ->expectsQuestion('Password (at least 12 characters)', $password)
        ->expectsQuestion('Confirm password', $confirmation)
        ->assertFailed();
    $this->assertDatabaseCount('users', 0);
})->with([['short', 'short'], ['fixture-admin-password', 'different-password']]);
