<?php

namespace App\Http\Controllers;

use App\Models\UsuarioComentaTarea;
use Illuminate\Http\Request;

class UsuarioComentaTareaController extends Controller
{
    public function index()
    {
        $usuarioComentaTareas = UsuarioComentaTarea::all();

        return response()->json($usuarioComentaTareas);
    }

    public function store(Request $request)
    {
        $usuarioComentaTarea = UsuarioComentaTarea::create($request->all());

        return response()->json($usuarioComentaTarea, 201);
    }

    public function show(UsuarioComentaTarea $usuarioComentaTarea)
    {
        return response()->json($usuarioComentaTarea);
    }

    public function update(Request $request, UsuarioComentaTarea $usuarioComentaTarea)
    {
        $usuarioComentaTarea->update($request->all());

        return response()->json($usuarioComentaTarea);
    }

    public function destroy(UsuarioComentaTarea $usuarioComentaTarea)
    {
        $usuarioComentaTarea->delete();

        return response()->json(null, 204);
    }
}
