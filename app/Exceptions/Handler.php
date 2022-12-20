<?php

namespace App\Exceptions;

use App\Traits\ApiResponse;
use Exception;
use Illuminate\Http\Response;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Database\Eloquent\RelationNotFoundException;
use GuzzleHttp\Exception\ClientException;
use Illuminate\Database\QueryException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\HttpKernel\Exception\UnauthorizedHttpException;

class Handler extends ExceptionHandler
{
    use ApiResponse;
    /**
     * A list of the exception types that are not reported.
     *
     * @var array
     */
    protected $dontReport = [
        AuthorizationException::class,
        HttpException::class,
        ModelNotFoundException::class,
        ValidationException::class
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
        if ($exception instanceof HttpException) {
            $errorCode = $exception->getStatusCode();
            $errorMessage = Response::$statusTexts[$errorCode];
            return $this->errorResponse($errorMessage, $errorCode);
        }

        if ($exception instanceof ModelNotFoundException) {
            $model = strtolower(class_basename($exception->getModel()));
            return $this->errorResponse(
                "Does not exist any instance of {$model} with a given id",
                Response::HTTP_NOT_FOUND);
        }

        if ($exception instanceof AuthorizationException) {
            return $this->errorResponse(
                $exception->getMessage(),
                Response::HTTP_FORBIDDEN);
        }

        if ($exception instanceof AuthenticationException) {
            return $this->errorResponse(
                $exception->getMessage(),
                Response::HTTP_UNAUTHORIZED);
        }

        if ($exception instanceof ValidationException) {
            $errors = $exception->validator->errors()->getMessages();
            return $this->errorResponse(
                $errors,
                Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        if ($exception instanceof ClientException) {
            $errorMessage = $exception->getResponse()->getBody();
            $errorCode = $exception->getCode();

            return $this->errorMessage($errorMessage, $errorCode);
        }

        if ($exception instanceof RelationNotFoundException){
            return  response()->json(['error'=>$exception->getMessage(),'type'=>'Eloquent'],422);
        }

        if ($exception instanceof ValidationException){
            return  response()->json(['error'=>$exception->errors(),'type'=>'Validation'],422);
        }

        if ($exception instanceof QueryException){
            return  response()->json(['error'=>$exception->getMessage(),'type'=>'Database'],422);
        }

        if ($exception instanceof PersonnnalException ) {
            return response()->json(['error'=>$exception->getErrorMessage(),'type'=>'Database or logic'],419);
        }

        if ($exception instanceof \Swift_TransportException ) {
            Log::error($exception->getMessage());
            $responseError = new FormattedErrorResponse('notSendMail',"L'operation à reussi mais le mail n'a pas ete envoye. Verifier votre connexion internet ou contacter l'administrateur");
            return response()->json(['error'=>$responseError->getArrayError()],419);
        }

        if ($request->is('api/*') || $request->wantsJson())
        {
            if($exception instanceof UnauthorizedHttpException){
                $json = [
                    'status' => 'failed',
                    'message' => 'Api authentication failed',
                ];
                return response()->json($json, 401);
            }
        }
        /* if ($request->is('api/*') || $request->wantsJson())
        {
            if($exception instanceof AuthenticationException){
                $json = [
                    'status' => 'failed',
                    'message' => 'vous devez vous authentifier',
                ];
                return response()->json($json, 401);
            }
        } */
        if (config('app.debug')) {
            return parent::render($request, $exception);
        }

        return $this->errorResponse(
            "Unexpected error. Try later!",
            Response::HTTP_INTERNAL_SERVER_ERROR);
    }
}
