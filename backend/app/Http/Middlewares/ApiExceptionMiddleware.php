<?php

declare(strict_types=1);

namespace App\Http\Middlewares;

use Closure;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class ApiExceptionMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        $response = $next($request);

        // If debug mode is enabled, return the response as is
        $isDebug = config('app.debug');

        // If the request is not an API request, return the response as is
        [$first] = explode('/', $request->path());
        if ($first !== 'api') {
            return $response;
        }

        // If the response is an exception, log the exception and return an API response
        $exception = $response->exception;
        if (!$exception && $response->original instanceof \Exception) {
            $exception = $response->original;
        }

        if ($exception) {
            \Log::error('[ApiExceptionMiddleware]' . $exception->getMessage(), [$exception]);
            $response = $this->apiExceptionResponse($exception)->withHeaders(['Content-Type' => 'application/json']);
        }
        return $response;
    }

    public function apiExceptionResponse($exception, $statusCode = null)
    {
        // Get the exception message
        $message = $exception->getMessage();

        $exceptionStatusCode = Response::HTTP_INTERNAL_SERVER_ERROR;
        if (method_exists($exception, 'getStatusCode')) {
            $exceptionStatusCode = $exception->getStatusCode();
        } elseif (method_exists($exception, 'getCode')) {
            $exceptionStatusCode = $exception->getCode();
        }

        // If the exception status code is not within the valid range, set it to 500 (ex. SQL codes are strings)
        if ($exceptionStatusCode < Response::HTTP_CONTINUE || $exceptionStatusCode > Response::HTTP_NETWORK_AUTHENTICATION_REQUIRED || is_string($exceptionStatusCode)) {
            $exceptionStatusCode = Response::HTTP_INTERNAL_SERVER_ERROR;
        }

        if ($exception instanceof ModelNotFoundException) {
            $modelParts = explode('\\', $exception->getModel());
            $message = sprintf(
                '%s not found',
                end($modelParts)
            );
            $exceptionStatusCode = Response::HTTP_NOT_FOUND;
        } elseif ($exception instanceof ValidationException) {
            $exceptionStatusCode = Response::HTTP_UNPROCESSABLE_ENTITY;
        } elseif ($exception instanceof NotFoundHttpException) {
            $exceptionStatusCode = Response::HTTP_NOT_FOUND;
        } elseif ($exception instanceof AuthenticationException) {
            $exceptionStatusCode = Response::HTTP_UNAUTHORIZED;
        }

        if ($statusCode) {
            $exceptionStatusCode = $statusCode;
        }

        $content = [
            'status' => 'error',
            'message' => $message,
            'statusCode' => $exceptionStatusCode,
            'exception' => get_class($exception),
            'trace' => config('app.env') === 'local' ? $exception->getTrace() : null,
        ];

        return new Response($content, $content['statusCode'], ['Content-Type' => 'application/json']);
    }
}
