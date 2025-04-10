<?php

namespace App\Exceptions;

use App\Helper\Helper;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Throwable;

class Handler
{
    /**
     * Render an exception into an HTTP response.
     *
     * @param Request $request
     * @param Throwable $exception
     * @return Response
     */
    public function render(Request $request, Throwable $exception)
    {
        // Handle 404 specifically
        if ($exception instanceof NotFoundHttpException) {
            return  abort(404);
        }

        // Check if the request expects JSON (e.g., for APIs)
        if ($request->expectsJson()) {
            return new Response(
                json_encode(['error' => $exception->getMessage(), 'code' => $exception->getCode()]),
                500,
                ['Content-Type' => 'application/json']
            );
        }

        // Default HTML response for web requests
        return new Response(
            "<h1>Whoops, something went wrong!</h1><p>{$exception->getMessage()}</p>",
            500,
            ['Content-Type' => 'text/html']
        );
    }
}
