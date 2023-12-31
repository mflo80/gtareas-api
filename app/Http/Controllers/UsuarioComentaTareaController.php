<?php

namespace App\Http\Controllers;

use App\Models\UsuarioComentaTarea;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use DateTime;
use Illuminate\Support\Facades\Cache;

class UsuarioComentaTareaController extends Controller
{
    public function guardar(Request $request)
    {
        try {
            Cache::forget('usuarioComentaTarea');

            $usuarioComentaTarea = new UsuarioComentaTarea();
            $usuarioComentaTarea->id_usuario = $request->post('id_usuario');
            $usuarioComentaTarea->id_tarea = $request->post('id_tarea');
            $usuarioComentaTarea->comentario = $request->post('comentario');
            $usuarioComentaTarea->fecha_hora_creacion = now();
            $usuarioComentaTarea->fecha_hora_modificacion = now();
            $usuarioComentaTarea->save();

            return response()->json([
                'status' => true,
                'message' => 'Comentario registrado correctamente.'
            ], 200);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => $th->getMessage()
            ], 500);
        }
    }

    public function buscar()
    {
        try {
            $usuarioComentaTarea = Cache::remember('usuarioComentaTarea', 60, function () {
                return UsuarioComentaTarea::all();
            });

            if($usuarioComentaTarea->isEmpty()) {
                return response()->json([
                    'status' => true,
                    'message' => 'No hay comentarios registrados.'
                ], 404);
            }

            return response()->json([
                'tareas' => $usuarioComentaTarea,
                'status' => true,
                'message' => 'Comentarios encontrados.'
            ], 200);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => $th->getMessage()
            ], 500);
        }
    }

    public function buscar_usuario($id_usuario)
    {
        try {
            $usuarioComentaTarea = UsuarioComentaTarea::where('id_usuario', $id_usuario)->get();

            return response()->json([
                'tarea' => $usuarioComentaTarea,
                'status' => true,
                'message' => 'Usuario encontrado.'
            ], 200);
        } catch (ModelNotFoundException $ex) {
            return response()->json([
                'status' => true,
                'message' => 'Usuario no encontrado.'
            ], 404);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => $th->getMessage()
            ], 500);
        }
    }

    public function buscar_tarea($id_tarea)
    {
        try {
            $usuarioComentaTarea = UsuarioComentaTarea::where('id_tarea', $id_tarea)->get();

            return response()->json([
                'comentario' => $usuarioComentaTarea,
                'status' => true,
                'message' => 'Tarea encontrada.'
            ], 200);
        } catch (ModelNotFoundException $ex) {
            return response()->json([
                'status' => true,
                'message' => 'Tarea no encontrada.'
            ], 404);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => $th->getMessage()
            ], 500);
        }
    }

    public function buscar_comentario($id)
    {
        try {
            $usuarioComentaTarea = UsuarioComentaTarea::where('id', $id)->firstOrFail();

            return response()->json([
                'tarea' => $usuarioComentaTarea,
                'status' => true,
                'message' => 'Comentario encontrado.'
            ], 200);
        } catch (ModelNotFoundException $ex) {
            return response()->json([
                'status' => true,
                'message' => 'Comentario no encontrado.'
            ], 404);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => $th->getMessage()
            ], 500);
        }
    }

    public function modificar(Request $request, $id)
    {
        try {
            Cache::forget('usuarioComentaTarea');

            $usuarioComentaTarea = UsuarioComentaTarea::where('id', $id)->firstOrFail();
            $usuarioComentaTarea->comentario = $request->post('comentario');
            $usuarioComentaTarea->fecha_hora_modificacion = now();
            $usuarioComentaTarea->save();

            return response()->json([
                'status' => true,
                'message' => 'Comentario modificado correctamente.'
            ], 200);
        } catch (ModelNotFoundException $ex) {
            return response()->json([
                'status' => false,
                'message' => 'No se encontró el comentario.'
            ], 404);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => $th->getMessage()
            ], 500);
        }
    }

    public function eliminar($id)
    {
        try {
            Cache::forget('usuarioComentaTarea');

            $usuarioComentaTarea = UsuarioComentaTarea::where('id', $id)->firstOrFail();
            $usuarioComentaTarea->delete();

            return response()->json([
                'status' => true,
                'message' => 'Comentario eliminado correctamente.'
            ], 200);
        } catch (ModelNotFoundException $ex) {
            return response()->json([
                'status' => true,
                'message' => 'Comentario no encontrado.'
            ], 404);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => $th->getMessage()
            ], 500);
        }
    }
}
