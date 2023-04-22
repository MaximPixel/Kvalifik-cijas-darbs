<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Throwable;

class Handler extends ExceptionHandler {

    protected $levels = [];

    protected $dontReport = [];

    protected $dontFlash = [
        "current_password",
        "password",
        "password_confirmation",
    ];

    public function register(): void {
        $this->reportable(function (Throwable $e) {
            
        });
    }

    public function render($request, Throwable $exception) {
        if ($exception instanceof NotFoundHttpException) {
            if (session("logout")) {
                return redirect()->route("index");
            }
        }

        return parent::render($request, $exception);
    }
}
