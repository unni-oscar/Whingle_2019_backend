<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;

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
        
        // if ($exception instanceof Tymon\JWTAuth\Exceptions\TokenExpiredException) {
		// 	return response()->json(['error' => 'Token has expired'], $exception->getStatusCode());
		// } elseif ($exception instanceof Tymon\JWTAuth\Exceptions\TokenInvalidException) {
		// 	return response()->json(['error' => 'Token is invalid'], $exception->getStatusCode());
		// } elseif ($exception instanceof \Illuminate\Auth\AuthenticationException) {
		// 	return response()->json(['error' => 'Unauthorized'], 401);
		// } elseif ($exception instanceof WebsiteTokenMissingException) {
		// 	return response()->json(['error' => 'Unauthorized'], 401);
        // }
        
        return parent::render($request, $exception);
        // Handle all the exceptions and return json, if not authorised
        // if ($exception instanceof \Symfony\Component\HttpKernel\Exception\UnauthorizedHttpException) {
        //     switch (get_class($exception->getPrevious())) {
        //         case \Tymon\JWTAuth\Exceptions\TokenExpiredException::class:
        //             return response()->json([
        //                 'status' => 'error',
        //                 'message' => 'Token has expired'
        //             ], $exception->getStatusCode());
        //         case \Tymon\JWTAuth\Exceptions\TokenInvalidException::class:
        //         case \Tymon\JWTAuth\Exceptions\TokenBlacklistedException::class:
        //             return response()->json([
        //                 'status' => 'error',
        //                 'message' => 'Token is invalid'
        //             ], $exception->getStatusCode());
        //         default:
        //             break;
        //     }
        // }

    }
}
