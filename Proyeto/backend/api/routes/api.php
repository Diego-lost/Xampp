<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CitaController;
use App\Http\Controllers\EspecialidadController;
use App\Http\Controllers\MedicoController;
use App\Http\Controllers\ServicioController;

Route::get('/status', function () {
    return response()->json([
        'ok' => true,
        'service' => 'backend-api',
    ]);
});

Route::post('/solicitudes-citas', [CitaController::class, 'store']);
Route::get('/solicitudes-citas', [CitaController::class, 'index']);
Route::patch('/solicitudes-citas/{solicitud}/cancelar', [CitaController::class, 'cancelar']);
Route::patch('/solicitudes-citas/{solicitud}/reprogramar', [CitaController::class, 'reprogramar']);

Route::apiResource('especialidades', EspecialidadController::class)
    ->parameters(['especialidades' => 'especialidad']);
Route::apiResource('medicos', MedicoController::class)
    ->parameters(['medicos' => 'medico']);
Route::apiResource('servicios', ServicioController::class)
    ->parameters(['servicios' => 'servicio']);

