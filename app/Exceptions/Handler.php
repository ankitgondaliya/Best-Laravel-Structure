<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
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
     * Register the exception handling callbacks for the application.
     *
     * @return void
     */
    public function register()
    {
        $this->reportable(function (Throwable $e) {
            //
        });
    }

    public function render($request, Throwable $exception)
    {
        if ($request->expectsJson()) {
            if($exception->getMessage() == 'Unauthenticated.'){
                return response()->json([
                    'status'   => false,
                    'status_code'   => 401,
                    'message' => 'Unauthenticated user!'
                ]);
            } else if ($exception instanceof \Symfony\Component\HttpKernel\Exception\NotFoundHttpException){
                    return response()->json([
                    'status'   => false,
                    'status_code'   => 404,
                    'message' => 'End point not found!'
                ]);
            } else if ($exception instanceof \Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException){
                    return response()->json([
                    'status'   => false,
                    'status_code'   => 405,
                    'message' => 'Method not allowed!'
                ]);
            }
        }
        return parent::render($request, $exception);
    }
}
