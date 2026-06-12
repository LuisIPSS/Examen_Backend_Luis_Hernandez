<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HealthController;
use App\Http\Controllers\CamisetasController;
use App\Http\Controllers\ClientesController;
use App\Http\Controllers\TallasController;
use App\Http\Controllers\CamisetaTallasController;
use App\Http\Controllers\VentasController;
use App\Http\Controllers\VentasDetallesController;
use App\Http\Controllers\AdministracionController;

// Checkea si la API está funcionando
Route::get('/health', HealthController::class);

// CRUD de camisetas
Route::apiResource('camisetas', CamisetasController::class);

// CRUD de clientes
Route::apiResource('clientes', ClientesController::class);

// CRUD de tallas
Route::apiResource('tallas', TallasController::class);

// CRUD de camiseta tallas
Route::apiResource('camiseta-tallas', CamisetaTallasController::class);

// CRUD de ventas
Route::apiResource('ventas', VentasController::class);

// CRUD de ventas detalles
Route::apiResource('ventas-detalles', VentasDetallesController::class);

// Administracion
Route::get('clientes/{cliente}/camisetas', [AdministracionController::class, 'camisetasPorCliente']);
Route::post('clientes/calcularpreciofinal', [AdministracionController::class, 'calcularPrecioFinal']);
