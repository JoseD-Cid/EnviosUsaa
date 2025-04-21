<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ClienteController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UbicacionController;
use App\Http\Controllers\EnvioController;
use App\Http\Controllers\PaisController;
use App\Models\Estado;


Route::get('/estados/{codPais}', function ($codPais) {
    return Estado::where('CodPais', $codPais)
        ->where('Estatus', 1)
        ->where('IsDelete', 0)
        ->get();
});


Route::get('/estados/{paisId}', function($paisId) {
    $estados = Estado::where('CodPais', $paisId)->get();
    return response()->json($estados);
});


Route::get('/paises/{id}/estados', [UbicacionController::class, 'obtenerEstados']);


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

    Route::get('/paises/{id}/estados', [UbicacionController::class, 'obtenerEstados']);
    

    // Rutas para editar y eliminar clientes
    Route::get('/clientes/editar/{dni}', [ClienteController::class, 'editar'])->name('clientes.editar');
    Route::put('/clientes/actualizar/{dni}', [ClienteController::class, 'actualizar'])->name('clientes.actualizar');
    Route::delete('/clientes/eliminar/{dni}', [ClienteController::class, 'eliminar'])->name('clientes.eliminar');

    Route::get('/paises/{id}/estados', [UbicacionController::class, 'obtenerEstados']);
    Route::get('/estados/{id}', [PaisController::class, 'getEstados']);
    Route::get('/estados-por-pais/{id}', [EstadoController::class, 'obtenerPorPais']);
    
    

    Route::resource('envios', EnvioController::class);
    Route::get('/envios/create', [EnvioController::class, 'create'])->name('envios.create');
    Route::get('/envios/crear', [EnvioController::class, 'create'])->name('envios.create');
    Route::post('/envios/guardar', [EnvioController::class, 'store'])->name('envios.store');
    Route::get('/estados-por-pais/{id}', [EnvioController::class, 'obtenerEstadosPorPais']);
    
});

require __DIR__.'/auth.php';

