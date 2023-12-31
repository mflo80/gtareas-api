<?php

namespace App\Http\Controllers;

use App\Models\Tarea;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class TareaController extends Controller
{
    public function guardar(Request $request)
    {
        try {
            Cache::forget('tareas');

            $tarea = new Tarea();
            $tarea->titulo = $request->post('titulo');
            $tarea->texto = $request->post('texto');
            $tarea->fecha_hora_creacion = now();
            $tarea->fecha_hora_inicio = $request->post('fecha_hora_inicio');
            $tarea->fecha_hora_fin = $request->post('fecha_hora_fin');
            $tarea->categoria = $request->post('categoria');
            $tarea->estado = $request->post('estado');
            $tarea->id_usuario_modificacion = $request->post('id_usuario');
            $tarea->id_usuario = $request->post('id_usuario');
            $tarea->save();

            return response()->json([
                'tarea_id' => $tarea->id,
                'status' => true,
                'message' => 'Tarea #' . $tarea->id . ' creada correctamente.'
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
            $tareas = Cache::remember('tareas', 60, function () {
                return Tarea::all();
            });

            if($tareas->isEmpty()) {
                return response()->json([
                    'status' => false,
                    'message' => 'No hay tareas registradas.'
                ], 404);
            }

            return response()->json([
                'tareas' => $tareas,
                'status' => true,
                'message' => 'Tareas encontradas.'
            ], 200);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => $th->getMessage()
            ], 500);
        }
    }

    public function buscar_tarea($id)
    {
        try {
            $tarea = Tarea::findOrFail($id);

            return response()->json([
                'tarea' => $tarea,
                'status' => true,
                'message' => 'Tarea encontrada.'
            ], 200);
        } catch (ModelNotFoundException $ex) {
            return response()->json([
                'status' => false,
                'message' => 'Tarea no encontrada.'
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
            Cache::forget('tareas');

            $tarea = Tarea::findOrFail($id);
            $tarea->titulo = $request->post('titulo');
            $tarea->texto = $request->post('texto');
            $tarea->fecha_hora_inicio = $request->post('fecha_hora_inicio');
            $tarea->fecha_hora_fin = $request->post('fecha_hora_fin');
            $tarea->categoria = $request->post('categoria');
            $tarea->estado = $request->post('estado');
            $tarea->id_usuario_modificacion = $request->post('id_usuario_modificacion');
            $tarea->id_usuario = $request->post('id_usuario');

            if ($tarea->fecha_hora_creacion === null) {
                $tarea->fecha_hora_creacion = now()->format('Y-m-d H:i:s');
            }

            if ($tarea->isDirty()) {
                $tarea->save();

                return response()->json([
                    'status' => true,
                    'message' => 'Tarea modificada correctamente.'
                ], 200);
            }

            return response()->json([
                'status' => false,
                'message' => 'No se ha realizado ninguna modificación.'
            ], 204);
        } catch (ModelNotFoundException $ex) {
            return response()->json([
                'status' => false,
                'message' => 'Tarea no encontrada.'
            ], 404);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => $th->getMessage()
            ], 500);
        }
    }

    public function modificar_categoria(Request $request, $id)
    {
        try {
            Cache::forget('tareas');

            $tarea = Tarea::findOrFail($id);
            $tarea->categoria = $request->post('categoria');
            $tarea->id_usuario_modificacion = $request->post('id_usuario_modificacion');

            if ($tarea->isDirty()) {
                $tarea->save();

                return response()->json([
                    'status' => true,
                    'message' => 'Categoría modificada correctamente.'
                ], 200);
            }

            return response()->json([
                'status' => false,
                'message' => 'No se ha realizado ninguna modificación.'
            ], 204);
        } catch (ModelNotFoundException $ex) {
            return response()->json([
                'status' => false,
                'message' => 'Tarea no encontrada.'
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
            Cache::forget('tareas');

            $tarea = Tarea::findOrFail($id);
            $tarea->delete();

            if ($tarea->trashed()) {
                return response()->json([
                    'status' => true,
                    'message' => 'Tarea eliminada con éxito.'
                ], 200);
            }
        } catch (ModelNotFoundException $ex) {
            return response()->json([
                'status' => false,
                'message' => 'Tarea no encontrada.'
            ], 404);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => $th->getMessage()
            ], 500);
        }
    }
}
