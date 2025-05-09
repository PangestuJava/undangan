<?php

namespace App\Exceptions;

use Throwable;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Validation\ValidationException;
use Illuminate\Http\Exceptions\HttpResponseException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

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

        if ($e instanceof AuthenticationException) {
            return response()->json([
                'status' => 'error',
                'message' => 'Unauthenticated',
            ], 401);
        }

        if ($e instanceof HttpResponseException) {
            $response = $e->getResponse();

            return response()->json([
                'status' => $response->original['status'] ?? 'error',
                'message' => $response->original['message'] ?? 'Unexpected error',
            ], $response->getStatusCode());
        }

        return response()->json([
            'status' => 'error',
            'message' => $e->getMessage() ?: 'Server error',
        ], method_exists($e, 'getStatusCode') ? $e->getStatusCode() : 500);
    }
}
