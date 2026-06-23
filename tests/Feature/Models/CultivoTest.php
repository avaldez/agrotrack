<?php

use App\Models\Cultivo;

it('can create and save a cultivo to the database', function () {
    $cultivo = Cultivo::create([
        'nombre' => 'Maiz',
        'activo' => true,
    ]);

    $this->assertDatabaseHas('cultivos', [
        'nombre' => 'Maiz',
        'activo' => 1,
    ]);
});
