<?php

use App\Models\User;
use App\Models\Cliente;
use App\Models\Parcela;
use App\Models\Cultivo;
use App\Models\Zafra;
use App\Livewire\Campo\RegistrarVisita;
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

    $this->cliente = Cliente::create([
        'nombre' => 'Cliente de Prueba',
        'contacto' => 'Juan',
        'telefono' => '123456789',
        'direccion' => 'Campo 1',
        'creado_por_user_id' => $this->user->id,
        'activo' => true
    ]);

    $this->cultivo = Cultivo::create([
        'nombre' => 'Soja',
        'activo' => true
    ]);

    $this->parcela = Parcela::create([
        'cliente_id' => $this->cliente->id,
        'nombre' => 'Lote 1',
        'superficie_ha' => 100,
        'cultivo_id' => $this->cultivo->id,
        'activo' => true
    ]);
});

it('renders the registrar visita component', function () {
    actingAs($this->user);

    livewire(RegistrarVisita::class)
        ->assertStatus(200);
});

it('loads available parcels when a client is selected', function () {
    actingAs($this->user);

    livewire(RegistrarVisita::class)
        ->set('clienteId', $this->cliente->id)
        ->assertSet('parcelasDisponibles', function ($parcelas) {
            return $parcelas->count() === 1 && $parcelas->first()->id === $this->parcela->id;
        });
});

it('shows validation errors when trying to save without required fields', function () {
    actingAs($this->user);

    livewire(RegistrarVisita::class)
        ->call('guardar')
        ->assertHasErrors(['clienteId', 'parcelaId']);
});
