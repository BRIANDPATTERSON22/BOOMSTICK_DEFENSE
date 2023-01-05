<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Spatie\Permission\Exceptions\UnauthorizedException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;


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
     * Report or log an exception.
     *
     * This is a great spot to send exceptions to Sentry, Bugsnag, etc.
     *
     * @param  \Exception  $exception
     * @return void
     */
    public function report(Exception $exception)
    {
        parent::report($exception);
    }

    protected function unauthenticated($request, AuthenticationException $exception)
    {
        return redirect('login');
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Exception  $exception
     * @return \Illuminate\Http\Response
     */
    public function render($request, Exception $exception)
    {
        if ($exception instanceof NotFoundHttpException) {
            if($request->is('*admin/*')) {
                return response()->view('admin.errors.404', [], 404);
            }
            else{
                return response()->view('site.errors.404', [], 404);
            }
        }

        if ($exception instanceof UnauthorizedException) {
            if($request->is('*admin/*')) {
                return response()->view('admin.errors.401', [], 401);
            }
            else{
                return response()->view('site.errors.404', [], 404);
            }
        }

        if (app()->environment() == 'production') {
            if($exception instanceof \ErrorException) {
                return response()->view('site.errors.500', [], 500);
            }
            else{
                return parent::render($request, $exception);
            }
        }
        else {
            return parent::render($request, $exception);
        }

        return parent::render($request, $exception);
    }
}
