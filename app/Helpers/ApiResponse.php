<?php

namespace App\Helpers;

use Illuminate\Http\Response;
use Illuminate\Validation\ValidationException;
use Illuminate\Contracts\Validation\Validator;

class ApiResponse
{
    /**
     * Success response.
     *
     * @param mixed $data
     * @param string $message
     * @param int $statusCode
     * @param array $meta
     * @param array $headers
     * @return \Illuminate\Http\JsonResponse
     */
    public static function success($data = [], $message = 'Success', $statusCode = Response::HTTP_OK, $meta = [], $headers = [])
    {
        // $response = [
        //     'success' => true,
        //     'message' => $message,
        //      $data,
        //     'meta' => $meta,
        //     'statusCode' => $statusCode
        // ];

        return response()->json($data, $statusCode, $headers, JSON_UNESCAPED_UNICODE, JSON_UNESCAPED_SLASHES);
    }

    /**
     * Error response.
     *
     * @param string $message
     * @param int $statusCode
     * @param mixed $data
     * @param array $headers
     * @return \Illuminate\Http\JsonResponse
     */
    public static function error($message = 'Error', $statusCode = Response::HTTP_BAD_REQUEST, $data = null, $headers = [])
    {
        $response = [
            'success' => false,
            'message' => $message,
            'data' => $data,
            'statusCode' => $statusCode,
        ];

        return response()->json($response, $statusCode, $headers);
    }


    /**
     * Validation error response.
     *
     * @param array $errors
     * @param string $message
     * @param int $statusCode
     * @param array $headers
     * @return \Illuminate\Http\JsonResponse
     */
    public static function validationError(array $errors, $message = 'Validation failed', $statusCode = Response::HTTP_UNPROCESSABLE_ENTITY, $headers = [])
    {
        $response = [
            'status' => 'error',
            'message' => $message,
            'errors' => $errors
        ];

        return response()->json($response, $statusCode, $headers);
    }

    /**
     * Not found response.
     *
     * @param string $message
     * @param int $statusCode
     * @param array $headers
     * @return \Illuminate\Http\JsonResponse
     */
    public static function notFound($message = 'Not Found', $statusCode = Response::HTTP_NOT_FOUND, $headers = [])
    {
        return self::error($message, $statusCode, null, $headers);
    }

    /**
     * Paginated success response.
     *
     * @param mixed $data
     * @param string $message
     * @param int $statusCode
     * @param array $meta
     * @param array $headers
     * @return \Illuminate\Http\JsonResponse
     */
    public static function paginatedSuccess($data, $message = 'Success', $statusCode = Response::HTTP_OK, $meta = [], $headers = [])
    {
        $response = [
            'status' => 'success',
            'message' => $message,
            'data' => $data->items(),
            'meta' => $meta,
            'pagination' => [
                'total' => $data->total(),
                'per_page' => $data->perPage(),
                'current_page' => $data->currentPage(),
                'last_page' => $data->lastPage(),
                'next_page_url' => $data->nextPageUrl(),
                'prev_page_url' => $data->previousPageUrl(),
            ]
        ];

        return response()->json($response, $statusCode, $headers);
    }
}
