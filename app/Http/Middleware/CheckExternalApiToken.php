<?php

namespace App\Http\Middleware;

use Closure;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
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
            $response = $client->get(getenv('GTOAUTH_AUTENTICADO'), [
                'headers' => [
                    'Authorization' => 'Bearer ' . $token,
                ],
            ]);

            // Si la solicitud es exitosa, el usuario está autenticado
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
