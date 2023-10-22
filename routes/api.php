<?php

use App\Http\Controllers\HistorialController;
use App\Http\Controllers\TareaController;
use App\Http\Controllers\UsuarioAsignaTareaController;
use App\Http\Controllers\UsuarioComentaTareaController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::controller(TareaController::class)->group(function () {
    Route::get('/tareas', 'buscar');
    Route::post('/tareas', 'guardar');
    Route::get('/tareas/{tarea}', 'buscar_tarea');
    Route::put('/tareas/{tarea}', 'modificar');
    Route::delete('/tareas/{tarea}', 'eliminar');
});

Route::controller(UsuarioAsignaTareaController::class)->group(function () {
    Route::get('/usuario_asigna_tareas', 'index');
    Route::post('/usuario_asigna_tareas', 'store');
    Route::get('/usuario_asigna_tareas/{usuarioAsignaTarea}', 'show');
    Route::put('/usuario_asigna_tareas/{usuarioAsignaTarea}', 'update');
    Route::delete('/usuario_asigna_tareas/{usuarioAsignaTarea}', 'destroy');
});

Route::controller(UsuarioComentaTareaController::class)->group(function () {
Route::get('/usuario_comenta_tareas', 'index');
Route::post('/usuario_comenta_tareas', 'store');
Route::get('/usuario_comenta_tareas/{usuarioComentaTarea}', 'show');
Route::put('/usuario_comenta_tareas/{usuarioComentaTarea}', 'update');
Route::delete('/usuario_comenta_tareas/{usuarioComentaTarea}', 'destroy');
});

Route::controller(HistorialController::class)->group(function () {
    Route::get('/historiales', 'index');
    Route::post('/historiales', 'store');
    Route::get('/historiales/{historial}', 'show');
    Route::put('/historiales/{historial}', 'update');
    Route::delete('/historiales/{historial}', 'destroy');
});
