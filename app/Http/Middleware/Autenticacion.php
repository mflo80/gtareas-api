<?php

namespace App\Http\Middleware;

use Closure;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Cache;


class Autenticacion
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */

    public function handle(Request $request, Closure $next)
    {
        $token = $request->header('Authorization');

        if ($token) {
            if (Cache::has($token)) {
                $datos = Cache::get($token);
                $ultimo_acceso = $datos['ultimo_acceso'];

                if (Carbon::now()->diffInMinutes($ultimo_acceso) >= 20) {
                    $usuario = $this->getUsuarioFromServer($token);
                    if (!$usuario) {
                        return response()->json([
                            'message' => 'Token no válido.'
                        ], 401);
                    }
                }

                return $next($request);
            }

            $usuario = $this->getUsuarioFromServer($token);

            if (!$usuario) {
                return response()->json([
                    'message' => 'Unauthenticated.'
                ], 401);
            }

            return $next($request);
        }

        return response()->json([
            'message' => 'Unauthenticated.'
        ], 401);
    }

    private function getUsuarioFromServer($token)
    {
        $client = new Client();

        try {
            $response = $client->get(getenv('GTOAUTH_AUTENTICADO'), [
                'headers' => [
                    'Authorization' => 'Bearer ' . $token,
                ],
            ]);

            if ($response->getStatusCode() == 200) {
                $valores = json_decode($response->getBody()->getContents());
                $usuario = $valores->usuario;
                Cache::put($token, ['usuario' => $usuario, 'ultimo_acceso' => Carbon::now()], Carbon::now()->addMinutes(getenv('SESSION_EXPIRATION')));

                return $usuario;
            }
        } catch (\Exception $e) {
            return null;
        }
    }
}
