<?php

namespace App\Http\Controllers;

use App\Models\Historial;
use Illuminate\Http\Request;

class HistorialController extends Controller
{
    public function index()
    {
        $historiales = Historial::all();

        return response()->json($historiales);
    }

    public function store(Request $request)
    {
        $historial = Historial::create($request->all());

        return response()->json($historial, 201);
    }

    public function show(Historial $historial)
    {
        return response()->json($historial);
    }

    public function update(Request $request, Historial $historial)
    {
        $historial->update($request->all());

        return response()->json($historial);
    }

    public function destroy(Historial $historial)
    {
        $historial->delete();

        return response()->json(null, 204);
    }
}
