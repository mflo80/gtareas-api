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
            $usuarioAsignaTarea = new UsuarioAsignaTarea();
            $usuarioAsignaTarea->id_usuario_creador = $request->post('id_usuario_creador');
            $usuarioAsignaTarea->id_usuario_asignado = $request->post('id_usuario_asignado');
            $usuarioAsignaTarea->id_tarea = $request->post('id_tarea');
            $usuarioAsignaTarea->fecha_hora_asignacion = now();
            $usuarioAsignaTarea->fecha_hora_expiracion = $request->post('fecha_hora_expiracion');
            $usuarioAsignaTarea->permiso = $request->post('permiso');
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

    public function buscar_usuario($id_usuario_asignado)
    {
        try {
            $usuarioAsignaTarea = UsuarioAsignaTarea::where('id_usuario_asignado', $id_usuario_asignado)->firstOrFail();

            return response()->json([
                'tarea' => $usuarioAsignaTarea,
                'status' => true,
                'message' => 'Usuario asignado encontrado.'
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
            $usuarioAsignaTarea = UsuarioAsignaTarea::where('id_tarea', $id_tarea)->firstOrFail();

            return response()->json([
                'tarea' => $usuarioAsignaTarea,
                'status' => true,
                'message' => 'Tarea asignada encontrada.'
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

    public function buscar_usuario_tarea($id_usuario_asignado, $id_tarea)
    {
        try {
            $usuarioAsignaTarea = UsuarioAsignaTarea::where('id_usuario_asignado', $id_usuario_asignado)
                ->where('id_tarea', $id_tarea)
                ->firstOrFail();

            return response()->json([
                'tarea' => $usuarioAsignaTarea,
                'status' => true,
                'message' => 'Usuario asignado encontrado.'
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

    public function modificar(Request $request, $id_usuario_asignado, $id_tarea)
    {
        try {
            $usuarioAsignaTarea = UsuarioAsignaTarea::where('id_usuario_asignado', $id_usuario_asignado)
                ->where('id_tarea', $id_tarea)
                ->firstOrFail();

            $usuarioAsignaTarea->fecha_hora_expiracion = $request->input('fecha_hora_expiracion');
            $usuarioAsignaTarea->permiso = $request->input('permiso');
            $usuarioAsignaTarea->save();

            return response()->json([
                'status' => true,
                'message' => 'Asignación modificada correctamente.'
            ], 200);
        } catch (ModelNotFoundException $ex) {
            return response()->json([
                'status' => false,
                'message' => 'No se encontró la asignación de tarea.'
            ], 404);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => $th->getMessage()
            ], 500);
        }
    }

    public function eliminar($id_usuario_asignado, $id_tarea)
    {
        try {
            $usuarioAsignaTarea = UsuarioAsignaTarea::where('id_usuario_asignado', $id_usuario_asignado)
                ->where('id_tarea', $id_tarea)
                ->firstOrFail();

            $usuarioAsignaTarea->delete();

            return response()->json([
                'status' => true,
                'message' => 'Asignación eliminada correctamente.'
            ], 200);
        } catch (ModelNotFoundException $ex) {
            return response()->json([
                'status' => true,
                'message' => 'Asignación no encontrada.'
            ], 404);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => $th->getMessage()
            ], 500);
        }
    }
}
