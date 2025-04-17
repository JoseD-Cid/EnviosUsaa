<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ClienteController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('index');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    
    // Rutas para clientes
    Route::get('/clientes/crear', [ClienteController::class, 'crear'])->name('clientes.crear');
    Route::post('/clientes/guardar', [ClienteController::class, 'guardar'])->name('clientes.guardar');
    Route::get('/clientes/ver', [ClienteController::class, 'ver'])->name('clientes.ver');

    // Rutas para editar y eliminar clientes
    Route::get('/clientes/editar/{dni}', [ClienteController::class, 'editar'])->name('clientes.editar');
    Route::put('/clientes/actualizar/{dni}', [ClienteController::class, 'actualizar'])->name('clientes.actualizar');
    Route::delete('/clientes/eliminar/{dni}', [ClienteController::class, 'eliminar'])->name('clientes.eliminar');

    // Ruta para obtener la dirección del municipio
    Route::get('/clientes/municipio/{codMunicipio}/direccion', [ClienteController::class, 'obtenerDireccionMunicipio'])->name('clientes.obtenerDireccion');
});

require __DIR__.'/auth.php';

