<?php

namespace App\Http\Controllers;

use App\Models\Tarea;
use Illuminate\Http\Request;

class TareaController extends Controller
{
    public function buscar()
    {
        $tareas = Tarea::all();

        return response()->json($tareas);
    }

    public function guardar(Request $request)
    {
        $tarea = Tarea::create($request->all());

        return response()->json($tarea, 201);
    }

    public function buscar_tarea(Tarea $tarea)
    {
        return response()->json($tarea);
    }

    public function modificar(Request $request, Tarea $tarea)
    {
        $tarea->update($request->all());

        return response()->json($tarea);
    }

    public function eliminar(Tarea $tarea)
    {
        $tarea->delete();

        return response()->json(null, 204);
    }
}
