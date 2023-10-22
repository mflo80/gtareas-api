<?php

namespace App\Http\Controllers;

use App\Models\UsuarioAsignaTarea;
use Illuminate\Http\Request;

class UsuarioAsignaTareaController extends Controller
{
    public function index()
    {
        $usuarioAsignaTareas = UsuarioAsignaTarea::all();

        return response()->json($usuarioAsignaTareas);
    }

    public function store(Request $request)
    {
        $usuarioAsignaTarea = UsuarioAsignaTarea::create($request->all());

        return response()->json($usuarioAsignaTarea, 201);
    }

    public function show(UsuarioAsignaTarea $usuarioAsignaTarea)
    {
        return response()->json($usuarioAsignaTarea);
    }

    public function update(Request $request, UsuarioAsignaTarea $usuarioAsignaTarea)
    {
        $usuarioAsignaTarea->update($request->all());

        return response()->json($usuarioAsignaTarea);
    }

    public function destroy(UsuarioAsignaTarea $usuarioAsignaTarea)
    {
        $usuarioAsignaTarea->delete();

        return response()->json(null, 204);
    }
}
