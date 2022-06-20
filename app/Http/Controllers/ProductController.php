<?php

namespace App\Http\Controllers;

use App\Traits\RequestService;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    use RequestService;

    protected $baseUri;
    protected $requestUri;
    public function __construct()
    {
        $this->baseUri = env('PRODUCT_SERVICE_URI');
        $this->requestUri = request()->getRequestUri();
    }

    public function index()
    {
        return $this->getResponse('GET', $this->baseUri, $this->requestUri);
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
        return $this->getResponse('GET', $this->baseUri, $this->requestUri);
    }

    public function productsByStore()
    {
        return $this->getResponse('GET', $this->baseUri, $this->requestUri);
    }

    public function update(Request $request)
    {
        return $this->getResponse(
            'PUT',
            $this->baseUri,
            $this->requestUri,
            $request->all()
        );
    }

    public function destroy()
    {
        return $this->getResponse(
            'DELETE',
            $this->baseUri,
            $this->requestUri,
        );
    }
}
