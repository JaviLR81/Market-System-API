<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class TransformInput
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next, $transformer)
    {

        // Transformando las entradas, no los query params
        $transformedInput = [];

        // Recorriendo valores en el cuerpo de la consulta no en los query de URL
        foreach ($request->request->all() as $input => $value) {
            $transformedInput[$transformer::originalAttribute($input)] = $value;
        }

        // Reemplazando la petición original por la actual
        $request->replace($transformedInput);

        // Asignando la respuesya
        $response = $next($request);

        // Solamente errrores de validación de campos
        if (isset($response->exception) && $response->exception instanceof ValidationException) {
            $data = $response->getData();

            $transformedErrors = [];

            foreach ($data->error as $field => $error) {
                // Valor transformado a partir del original por medio de la key
                $transformedField = $transformer::transformedAttribute($field);
                // Campo original, valor a reemplazar, donde lo vamos a reemplazar
                $transformedErrors[$transformedField] = str_replace($field, $transformedField, $error);
            }

            $data->error = $transformedErrors;

            $response->setData($data);
        }

        return $response;
    }
}
