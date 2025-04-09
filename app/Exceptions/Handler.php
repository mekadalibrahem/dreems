<?php

namespace App\Exceptions;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
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
    public function render(Request $request, Throwable $exception): Response
    {
        // Check if the request expects JSON (e.g., for APIs)
        if ($request->isXmlHttpRequest() || $request->headers->get('Accept') === 'application/json') {
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