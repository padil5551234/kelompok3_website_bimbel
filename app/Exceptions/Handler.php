<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Throwable;

class Handler extends ExceptionHandler
{
    /**
     * A list of exception types with their corresponding custom log levels.
     *
     * @var array<class-string<\Throwable>, \Psr\Log\LogLevel::*>
     */
    protected $levels = [
        //
    ];

    /**
     * A list of the exception types that are not reported.
     *
     * @var array<int, class-string<\Throwable>>
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed to the session on validation exceptions.
     *
     * @var array<int, string>
     */
    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    /**
     * Register the exception handling callbacks for the application.
     */
    public function register(): void
    {
        $this->reportable(function (Throwable $e) {
            //
        });
    }

    /**
     * Render an exception into an HTTP response.
     */
    public function render($request, Throwable $exception)
    {
        // Check if the request wants a JSON response (API calls)
        if ($request->expectsJson()) {
            return response()->json([
                'error' => 'Terjadi kesalahan',
                'message' => $exception->getMessage(),
                'code' => $exception->getCode()
            ], 500);
        }

        // Use custom error views for HTTP exceptions
        if ($this->isHttpException($exception)) {
            $statusCode = $exception->getStatusCode();
            
            // Map common HTTP status codes to custom views
            $errorViews = [
                400 => 'errors.400',
                403 => 'errors.403',
                404 => 'errors.404',
                419 => 'errors.419',
                500 => 'errors.500',
            ];
            
            if (isset($errorViews[$statusCode]) && view()->exists($errorViews[$statusCode])) {
                return response()->view($errorViews[$statusCode], [
                    'exception' => $exception,
                    'statusCode' => $statusCode
                ], $statusCode);
            }
            
            // Use general error page for other status codes
            if (view()->exists('errors.general')) {
                return response()->view('errors.general', [
                    'exception' => $exception,
                    'statusCode' => $statusCode
                ], $statusCode);
            }
        }
        
        // Fallback to default Laravel error handling
        return parent::render($request, $exception);
    }
}
