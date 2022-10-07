<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Log;
use Throwable;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that are not reported.
     *
     * @var array
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed for validation exceptions.
     *
     * @var array
     */
    protected $dontFlash = [
        'password',
        'password_confirmation',
    ];


    /**
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Throwable  $exception
     * @throws \Throwable
     * @return \Symfony\Component\HttpFoundation\Response
     *
     */
    public function render($request, Throwable $exception)
    {
        return parent::render($request, $exception);
    }
    public function report(Throwable $exception)
    {
        parent::report($exception);
        Log::channel('slack')->critical($exception);
    }

    /**
     * Convert a validation exception into a JSON response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Illuminate\Validation\ValidationException  $exception
     * @return \Illuminate\Http\JsonResponse
     */
    protected function invalidJson($request, ValidationException $exception)
    {
        $message = collect($exception->errors())
            ->values()
            ->flatten()
            ->first() ?: $exception->getMessage();

        return response()->json([
            'message'   => $message,
            'errors'    => $exception->errors(),
            'messages' => collect($exception->errors())->values()->flatten(),
        ], $exception->status);
    }
}
