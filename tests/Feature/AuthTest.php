<?php

use App\Models\User;
use function Pest\Laravel\get;
use function Pest\Laravel\post;
use function Pest\Laravel\actingAs;

it('displays the login page', function () {
    get('/login')
        ->assertOk()
        ->assertSee('Bienvenido'); // Ajustar si la vista dice algo distinto
});

it('allows a user to login with correct credentials', function () {
    $user = User::create([
        'name' => 'Test User',
        'email' => 'test@agrotrack.com',
        'password' => bcrypt('password123'),
        'role' => 'Admin'
    ]);

    post('/login', [
        'email' => 'test@agrotrack.com',
        'password' => 'password123',
    ])->assertRedirect('/dashboard'); // Ajustar al redirect real
});

it('does not allow login with incorrect credentials', function () {
    $user = User::create([
        'name' => 'Test User',
        'email' => 'test@agrotrack.com',
        'password' => bcrypt('password123'),
        'role' => 'Admin'
    ]);

    post('/login', [
        'email' => 'test@agrotrack.com',
        'password' => 'wrongpassword',
    ])->assertSessionHasErrors();
});

it('allows an authenticated user to logout', function () {
    $user = User::create([
        'name' => 'Test User',
        'email' => 'test@agrotrack.com',
        'password' => bcrypt('password123'),
        'role' => 'Admin'
    ]);

    actingAs($user)
        ->post('/logout')
        ->assertRedirect('/login'); // Ajustar al redirect real
});
