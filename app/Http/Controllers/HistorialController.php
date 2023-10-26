<?php

namespace App\Http\Controllers;

use App\Models\Historial;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;

class HistorialController extends Controller
{
    public function guardar(Request $request)
    {
        try {
            $historial = new Historial();
            $historial->id_usuario = $request->post('id_usuario');
            $historial->id_tarea = $request->post('id_tarea');
            $historial->fecha_hora_modificacion = now();
            $historial->save();

            return response()->json([
                'status' => true,
                'message' => 'Historial registrado correctamente.'
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
            $historial = Historial::all();

            if($historial->isEmpty()) {
                return response()->json([
                    'status' => true,
                    'message' => 'No hay historiales registrados.'
                ], 404);
            }

            return response()->json([
                'tareas' => $historial,
                'status' => true,
                'message' => 'Historiales encontrados.'
            ], 200);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => $th->getMessage()
            ], 500);
        }
    }

    public function buscar_historial($id)
    {
        try {
            $historial = Historial::findOrFail($id);

            return response()->json([
                'tarea' => $historial,
                'status' => true,
                'message' => 'Historial encontrado.'
            ], 200);
        } catch (ModelNotFoundException $ex) {
            return response()->json([
                'status' => true,
                'message' => 'Historial no encontrado.'
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
            $historial = Historial::findOrFail($id_tarea);

            return response()->json([
                'tarea' => $historial,
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

    public function buscar_usuario($id_usuario)
    {
        try {
            $historial = Historial::findOrFail($id_usuario);

            return response()->json([
                'tarea' => $historial,
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

    public function modificar(Request $request, Historial $historial)
    {
        try {
            $historial->id_usuario = $request->post('id_usuario');
            $historial->id_tarea = $request->post('id_tarea');
            $historial->fecha_hora_modificacion = now();
            $historial->save();

            return response()->json([
                'status' => true,
                'message' => 'Historial modificado correctamente.'
            ], 200);
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
            $historial = Historial::findOrFail($id);
            $historial->delete();

            return response()->json([
                'status' => true,
                'message' => 'Historial eliminado con éxito.'
            ], 200);
        } catch (ModelNotFoundException $ex) {
            return response()->json([
                'status' => true,
                'message' => 'Historial no encontrado.'
            ], 404);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => $th->getMessage()
            ], 500);
        }
    }
}
