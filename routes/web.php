<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PDFController;
use App\Http\Controllers\SyncController;
use App\Livewire\Campo\RegistrarVisita;
use App\Livewire\Campo\GestionClientes;
use App\Livewire\Campo\GestionProductos;
use App\Livewire\Campo\ListaRecorridos;

Route::middleware(['auth'])->group(function () {

    Route::get('/', function () {
        return redirect()->route('dashboard');
    });

    Route::get('/dashboard', \App\Livewire\Dashboard::class)->name('dashboard');

    Route::middleware(['role:tecnico'])->group(function () {
        Route::get('/campo/registrar', RegistrarVisita::class)->name('campo.registrar');
        Route::get('/campo/recorridos', ListaRecorridos::class)->name('campo.recorridos');
        Route::get('/campo/editar/{recorrido}', RegistrarVisita::class)->name('campo.editar');
    });

    Route::middleware(['role:tecnico'])->group(function () {
        Route::get('/clientes', GestionClientes::class)->name('clientes');
        Route::get('/productos', GestionProductos::class)->name('productos');
    });

    Route::get('/admin/usuarios', function () {
        return view('admin.usuarios');
    })->name('admin.usuarios')
    ->middleware('role:tecnico');

    Route::get('/admin/zafras', \App\Livewire\Admin\GestionZafras::class)
        ->name('admin.zafras')
        ->middleware('role:tecnico');

    Route::get('/pdf/recomendacion/{visita}', [PDFController::class, 'recomendacion'])
        ->name('pdf.recomendacion')
        ->middleware('role:cualquiera');

    Route::post('/api/sync/visita', [SyncController::class, 'syncVisita'])
        ->name('api.sync.visita');

    Route::get('/offline', function () {
        return view('pwa.offline');
    })->name('offline');
});

require __DIR__.'/auth.php';
