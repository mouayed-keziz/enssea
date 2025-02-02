<?php

namespace App\Traits;

trait ApiResponse
{
    protected function successResponse($data, $message = 'Opération réussie', $code = 200)
    {
        return response()->json(array_merge([
            'status' => 'success',
            'message' => $message,
        ], $data), $code);
    }

    protected function errorResponse($message = 'Une erreur s\'est produite', $code = 404)
    {
        return response()->json([
            'status' => 'error',
            'message' => $message,
        ], $code);
    }
}
