<?php

use App\Http\Controllers\TareaController;
use App\Http\Controllers\TareaHistorialController;
use App\Http\Controllers\UsuarioComentaTareaController;
use App\Http\Controllers\UsuarioAsignaTareaController;
use App\Http\Controllers\EmailController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ComentarioHistorialController;

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
    Route::put('/tareas/categoria/{tarea}', 'modificar_categoria');
    Route::delete('/tareas/{tarea}', 'eliminar');
});

Route::controller(EmailController::class)
        ->middleware('autenticacion')
        ->group(function () {
    Route::post('/correos', 'enviar');
});

Route::controller(UsuarioComentaTareaController::class)
        ->middleware('autenticacion')
        ->group(function () {
    Route::post('/comenta', 'guardar');
    Route::get('/comenta', 'buscar');
    Route::get('/comenta/tarea/{id_tarea}', 'buscar_tarea');
    Route::get('/comenta/usuario/{id_usuario}', 'buscar_usuario');
    Route::get('/comenta/{id}', 'buscar_comentario');
    Route::put('/comenta/{id}', 'modificar');
    Route::delete('/comenta/{id}', 'eliminar');
});

Route::controller(UsuarioAsignaTareaController::class)
        ->middleware('autenticacion')
        ->group(function () {
    Route::post('/asigna', 'guardar');
    Route::get('/asigna', 'buscar');
    Route::get('/asigna/tarea/{id_tarea}', 'buscar_tarea');
    Route::get('/asigna/usuario/creador/{id_usuario}', 'buscar_usuario_creador');
    Route::get('/asigna/usuario/asignado/{id_usuario}', 'buscar_usuario_asignado');
    Route::delete('/asigna/{id_usuario_creador}/{id_usuario_asignado}/{id_tarea}', 'eliminar');
});

Route::controller(TareaHistorialController::class)
        ->middleware('autenticacion')
        ->group(function () {
    Route::get('/historial/tareas', 'buscar');
});

Route::controller(ComentarioHistorialController::class)
        ->middleware('autenticacion')
        ->group(function () {
    Route::get('/historial/comentarios', 'buscar');
});
