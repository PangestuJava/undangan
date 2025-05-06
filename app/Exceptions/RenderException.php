<?php

namespace App\Exceptions;

use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Throwable;

class RenderException
{
    public function __invoke(Throwable $e, $request)
    {
        if ($e instanceof ValidationException) {
            return response()->json([
                'status' => 'fail',
                'message' => 'Validation error',
                'errors' => $e->errors(),
            ], 422);
        }

        if ($e instanceof NotFoundHttpException) {
            return response()->json([
                'status' => 'fail',
                'message' => 'Route not found',
            ], 404);
        }

        return response()->json([
            'status' => 'error',
            'message' => $e->getMessage(),
        ], method_exists($e, 'getStatusCode') ? $e->getStatusCode() : 500);
    }
}
