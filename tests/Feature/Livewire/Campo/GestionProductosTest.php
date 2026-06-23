<?php

use App\Models\User;
use App\Models\Producto;
use App\Livewire\Campo\GestionProductos;
use function Pest\Livewire\livewire;
use function Pest\Laravel\actingAs;

beforeEach(function () {
    $this->user = User::create([
        'name' => 'Tech User',
        'email' => 'tech@agrotrack.com',
        'password' => bcrypt('password123'),
        'role' => 'Tecnico',
        'activo' => true
    ]);
});

it('renders the gestion productos component', function () {
    actingAs($this->user);

    livewire(GestionProductos::class)
        ->assertStatus(200);
});

it('allows a user to create a new producto', function () {
    actingAs($this->user);

    livewire(GestionProductos::class)
        ->set('nombre', 'Glifosato 48')
        ->set('categoria', 'HERBICIDA')
        ->set('unidad', 'L')
        ->set('dosis_referencia', 2.5)
        ->set('precio_referencia', 4.5)
        ->call('guardar')
        ->assertHasNoErrors();

    $this->assertDatabaseHas('productos', [
        'nombre' => 'Glifosato 48',
        'categoria' => 'HERBICIDA',
        'dosis_referencia' => 2.5,
    ]);
});

it('shows validation errors when creating a producto without required fields', function () {
    actingAs($this->user);

    livewire(GestionProductos::class)
        ->call('guardar')
        ->assertHasErrors(['nombre']); // Categoria, unidad, etc ya tienen defaults
});
