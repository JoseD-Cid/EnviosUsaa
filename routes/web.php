<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ClienteController;
use App\Http\Controllers\UbicacionController;
use App\Http\Controllers\EnvioController;
use App\Http\Controllers\PaisController;
use App\Http\Controllers\EstadoController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\Auth\RegisteredUserController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PaqueteController;

// Rutas para roles y permisos - Solo accesibles para administradores
Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/roles', [RoleController::class, 'index'])->name('roles.index');
    Route::get('/roles/user/{id}', [RoleController::class, 'editUserRoles'])->name('roles.edit-user');
    Route::put('/roles/user/{id}', [RoleController::class, 'updateUserRoles'])->name('roles.update-user');
    Route::get('/roles/{id}/edit', [RoleController::class, 'editRole'])->name('roles.edit-role');
    Route::put('/roles/{id}', [RoleController::class, 'updateRole'])->name('roles.update-role');
    Route::get('/roles/create', [RoleController::class, 'createRole'])->name('roles.create');
    Route::post('/roles', [RoleController::class, 'storeRole'])->name('roles.store');
    Route::delete('/roles/{id}', [RoleController::class, 'deleteRole'])->name('roles.delete');

    // Rutas de registro de usuarios para administradores
    Route::get('/register', [RegisteredUserController::class, 'create'])->name('register');
    Route::post('/register', [RegisteredUserController::class, 'store']);
});

Route::get('/', function () {
    return view('index');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

// Rutas de autenticación
require __DIR__.'/auth.php';

// Rutas que requieren autenticación
Route::middleware('auth')->group(function () {

    // Perfil de usuario
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Clientes - Protegidos con permisos específicos
    Route::middleware('permission:crear clientes')->group(function () {
        Route::get('/clientes/crear', [ClienteController::class, 'crear'])->name('clientes.crear');
        Route::post('/clientes/guardar', [ClienteController::class, 'guardar'])->name('clientes.guardar');
    });

    Route::middleware('permission:ver clientes')->group(function () {
        Route::get('/clientes/ver', [ClienteController::class, 'ver'])->name('clientes.ver');
    });

    Route::middleware('permission:editar clientes')->group(function () {
        Route::get('/clientes/editar/{dni}', [ClienteController::class, 'editar'])->name('clientes.editar');
        Route::put('/clientes/actualizar/{dni}', [ClienteController::class, 'actualizar'])->name('clientes.actualizar');
    });

    Route::middleware('permission:eliminar clientes')->group(function () {
        Route::delete('/clientes/eliminar/{dni}', [ClienteController::class, 'eliminar'])->name('clientes.eliminar');
    });

    // Ubicación - Accesible para todos los usuarios autenticados
    Route::get('/paises/{id}/estados', [UbicacionController::class, 'obtenerEstados'])->name('paises.estados');
    Route::get('/estados/{id}', [PaisController::class, 'getEstados']);
    Route::get('/estados-por-pais/{id}', [EstadoController::class, 'obtenerPorPais']);

    // Envíos - Protegidos con permisos específicos
    Route::middleware('permission:ver envios')->group(function () {
        Route::get('/envios', [EnvioController::class, 'index'])->name('envios.index');
    });

    Route::middleware('permission:crear envios')->group(function () {
        Route::get('/envios/crear', [EnvioController::class, 'create'])->name('envios.create');
        Route::post('/envios/guardar', [EnvioController::class, 'store'])->name('envios.store');
    });

    Route::middleware('permission:editar envios')->group(function () {
        Route::get('/envios/{envio}/edit', [EnvioController::class, 'edit'])->name('envios.edit');
        Route::put('/envios/{envio}', [EnvioController::class, 'update'])->name('envios.update');
    });

    Route::middleware('permission:eliminar envios')->group(function () {
        Route::delete('/envios/{envio}', [EnvioController::class, 'destroy'])->name('envios.destroy');
    });

    // Ruta para cargar estados por país (utilizada en formularios de envío)
    Route::get('/estados-por-pais/{id}', [EnvioController::class, 'obtenerEstadosPorPais']);

    // Actualización de estado (solo admin o con permiso)
    Route::post('/envios/{envio}/actualizar-estado', [EnvioController::class, 'actualizarEstado'])->name('envios.actualizar-estado');

    Route::middleware('permission:ver envios')->group(function () {
        Route::get('/paquetes', [PaqueteController::class, 'index'])->name('paquetes.index');
        Route::get('/paquetes/{paquete}', [PaqueteController::class, 'show'])->name('paquetes.show');
    });
    
    Route::middleware('permission:crear envios')->group(function () {
        Route::get('/paquetes/create', [PaqueteController::class, 'create'])->name('paquetes.create');
        Route::post('/paquetes', [PaqueteController::class, 'store'])->name('paquetes.store');
    });
    
    Route::middleware('permission:editar envios')->group(function () {
        Route::get('/paquetes/{paquete}/edit', [PaqueteController::class, 'edit'])->name('paquetes.edit');
        Route::put('/paquetes/{paquete}', [PaqueteController::class, 'update'])->name('paquetes.update');
    });
    
    Route::middleware('permission:eliminar envios')->group(function () {
        Route::delete('/paquetes/{paquete}', [PaqueteController::class, 'destroy'])->name('paquetes.destroy');
    });

    // Gestión de paquetes - Con permisos específicos
Route::middleware('permission:ver paquetes')->group(function () {
    Route::get('/paquetes', [PaqueteController::class, 'index'])->name('paquetes.index');
    Route::get('/paquetes/{paquete}', [PaqueteController::class, 'show'])->name('paquetes.show');
});

Route::middleware('permission:crear paquetes')->group(function () {
    Route::get('/paquetes/create', [PaqueteController::class, 'create'])->name('paquetes.create');
    Route::post('/paquetes', [PaqueteController::class, 'store'])->name('paquetes.store');
});

Route::middleware('permission:editar paquetes')->group(function () {
    Route::get('/paquetes/{paquete}/edit', [PaqueteController::class, 'edit'])->name('paquetes.edit');
    Route::put('/paquetes/{paquete}', [PaqueteController::class, 'update'])->name('paquetes.update');
});

Route::middleware('permission:eliminar paquetes')->group(function () {
    Route::delete('/paquetes/{paquete}', [PaqueteController::class, 'destroy'])->name('paquetes.destroy');
});
});

// Ruta pública para seguimiento
Route::get('/seguimiento', [EnvioController::class, 'seguimiento'])->name('seguimiento');
