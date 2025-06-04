<?php

namespace App\Exceptions;

use Exception;
use Throwable;
use Illuminate\Auth\AuthenticationException;
use Symfony\Component\HttpFoundation\Response;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;
use Tymon\JWTAuth\Exceptions\TokenInvalidException;
use Tymon\JWTAuth\Exceptions\JWTException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;

class InvalidToken extends ExceptionHandler
{
    public function render($request, Throwable $exception)
    {
        // Tangani AuthenticationException
        if ($exception instanceof AuthenticationException) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthenticated or invalid token',
            ], Response::HTTP_UNAUTHORIZED);
        }

        // Tangani TokenExpiredException
        if ($exception instanceof TokenExpiredException) {
            return response()->json([
                'success' => false,
                'message' => 'Token has expired',
            ], Response::HTTP_UNAUTHORIZED);
        }

        // Tangani TokenInvalidException
        if ($exception instanceof TokenInvalidException) {
            return response()->json([
                'success' => false,
                'message' => 'Token is invalid',
            ], Response::HTTP_UNAUTHORIZED);
        }

        // Tangani JWTException umum
        if ($exception instanceof JWTException) {
            return response()->json([
                'success' => false,
                'message' => 'Token is not provided',
            ], Response::HTTP_UNAUTHORIZED);
        }

        // Default: kembalikan ke handler bawaan
        return parent::render($request, $exception);
    }
}