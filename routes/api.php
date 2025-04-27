<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EstadoController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// Default route for authenticated API user (optional, you can remove this if not needed)
Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

// Route to fetch states by country ID
Route::get('/estados/{paisId}', [EstadoController::class, 'getByPais']);