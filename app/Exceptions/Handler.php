<?php
declare(strict_types=1);

namespace BananaPHP\Exceptions;

use BananaPHP\Services\Http\Request;
use BananaPHP\Services\Http\Response;
use Throwable;

class Handler
{
    public function render(Request $request, Throwable $e): Response
    {
        if ($e instanceof ValidationException) {
            return $this->renderValidationException($e);
        }

        if ($e instanceof AuthenticationException) {
            return $this->renderAuthenticationException($e);
        }

        if ($e instanceof DatabaseException) {
            return $this->renderDatabaseException($e);
        }

        return $this->renderGenericException($e);
    }

    protected function renderValidationException(ValidationException $e): Response
    {
        return Response::json([
            'error' => 'Validation failed',
            'messages' => $e->getErrors(),
        ], 422);
    }

    protected function renderAuthenticationException(AuthenticationException $e): Response
    {
        return Response::json([
            'error' => 'Authentication failed',
            'message' => $e->getMessage(),
        ], 401);
    }

    protected function renderDatabaseException(DatabaseException $e): Response
    {
        $response = [
            'error' => 'Database error',
            'message' => 'An error occurred while accessing the database',
        ];

        if (env('APP_DEBUG', false)) {
            $response['debug'] = $e->getMessage();
        }

        return Response::json($response, 500);
    }

    protected function renderGenericException(Throwable $e): Response
    {
        $response = [
            'error' => 'Server error',
            'message' => 'An unexpected error occurred',
        ];

        if (env('APP_DEBUG', false)) {
            $response['debug'] = [
                'message' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'trace' => $e->getTrace(),
            ];
        }

        return Response::json($response, 500);
    }
}