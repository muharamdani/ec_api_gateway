<?php

namespace App\Http\Controllers;

use App\Traits\RequestService;
use GuzzleHttp\Exception\ClientException;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    use RequestService;

    protected $baseUri;

    public function __construct() {
        $this->baseUri = env('USER_SERVICE_URI');
    }

    public function login(Request $request)
    {
        try {
            $req = $this->request(
                'POST',
                $this->baseUri,
                '/login',
                $request->all()
            );

            return $this->successResponse($req);
        } catch (ClientException $e) {
            $err = json_decode($e->getResponse()->getBody()->getContents());
            return $this->errorResponse($err, $e->getCode());
        }
    }

    public function register(Request $request)
    {
        try {
            $req = $this->request('POST',
                $this->baseUri,
                '/register',
                $request->all()
            );

            return $this->successResponse($req);
        } catch (ClientException $e) {
            $err = json_decode($e->getResponse()->getBody()->getContents());
            return $this->errorResponse($err, $e->getCode());
        }
    }

    public function refresh()
    {
        $req = $this->request('POST',
            $this->baseUri,
            '/refresh',
        );

        return $this->successResponse($req);
    }

    public function logout()
    {
        $req = $this->request('POST', $this->baseUri, '/logout');
        return $this->successResponse($req);
    }

    public function profile()
    {
        $req = $this->request('GET', $this->baseUri, '/user/profile');
        return $this->successResponse($req);
    }
}
