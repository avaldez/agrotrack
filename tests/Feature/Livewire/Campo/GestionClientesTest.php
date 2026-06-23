<?php

use App\Models\User;
use App\Models\Cliente;
use App\Livewire\Campo\GestionClientes;
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

it('renders the gestion clientes component', function () {
    actingAs($this->user);

    livewire(GestionClientes::class)
        ->assertStatus(200);
});

it('allows a user to create a new client', function () {
    actingAs($this->user);

    livewire(GestionClientes::class)
        ->set('nombre', 'Nuevo Cliente S.A.')
        ->set('contacto', 'Pedro Perez')
        ->set('telefono', '123123123')
        ->set('direccion', 'Ruta 1 Km 10')
        ->call('guardar')
        ->assertHasNoErrors();

    $this->assertDatabaseHas('clientes', [
        'nombre' => 'Nuevo Cliente S.A.',
        'contacto' => 'Pedro Perez',
    ]);
});

it('shows validation errors when creating a client without name', function () {
    actingAs($this->user);

    livewire(GestionClientes::class)
        ->call('guardar')
        ->assertHasErrors(['nombre']);
});

it('allows a user to create a parcela for a client', function () {
    actingAs($this->user);

    $cliente = Cliente::create([
        'nombre' => 'Cliente Parcela',
        'contacto' => 'Pedro',
        'creado_por_user_id' => $this->user->id,
    ]);

    livewire(GestionClientes::class)
        ->call('abrirParcelaModal', $cliente->id)
        ->set('parcelaNombre', 'Lote 1')
        ->set('parcelaSuperficie', 100)
        ->set('parcelaVariedad', 'Soja')
        ->call('guardarParcela')
        ->assertHasNoErrors();

    $this->assertDatabaseHas('parcelas', [
        'cliente_id' => $cliente->id,
        'nombre' => 'Lote 1',
        'superficie_ha' => 100,
    ]);
});
