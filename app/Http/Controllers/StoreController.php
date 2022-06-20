<?php

namespace App\Http\Controllers;

use App\Traits\RequestService;
use Illuminate\Http\Request;

class StoreController extends Controller
{
    use RequestService;

    protected $baseUri;
    protected $requestUri;
    public function __construct()
    {
        $this->baseUri = env('STORE_SERVICE_URI');
        $this->requestUri = request()->getRequestUri();
    }

    public function index()
    {
        return $this->getResponse(
            'GET',
            $this->baseUri,
            $this->requestUri
        );
    }

    public function store(Request $request)
    {
        return $this->getResponse(
            'POST',
            $this->baseUri,
            $this->requestUri,
            $request->all()
        );
    }

    public function show()
    {
        return $this->getResponse(
            'GET',
            $this->baseUri,
            $this->requestUri
        );
    }

    public function showByUser()
    {
        return $this->getResponse(
            'GET',
            $this->baseUri,
            $this->requestUri
        );
    }
}
