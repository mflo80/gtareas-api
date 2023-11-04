<?php

namespace App\Http\Middleware;

use Closure;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Cache;
use Symfony\Component\HttpFoundation\Response;

class CheckExternalApiToken
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $token = $request->header('Authorization');

        $client = new Client();

        try {
            if(Cache::get($token) !== null){
                $ttl = Cache::getPayload($token)['time'] - time();
                if($ttl <= 600){ // 600 segundos son 10 minutos
                    $response = $client->get(getenv('GTOAUTH_AUTENTICADO'), [
                        'headers' => [
                            'Authorization' => 'Bearer ' . $token,
                        ],
                    ]);

                    $valores = json_decode($response->getBody()->getContents());
                    $usuario = $valores->usuario;
                    Cache::put($token, $usuario, Carbon::now()->addMinutes(getenv('SESSION_EXPIRATION')));
                }
            }

            return $next($request);

        } catch (\GuzzleHttp\Exception\ClientException $e) {
            // Si la solicitud devuelve un error 401, el usuario no está autenticado
            if ($e->getResponse()->getStatusCode() == 401) {
                return response()->json(['error' => 'Unauthenticated.'], 401);
            }

            // Si la solicitud devuelve otro error, relanzarlo
            throw $e;
        }
    }
}
