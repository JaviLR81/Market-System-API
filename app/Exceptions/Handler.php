<?php

namespace App\Exceptions;

use App\Traits\ApiResponser;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Validation\ValidationException;
use Throwable;

class Handler extends ExceptionHandler
{

    use ApiResponser;

    /**
     * A list of the exception types that are not reported.
     *
     * @var array<int, class-string<Throwable>>
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed for validation exceptions.
     *
     * @var array<int, string>
     */
    protected $dontFlash = [
        'current_password',
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

    // Este método se escribe para tomar el control de nuestro lado de las excepciones
    // Buscando la consistencia en el manejo de ellas acorde a una API REST FUL
    public function render($request, Throwable $exception)
    {
        // Manejando excepciones de validación
        if ($exception instanceof ValidationException) {
            return $this->convertValidationExceptionToResponse($exception, $request);
        }

        // Manejando excepciones de modelo no encontrado
        if ($exception instanceof ModelNotFoundException) {
            $modelo = class_basename($exception->getModel());
            return $this->errorResponse("No existe Ninguna Instancia de {$modelo} con el id espeficico", 404);
        }

        // En caso no sea alguna excepción conocida dejamos que Laravel la maneje
        return parent::render($request, $exception);
    }


     /**
     * Create a response object from the given validation exception.
     * This method help to us to return a json exception definied by us
     *
     * @param  \Illuminate\Validation\ValidationException  $e
     * @param  \Illuminate\Http\Request  $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    protected function convertValidationExceptionToResponse(ValidationException $e, $request)
    {
        $errors = $e->validator->errors()->getMessages();

        return $this->errorResponse($errors, 422);
    }
}
