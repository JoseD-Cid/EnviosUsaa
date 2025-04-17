<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ClienteController;
use App\Http\Controllers\EstadoController;
use App\Http\Controllers\MunicipioController;

Route::get('/', [HomeController::class, 'index'])->name('index');

// Rutas para Clientes
Route::get('/clientes/crear', [ClienteController::class, 'crear'])->name('clientes.crear');
Route::post('/clientes/guardar', [ClienteController::class, 'guardar'])->name('clientes.guardar');
Route::get('/clientes/ver', [ClienteController::class, 'ver'])->name('clientes.ver');
Route::get('/clientes/{dni}/editar', [ClienteController::class, 'editar'])->name('clientes.editar');
Route::put('/clientes/{dni}', [ClienteController::class, 'actualizar'])->name('clientes.actualizar');
Route::delete('/clientes/{dni}', [ClienteController::class, 'eliminar'])->name('clientes.eliminar');

// Rutas para Estados y Municipios (relacionadas entre sí)
Route::get('/paises/{paisId}/estados', [EstadoController::class, 'obtenerEstadosPorPais'])->name('estados.porPais');
Route::get('/estados/{estadoId}/municipios', [MunicipioController::class, 'obtenerMunicipiosPorEstado'])->name('municipios.porEstado');