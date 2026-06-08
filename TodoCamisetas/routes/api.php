<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HealthController;
use App\Http\Controllers\CamisetasController;
use App\Http\Controllers\ClientesController;
use App\Http\Controllers\TallasController;
use App\Http\Controllers\CamisetaTallasController;

Route::get('/health', HealthController::class);

Route::apiResource('camisetas', CamisetasController::class);
Route::apiResource('clientes', ClientesController::class);
Route::apiResource('tallas', TallasController::class);
Route::apiResource('camiseta-tallas', CamisetaTallasController::class);

Route::post('clientes/calcularpreciofinal', [ClientesController::class, 'calcularPrecioFinal']);
