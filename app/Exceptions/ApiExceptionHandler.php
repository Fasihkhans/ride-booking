<?php
// app/Exceptions/ApiExceptionHandler.php

namespace App\Exceptions;

use Exception;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Http\JsonResponse;

class ApiExceptionHandler extends ExceptionHandler
{
    // ...
    protected function renderJson($request, Exception $exception)
    {
        if ($exception instanceof \GuzzleHttp\Exception\ClientException) {
            $response = $exception->getResponse();
            $statusCode = $response->getStatusCode();
            $content = json_decode($response->getBody(), true);

            return new JsonResponse($content, $statusCode);
        }

        return parent::render($request, $exception);
    }
}