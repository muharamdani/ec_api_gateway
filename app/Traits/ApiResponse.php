<?php

declare(strict_types = 1);

namespace App\Traits;

use GuzzleHttp\Exception\ClientException;
use Illuminate\Http\Response;

use function response;

trait ApiResponse
{
    use RequestService;
    /**
     * @param     $data
     * @param int $statusCode
     *
     * @return mixed
     */
    public function successResponse($data, $statusCode = Response::HTTP_OK)
    {
        return response($data, $statusCode)->header('Content-Type', 'application/json');
    }

    /**
     * @param $errorMessage
     * @param $statusCode
     *
     * @return mixed
     */
    public function errorResponse($errorMessage, $statusCode)
    {
        $errorMessage->error_code = $statusCode;
        return response()->json($errorMessage, $statusCode);
    }

    /**
     * @param $errorMessage
     * @param $statusCode
     *
     * @return mixed
     */
    public function errorMessage($errorMessage, $statusCode)
    {
        return response($errorMessage, $statusCode)->header('Content-Type', 'application/json');
    }

    public function getResponse($method, $baseUri, $requestUri, $request = null) {
        try {
            if($request) {
                $req = $this->request($method, $baseUri, $requestUri, $request);
            } else {
                $req = $this->request($method, $baseUri, $requestUri);
            }
            return $this->successResponse($req);
        } catch (ClientException $e) {
            $err = json_decode($e->getResponse()->getBody()->getContents());
            return $this->errorResponse($err, $e->getCode());
        }
    }
}
