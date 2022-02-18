<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\ApiController;
use App\Http\Controllers\Controller;
use App\Models\User;
use App\Transformers\UserTransformer;
use Illuminate\Http\Request;

class UserController extends ApiController
{

    public function __construct()
    {
        // Llamar al constructor del padre para no perder alguna tarea del padre en su constructor
        // parent::__construct();
        // Comentamos el constructor del padre ya que no queremos usar el middleware que el Padre esta heredando
        // a los hijos
        $this->middleware('client.credentials')->only(['store','verify','resend']);
        $this->middleware('auth:api')->except(['store','verify','resend']);


        $this->middleware('transform.input:' . UserTransformer::class)->only(['store', 'update']);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $usuarios = User::all();

        // return response()->json(['data' => $usuarios],200);
        return $this->showAll($usuarios);
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
        $reglas = [
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6|confirmed'
        ];

        $this->validate($request, $reglas);

        $campos = $request->all();
        $campos['password'] = bcrypt($request->password);
        $campos['verified'] = User::USUARIO_NO_VERIFICADO;
        $campos['verification_token'] = User::generarVerificationToken();
        $campos['admin'] = User::USUARIO_REGULAR;

        $usuario = User::create($campos);

        // return  response()->json($usuario, 201);
        return $this->showOne($usuario, 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        //
        // $usuario = User::findOrFail($id);

        return $this->showOne($user);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    {
        //

        // Exceptuando el id del usuario actual
        $reglas = [
            'email' => 'email|unique:users,email,' . $user->id,
            'password' => 'min:6|confirmed',
            'admin' => 'in:' . User::USUARIO_ADMINISTRADOR . ',' . User::USUARIO_REGULAR,
        ];

        $this->validate($request, $reglas);

        if ($request->has('name')) {
            $user->name = $request->name;
        }

        if ($request->has('email') && $user->email != $request->email) {
            $user->verified = User::USUARIO_NO_VERIFICADO;
            $user->verification_token = User::generarVerificationToken();
            $user->email = $request->email;
        }

        if ($request->has('password')) {
            $user->password = bcrypt($request->password);
        }

        if ($request->has('admin')) {
            // $this->allowedAdminAction();

            if (!$user->esVerificado()) {
                return $this->errorResponse('Unicamente los usuarios verificados pueden cambiar su valor de administrador', 409);
            }

            $user->admin = $request->admin;
        }

        // Verificar si el usuario cambio respecto al original
        if (!$user->isDirty()) {
            return $this->errorResponse('Se debe especificar al menos un valor diferente para actualizar', 422);
        }

        $user->save();

        return $this->showOne($user);
        // return response()->json(['data' => $user],200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        //
        // $user = User::findOrFail($id);

        $user->delete();

        // return response()->json(['data' => 'Usuario eliminado correctamente'],200);
        return $this->showOne($user);

        // if ($user->esVerificado()) {
        //     return $this->errorResponse('Este usuario ya ha sido verificado.', 409);
        // }

        // retry(5, function() use ($user) {
        //     Mail::to($user)->send(new UserCreated($user));
        // }, 100);

        // return $this->showMessage('El correo de verificación se ha reenviado');
    }
}
