<?php

namespace App\Exceptions;

use DomainException;
use Exception;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Validation\ValidationException;

/**
 * Class Handler
 * @package App\Exceptions
 */
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
     * @param Exception $exception
     * @return void
     * @throws Exception
     */
    public function report(Exception $exception)
    {
        parent::report($exception);
    }

    /**
     * Render an exception into an HTTP response.
     * @param  Request  $request
     * @param  Exception  $exception
     * @return Response
     */
    public function render($request, Exception $exception)
    {
        $code = 500;
        $message = $exception->getMessage();
        if ($exception instanceof DomainException) {
            $code = 422;
        }

        if ($exception instanceof ValidationException) {
            $message = collect($exception->errors())->map(function ($item, $key) {
                return $key . ' ' . $item[0];
            })->implode(', ');

            $code = 422;
        }

        return response()->json([
            'status'  => 'error',
            'code'    => $exception->getCode(),
            'message' => $message,
        ], $code);
    }
}
