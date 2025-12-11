<?php

namespace App\Helpers;

use Symfony\Component\HttpFoundation\Response;

class ApiResponse {

    public static function success($data = null, $message = 'Success', $status = 200) : Response 
    {
        return response()->json([
            'status'  => true,
            'message' => $message,
            'data'    => $data,
        ], $status);
    }

    public static function error($message = 'Somethings Went Wrong', $status = 400, $errors = []) : Response 
    {
        return response()->json([
            'status'  => true,
            'message' => $message,
            'errors' => $errors
        ], $status);
    }
}