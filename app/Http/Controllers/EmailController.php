<?php

namespace App\Http\Controllers;

use App\Models\Tarea;
use App\Jobs\EmailJobs;
use Illuminate\Http\Request;

class EmailController extends Controller
{
    public function enviar(Request $request) {
        try {
            $tarea = new Tarea();
            $tarea->id_tarea = $request->post('id_tarea');
            $tarea->titulo = $request->post('titulo');
            $tarea->texto = $request->post('texto');
            $tarea->fecha_hora_creacion = now();
            $tarea->fecha_hora_inicio = $request->post('fecha_hora_inicio');
            $tarea->fecha_hora_fin = $request->post('fecha_hora_fin');
            $tarea->categoria = $request->post('categoria');
            $tarea->estado = $request->post('estado');
            $tarea->id_usuario_modificacion = $request->post('id_usuario_modificacion');
            $tarea->id_usuario = $request->post('id_usuario');
            $nombre_usuario = $request->post('nombre_usuario');
            $usuarios_asignados = $request->post('usuarios_asignados');
            $usuarios_eliminados = $request->post('usuarios_eliminados');
            $tipo = $request->post('tipo');

            if (is_array($usuarios_asignados)) {
                $usuarios_asignados_email = array_map(function($usuario) {
                    return $usuario['email'];
                }, $usuarios_asignados);

                $usuarios_asignados_nombres = array_map(function($usuario) {
                    return $usuario['nombre'] . ' ' . $usuario['apellido'];
                }, $usuarios_asignados);
            }

            if (is_array($usuarios_eliminados)) {
                $usuarios_eliminados_email = array_map(function($usuario) {
                    return $usuario['email'];
                }, $usuarios_eliminados);

                $usuarios_eliminados_nombres = array_map(function($usuario) {
                    return $usuario['nombre'] . ' ' . $usuario['apellido'];
                }, $usuarios_eliminados);
            }

            $datos = [
                'from' => getenv('MAIL_FROM_ADDRESS'),
                'subject' => ($tipo == 'creación' ? 'Creación' : 'Modificación') . ' de Tarea #' . $tarea->id_tarea,
                'titulo' => $tarea->titulo,
                'texto' => $tarea->texto,
                'solicitante' => $nombre_usuario,
                'fecha_creacion' =>  $tarea->fecha_hora_creacion,
                'fecha_hora_inicio' => $tarea->fecha_hora_inicio,
                'fecha_hora_fin' => $tarea->fecha_hora_fin,
                'categoria' => $tarea->categoria,
                'estado' => $tarea->estado,
                'usuarios_asignados' => $usuarios_asignados_nombres,
                'usuarios_eliminados' => $tipo == 'modificación' ? $usuarios_eliminados_nombres : [],
            ];

            foreach ($usuarios_asignados_email as $email) {
                $datos['to'] = $email;
                dispatch(new EmailJobs($datos));
            }

            if($tipo == 'modificación') {
                foreach ($usuarios_eliminados_email as $email) {
                    $datos['to'] = $email;
                    dispatch(new EmailJobs($datos));
                }
            }

            return response()->json([
                'status' => true,
                'message' => 'Correo enviado correctamente.'
            ], 200);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => $th->getMessage()
            ], 500);
        }
    }

}
