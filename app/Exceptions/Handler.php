<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Throwable;
use Symfony\Component\HttpKernel\Exception\TooManyRequestsHttpException;

class Handler extends ExceptionHandler
{
    /**
     * Report or log an exception.
     */
    public function report(Throwable $exception): void
    {
        parent::report($exception);
    }

    /**
     * Render an exception into an HTTP response.
     */
    public function render($request, Throwable $exception)
    {
        if ($exception instanceof TooManyRequestsHttpException) {
            return response()->json([
                'message' => 'Çok fazla istek yaptınız. Lütfen 1 dakika sonra tekrar deneyin.'
            ], 429);
        }

        return parent::render($request, $exception);
    }
}
