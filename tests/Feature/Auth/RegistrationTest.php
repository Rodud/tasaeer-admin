<?php

test('public registration is unavailable', function () {
    $this->get('/register')->assertNotFound();
    $this->post('/register', [
        'name' => 'Untrusted registration',
        'email' => 'untrusted@example.test',
        'password' => 'untrusted-password',
        'password_confirmation' => 'untrusted-password',
        'is_admin' => true,
    ])->assertNotFound();

    $this->assertGuest();
    $this->assertDatabaseCount('users', 0);
});
