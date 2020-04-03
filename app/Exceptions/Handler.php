<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Symfony\Component\HttpKernel\Exception\HttpException;

class Handler extends ExceptionHandler
{
    public function render($request, \Exception $exception)
    {

        if ($exception instanceof ConflictException) {
            return response()->json(['error' => $exception->getMessage()], 409);
        }
        if ($exception instanceof InvalidArgumentException) {
            return response()->json(['error' => $exception->getMessage()], 400);
        }
        if ($exception instanceof ResourceNotFoundException) {
            return response()->json(['error' => $exception->getMessage()], 404);
        }
        if ($exception instanceof HttpException) {
            return response()->json(['error' => $exception->getMessage()], $exception->getStatusCode());
        }

        return parent::render($request, $exception);
    }
}
