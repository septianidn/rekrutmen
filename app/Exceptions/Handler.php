<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Spatie\Permission\Exceptions\UnauthorizedException;
use Illuminate\Auth\Access\AuthorizationException;
use Symfony\Component\HttpKernel\Exception\HttpExceptionInterface;
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

    protected function renderHttpException(HttpExceptionInterface $e)
    {
        try {
            $request = request();
            app(\App\Http\Middleware\EncryptCookies::class)->handle($request, function ($req) {
                app(\Illuminate\Session\Middleware\StartSession::class)->handle($req, function ($req) {
                    // Session is now booted, @auth/@guest will work in error views
                });
            });
        } catch (\Throwable $th) {
            // Silently fail — buttons will show as if guest
        }

        return parent::renderHttpException($e);
    }

    public function render($request, Throwable $exception)
        {
            // if ($exception instanceof \Symfony\Component\HttpKernel\Exception\NotFoundHttpException) {
            //     return response()->view('errors.error404', [], 404);
            // }

            // else if ($exception instanceof \Symfony\Component\HttpKernel\Exception\UnauthorizedHttpException) {
            //     return response()->view('errors.error401', [], 401);
            // }
            // else if ($exception instanceof AuthorizationException) {
            //     return response()->view('errors.error403', [], 403);
            // }

            return parent::render($request, $exception);
        }


}
