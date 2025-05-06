<?php

namespace App\Traits;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Exceptions\HandleResourceNotExistException;

trait HasHttpResponse
{
    /**
     * @param mixed $data
     * @param int $statusCode
     * @param string $message
     * @return \Illuminate\Http\JsonResponse
     */
    public function success($data = null, $statusCode = 200, $message = 'Successfully')
    {
        $response = [
            'status' => $statusCode,
            'success' => true,
            'message' => $message,
        ];

        if ($data !== null) {
            $response['data'] = $data;
        }

        return response()->json($response, $statusCode);
    }

    /**
     * @param mixed $data
     * @param int $statusCode
     * @param string $message
     * @param array $custom
     * @return \Illuminate\Http\JsonResponse
     */
    public function successPaginate($data = null, $statusCode = 200, $message = 'Successfully', $custom = [])
    {
        $response = [
            'status' => $statusCode,
            'success' => true,
            'message' => $message,
        ];

        if ($data !== null) {
            if ($data instanceof JsonResource) {
                $response['data'] = [];

                // Tambahkan custom resource jika ada
                if (!empty($custom)) {
                    foreach ($custom as $key => $value) {
                        $response['data'][$key] = $value;
                    }
                }

                // Tambahkan items dan pagination
                $response['data']['items'] = $data;
                $response['data']['pagination'] = [
                    'current_page' => $data->currentPage(),
                    'from' => $data->firstItem(),
                    'last_page' => $data->lastPage(),
                    'path' => url()->current(),
                    'per_page' => $data->perPage(),
                    'to' => $data->lastItem(),
                    'total' => $data->total(),
                ];

                // Tambahkan links
                $response['links'] = [
                    'first' => $data->url(1),
                    'last' => $data->url($data->lastPage()),
                    'prev' => $data->previousPageUrl(),
                    'next' => $data->nextPageUrl(),
                ];
            } else {
                $response['data'] = $data;
            }
        }

        return response()->json($response, $statusCode);
    }

    /**
     * @param string $message
     * @param int $statusCode
     * @return \Illuminate\Http\JsonResponse
     */
    public function error($message, $statusCode = 400)
    {
        return response()->json([
            'status' => 'error',
            'message' => $message,
        ], $statusCode);
    }

    /**
     * @param string $message
     * @param int $statusCode
     * @return \Illuminate\Http\JsonResponse
     */
    public function handleResourceNotExist($model, $message = 'Resource not found', $statusCode = 404)
    {
        if ($model == null) {
            throw new HandleResourceNotExistException($message, $statusCode);
        }
    }

    /**
     * @param string $message
     * @param int $statusCode
     * @return \Illuminate\Http\JsonResponse
     */
    public function handleErrorCondition($condition, $message = 'Resource not found', $statusCode = 404)
    {
        if ($condition) {
            throw new HandleResourceNotExistException($message, $statusCode);
        }
    }

    /**
     * @param string $message
     * @param int $statusCode
     * @return \Illuminate\Http\JsonResponse
     */
    public function notFound($message = 'Resource not found', $statusCode = 404)
    {
        return response()->json([
            'status' => 'error',
            'message' => $message,
        ], $statusCode);
    }
}
