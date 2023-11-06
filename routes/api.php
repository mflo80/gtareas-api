<?php

use App\Http\Controllers\HistorialController;
use App\Http\Controllers\TareaController;
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

Route::controller(TareaController::class)
        ->middleware('autenticacion')
        ->group(function () {
    Route::post('/tareas', 'guardar');
    Route::get('/tareas', 'buscar');
    Route::get('/tareas/{tarea}', 'buscar_tarea');
    Route::put('/tareas/{tarea}', 'modificar');
    Route::delete('/tareas/{tarea}', 'eliminar');
});

Route::controller(UsuarioComentaTareaController::class)
        ->middleware('autenticacion')
        ->group(function () {
    Route::post('/comenta', 'guardar');
    Route::get('/comenta', 'buscar');
    Route::get('/comenta/tarea/{id_tarea}', 'buscar_tarea');
    Route::get('/comenta/usuario/{id_usuario}', 'buscar_usuario');
    Route::get('/comenta/usuario/{id_usuario}/{id_tarea}/{fecha_hora_creacion}', 'buscar_comentario');
    Route::put('/comenta/usuario/{id_usuario}/{id_tarea}/{fecha_hora_creacion}', 'modificar');
    Route::delete('/comenta/usuario/{id_usuario}/{id_tarea}/{fecha_hora_creacion}', 'eliminar');
});

Route::controller(HistorialController::class)
        ->middleware('autenticacion')
        ->group(function () {
    Route::post('/historial', 'guardar');
    Route::get('/historial', 'buscar');
    Route::get('/historial/{historial}', 'buscar_historial');
    Route::get('/historial/tarea/{id_tarea}', 'buscar_tarea');
    Route::get('/historial/usuario/{id_usuario}', 'buscar_usuario');
    Route::put('/historial/{historial}', 'modificar');
    Route::delete('/historial/{historial}', 'eliminar');
});
