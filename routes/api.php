<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\LoteController;
use App\Http\Controllers\ClienteController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\VentaController;
use App\Http\Controllers\PagoController;

// Rutas PÚBLICAS (sin necesidad de autenticación)
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

Route::get('/lotes', [LoteController::class, 'getPropiedades']);
Route::get('/lotes/{id}', [LoteController::class, 'getPropiedadById']);


// Rutas PROTEGIDAS (requieren token de autenticación)
Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);

    Route::get('/user', function (Request $request) {
        return response()->json([
            'user' => [
                'id' => $request->user()->id,
                'name' => $request->user()->nombre,
                'email' => $request->user()->email,
                'rol' => $request->user()->rol,
            ]
        ]);
    });

    Route::post('/lotes', [LoteController::class, 'createPropiedad']);
    Route::put('/lotes/{id}', [LoteController::class, 'updatePropiedadById']);
    Route::delete('/lotes/{id}', [LoteController::class, 'deletePropiedadById']);

    Route::post('/clientes', [ClienteController::class, 'createClientes']);
    Route::get('/clientes', [ClienteController::class, 'getClientes']);
    Route::get('/clientes/{id}', [ClienteController::class, 'getClienteById']);
    Route::put('/clientes/{id}', [ClienteController::class, 'updateClienteById']);
    Route::delete('/clientes/{id}', [ClienteController::class, 'deleteClienteById']);

     Route::post('/ventas', [VentaController::class, 'createVenta']);
    Route::get('/ventas', [VentaController::class, 'getVentas']);
    Route::get('/ventas/{id}', [VentaController::class, 'getVentaById']);
    Route::put('/ventas/{id}', [VentaController::class, 'updateVentaById']);
    Route::delete('/ventas/{id}', [VentaController::class, 'deleteVentaById']);

    Route::post('/pagos', [PagoController::class, 'createPago']);
    Route::get('/pagos', [PagoController::class, 'getPagos']);
});