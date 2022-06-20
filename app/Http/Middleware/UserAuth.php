<?php

namespace App\Http\Middleware;

use Closure;
use GuzzleHttp\Client;
use Illuminate\Http\Request;

class UserAuth
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     */
    public function handle(Request $request, Closure $next)
    {
        $token = $request->header('Authorization');
        $client = new Client();
        $baseUri = env('USER_SERVICE_URI');
        $requestUrl = '/user/profile';
        $method = 'GET';
        $headers = [
            'Authorization' => $token
        ];
        try {
            $response = $client->request($method, $baseUri.$requestUrl,
                [
                    'headers' => $headers
                ]
            );
            $user = $response->getBody()->getContents();
            $request->merge(['user_data' => $user]);
            return $next($request);
        } catch (\Throwable $e) {
            $err = json_decode($e->getResponse()->getBody()->getContents());
            return response()->json([
                'error' => $err
            ], 401);
        }
    }
}
