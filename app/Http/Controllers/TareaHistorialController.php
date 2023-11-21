<?php

namespace App\Http\Controllers;

use App\Models\TareaHistorial;

class TareaHistorialController extends Controller
{
    public function buscar()
    {
        try {
            $tareas = TareaHistorial::all();

            if($tareas->isEmpty()) {
                return response()->json([
                    'status' => true,
                    'message' => 'No hay registros.'
                ], 404);
            }

            return response()->json([
                'tareas' => $tareas,
                'status' => true,
                'message' => 'Registros encontrados.'
            ], 200);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => $th->getMessage()
            ], 500);
        }
    }
}
