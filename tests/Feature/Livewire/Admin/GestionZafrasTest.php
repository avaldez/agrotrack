<?php

use App\Models\User;
use App\Models\Zafra;
use App\Livewire\Admin\GestionZafras;
use function Pest\Livewire\livewire;
use function Pest\Laravel\actingAs;

beforeEach(function () {
    $this->user = User::create([
        'name' => 'Admin User',
        'email' => 'admin@agrotrack.com',
        'password' => bcrypt('password123'),
        'role' => 'Admin',
        'activo' => true
    ]);
});

it('renders the gestion zafras component', function () {
    actingAs($this->user);

    livewire(GestionZafras::class)
        ->assertStatus(200);
});

it('allows an admin to create a new zafra', function () {
    actingAs($this->user);

    livewire(GestionZafras::class)
        ->set('nombre', 'Zafra 2026/2027')
        ->set('fecha_inicio', '2026-09-01')
        ->set('fecha_fin', '2027-05-31')
        ->call('guardar')
        ->assertHasNoErrors();

    $this->assertDatabaseHas('zafras', [
        'nombre' => 'Zafra 2026/2027',
    ]);
});

it('shows validation errors when creating a zafra without name', function () {
    actingAs($this->user);

    livewire(GestionZafras::class)
        ->call('guardar')
        ->assertHasErrors(['nombre', 'fecha_inicio']);
});
