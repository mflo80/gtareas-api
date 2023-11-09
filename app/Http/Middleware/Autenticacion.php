<?php

namespace App\Http\Middleware;

use Closure;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Cache;
use Symfony\Component\HttpFoundation\Response;

class Autenticacion
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
            if ($token) {
                if(Cache::has($token)){
                    return $next($request);
                }

                $response = $client->get(getenv('GTOAUTH_AUTENTICADO'), [
                    'headers' => [
                        'Authorization' => 'Bearer ' . $token,
                    ],
                ]);

                $valores = json_decode($response->getBody()->getContents());
                $usuario = $valores->usuario;

                Cache::put($token, $usuario, Carbon::now()->addMinutes(getenv('SESSION_EXPIRATION')));

                return $next($request);
            }

            return response()->json([
                'message' => 'Unauthenticated.'], 401);

        } catch (\GuzzleHttp\Exception\ClientException $e) {
            throw $e;
        }
    }


    /*

        $token = $request->header('Authorization');

    $client = new Client();

    try {
        if ($token) {
            if(Cache::has($token)){
                $cacheData = Cache::get($token);
                $usuario = $cacheData['usuario'];
                $cacheTime = $cacheData['time'];

                if (Carbon::now()->diffInMinutes($cacheTime) >= 20) {
                    $response = $client->get(getenv('GTOAUTH_AUTENTICADO'), [
                        'headers' => [
                            'Authorization' => 'Bearer ' . $token,
                        ],
                    ]);

                    $valores = json_decode($response->getBody()->getContents());
                    $usuario = $valores->usuario;

                    Cache::put($token, ['usuario' => $usuario, 'time' => Carbon::now()], Carbon::now()->addMinutes(getenv('SESSION_EXPIRATION')));
                }

                return $next($request);
            }

            return response()->json([
                'message' => 'Unauthenticated.'], 401);

        } catch (\GuzzleHttp\Exception\ClientException $e) {
            throw $e;
        }
    }
    */
}
