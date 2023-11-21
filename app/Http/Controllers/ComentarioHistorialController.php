<?php

namespace App\Http\Controllers;

use App\Models\ComentarioHistorial;

class ComentarioHistorialController extends Controller
{
    public function buscar()
    {
        try {
            $comentarios = ComentarioHistorial::all();

            if($comentarios->isEmpty()) {
                return response()->json([
                    'status' => true,
                    'message' => 'No hay registros.'
                ], 404);
            }

            return response()->json([
                'comentarios' => $comentarios,
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
