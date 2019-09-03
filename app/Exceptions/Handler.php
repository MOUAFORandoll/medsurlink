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
        if ($request->has('error'))
        {
            return  response()->json(['error'=>$request->all()['error']],419);
        }

        if ($exception instanceof \Swift_TransportException ) {
            return response()->json(['error'=>"L'operation à reussi mais le mail n'a pas ete envoye. Verifier votre connexion internet ou les configurations de votre serveur de messagerie la prochaine fois"],419);
        }
        return parent::render($request, $exception);
    }
}
