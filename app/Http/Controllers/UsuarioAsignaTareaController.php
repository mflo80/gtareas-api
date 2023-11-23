<?php

namespace App\Http\Controllers;

use App\Models\UsuarioAsignaTarea;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;

class UsuarioAsignaTareaController extends Controller
{
    public function guardar(Request $request)
    {
        try {
            $usuarioAsignaTarea = UsuarioAsignaTarea::where('id_usuario_creador', $request->post('id_usuario_creador'))
            ->where('id_usuario_asignado', $request->post('id_usuario_asignado'))
            ->where('id_tarea', $request->post('id_tarea'))
            ->first();

            if($usuarioAsignaTarea) {
                if ($usuarioAsignaTarea->trashed()) {
                    $usuarioAsignaTarea->restore();
                }

                return response()->json([
                    'status' => true,
                    'message' => 'Tarea asignada correctamente.'
                ], 200);
            }

            $usuarioAsignaTarea = new UsuarioAsignaTarea();
            $usuarioAsignaTarea->id_usuario_creador = $request->post('id_usuario_creador');
            $usuarioAsignaTarea->id_usuario_asignado = $request->post('id_usuario_asignado');
            $usuarioAsignaTarea->id_tarea = $request->post('id_tarea');
            $usuarioAsignaTarea->fecha_hora_asignacion = now();
            $usuarioAsignaTarea->save();

            return response()->json([
                'status' => true,
                'message' => 'Tarea asignada correctamente.'
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
            $usuarioAsignaTarea = UsuarioAsignaTarea::all();

            if($usuarioAsignaTarea->isEmpty()) {
                return response()->json([
                    'status' => true,
                    'message' => 'No hay tareas asignadas.'
                ], 404);
            }

            return response()->json([
                'tareas' => $usuarioAsignaTarea,
                'status' => true,
                'message' => 'Tareas asignadas encontradas.'
            ], 200);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => $th->getMessage()
            ], 500);
        }
    }

    public function buscar_usuario_creador($id_usuario_creador){
        try {
            $usuarioAsignaTarea = UsuarioAsignaTarea::where('id_usuario_creador', $id_usuario_creador)->get();

            if($usuarioAsignaTarea->isEmpty()) {
                return response()->json([
                    'status' => true,
                    'message' => 'No hay tareas asignadas por este usuario.'
                ], 404);
            }

            return response()->json([
                'tareas' => $usuarioAsignaTarea,
                'status' => true,
                'message' => 'Tareas asignadas encontradas.'
            ], 200);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => $th->getMessage()
            ], 500);
        }

    }

    public function buscar_usuario_asignado($id_usuario_asignado)
    {
        try {
            $usuarioAsignaTarea = UsuarioAsignaTarea::where('id_usuario_asignado', $id_usuario_asignado)->get();

            if($usuarioAsignaTarea->isEmpty()) {
                return response()->json([
                    'status' => true,
                    'message' => 'No hay tareas asignadas a este usuario.'
                ], 404);
            }

            return response()->json([
                'tareas_asignadas' => $usuarioAsignaTarea,
                'status' => true,
                'message' => 'Tareas asignadas encontradas.'
            ], 200);
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
            $usuarioAsignaTarea = UsuarioAsignaTarea::where('id_tarea', $id_tarea)->get();

            if($usuarioAsignaTarea->isEmpty()) {
                return response()->json([
                    'status' => true,
                    'message' => 'No hay usuarios asignados a esta tarea.'
                ], 404);
            }

            return response()->json([
                'tarea_asignada' => $usuarioAsignaTarea,
                'status' => true,
                'message' => 'Tareas asignadas encontradas.'
            ], 200);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => $th->getMessage()
            ], 500);
        }
    }

    public function eliminar($id_usuario_creador, $id_usuario_asignado, $id_tarea)
    {
        try {
            $usuarioAsignaTarea = UsuarioAsignaTarea::where('id_usuario_creador', $id_usuario_creador)
            ->where('id_usuario_asignado', $id_usuario_asignado)
            ->where('id_tarea', $id_tarea)
            ->delete();

            return response()->json([
                'status' => true,
                'message' => 'Usuario asignado eliminado correctamente.'
            ], 200);
        } catch (ModelNotFoundException $ex) {
            return response()->json([
                'status' => true,
                'message' => 'Usuario asignado no encontrado.'
            ], 404);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => $th->getMessage(),
            ], 500);
        }
    }
}
