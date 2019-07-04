<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Session\TokenMismatchException;
use Illuminate\Validation\ValidationException;

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
     * @param  \Exception  $exception
     * @return void
     */
    public function report(Exception $exception)
    {
        parent::report($exception);
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
        if ($exception instanceof NotFoundException) {
            return response()->json(['error' => 'Not found'])->setStatusCode(404);
        }

        if ($exception instanceof \Spatie\Permission\Exceptions\UnauthorizedException) {
            return response()->json(['error' => 'unauthorized'])->setStatusCode(403);
        }

        if ($exception instanceof TokenMismatchException) {
            return response()->json(['error' => 'token mismatch'])->setStatusCode(419);
        }

        if ($exception instanceof ValidationException &&
            ($request->segment(1) == 'api' || ($request->segment(1) == 'admin') && $request->segment(2) == 'api')
        ) {
            return response()->json(['result' =>false, 'errors' => $exception->validator->errors()->messages()])->setStatusCode(422);
        }

        if (!config('app.debug')) {
            return response()->json(['error' => 'Some error in response. Please contact with server administrator.'], 500);
        }

        return parent::render($request, $exception);
    }
}
