<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ClienteController;
use App\Http\Controllers\UbicacionController;
use App\Http\Controllers\EnvioController;
use App\Http\Controllers\PaisController;
use App\Http\Controllers\EstadoController;
use Illuminate\Support\Facades\Route;

use App\Models\Estado;

Route::get('/', function () {
    return view('index');
});


Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

// Rutas de autenticación
require __DIR__.'/auth.php';

// Grupo de rutas que requieren autenticación
Route::middleware('auth')->group(function () {
    
    // Perfil de usuario
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    
    // Clientes
    Route::get('/clientes/crear', [ClienteController::class, 'crear'])->name('clientes.crear');
    Route::post('/clientes/guardar', [ClienteController::class, 'guardar'])->name('clientes.guardar');
    Route::get('/clientes/ver', [ClienteController::class, 'ver'])->name('clientes.ver');
    Route::get('/clientes/editar/{dni}', [ClienteController::class, 'editar'])->name('clientes.editar');
    Route::put('/clientes/actualizar/{dni}', [ClienteController::class, 'actualizar'])->name('clientes.actualizar');
    Route::delete('/clientes/eliminar/{dni}', [ClienteController::class, 'eliminar'])->name('clientes.eliminar');

    // Ubicación
    Route::get('/paises/{id}/estados', [UbicacionController::class, 'obtenerEstados'])->name('paises.estados');
    Route::get('/estados/{id}', [PaisController::class, 'getEstados']);
    Route::get('/estados-por-pais/{id}', [EstadoController::class, 'obtenerPorPais']);

    // Envíos
    Route::resource('envios', EnvioController::class)->except(['show']);
    Route::post('/envios/guardar', [EnvioController::class, 'store'])->name('envios.store');
    Route::get('/envios/crear', [EnvioController::class, 'create'])->name('envios.create');
    Route::get('/estados-por-pais/{id}', [EnvioController::class, 'obtenerEstadosPorPais']);

    
    Route::post('/envios/{envio}/actualizar-estado', [EnvioController::class, 'actualizarEstado'])->name('envios.actualizar-estado');

// Actualización de estado (solo admin)
Route::post('/envios/{envio}/actualizar-estado', [EnvioController::class, 'actualizarEstado'])
     ->name('envios.actualizar-estado')->middleware('auth');
});

Route::get('/seguimiento', [EnvioController::class, 'seguimiento'])->name('seguimiento');
