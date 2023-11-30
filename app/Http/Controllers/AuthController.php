<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Lang;
use Illuminate\Support\Facades\Validator;
use Mail;
use App\Mail\EmailInfo;

/**
 * Class AuthController
 *
 * @package App\Http\Controllers
 */
class AuthController extends Controller
{
    use AuthenticatesUsers;

    /**
     * Login
     *
     * Handle a login request to the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Contracts\Auth\Authenticatable|array
     */
    public function login(Request $request)
    {
        $this->validateLogin($request);

        // Si la clase usa el trait ThrottlesLogins, podemos acelerar automáticamente
        // los intentos de inicio de sesión para esta aplicación. Introduciremos esto por el nombre de usuario y
        // la dirección IP del cliente que realiza estas solicitudes en esta aplicación.
        if ($this->hasTooManyLoginAttempts($request)) {
            $this->fireLockoutEvent($request);
            $seconds = $this->limiter()->availableIn($this->throttleKey($request));

            abort(429, Lang::get('auth.throttle', ['seconds' => $seconds]));
        }

        if ($this->attemptLogin($request)) {
            $this->clearLoginAttempts($request);

            /** @var User $user */
            $user = $this->guard()->user();

            return ['user' => $user, 'access_token' => $user->makeApiToken()];
        }


        // Si el intento de inicio de sesión no tuvo éxito, incrementaremos el número de intentos
        // para iniciar sesión y redirigir al usuario al formulario de inicio de sesión. Por supuesto, cuando esto
        // el usuario supera su número máximo de intentos y quedará bloqueado.
        $this->incrementLoginAttempts($request);

        abort(401, Lang::get('auth.failed'));
    }

    /**
     * Registro
     *
     * Handle al registro request para el formulario y envío de email
     * El envío del mail debe hacerse como una tarea programada pero dedido a la premura se ha realizado directamente una vez hecho el registro
     *
     * @param  \Illuminate\Http\Request $request
     * @return array
     */
    public function register(Request $request)
    {
       
        $this->validator($request->all())->validate();

        event(new Registered($user = $this->create($request->all())));
        
        $content = [
            'asunto' => 'Registro exitoso',
            'nombre' => $request->name,
            'email' => $request->email,
            'pass' => $request->password,
            'mensaje' => 'Se ha creado una cuenta en nuestra plataforma',
        ];

        Mail::to('mauri-1973@outlook.cl')->send(new EmailInfo($content));

        return ['user' => $user, 'access_token' => $user->makeApiToken()];
    }

    /**
     * Validar datos ingresados en el formulario.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name'     => 'required|max:255',
            'email'    => 'required|email|max:255|unique:users',
            'password' => 'required|min:6|confirmed',
        ], [
            'name.required' => Lang::get('auth.texto3'),
            'name.max' => Lang::get('auth.texto4'),
            'email.required' => Lang::get('auth.texto5'),
            'email.email' => Lang::get('auth.texto6'),
            'email.max' => Lang::get('auth.texto7'),
            'email.unique' => Lang::get('auth.texto8'),
            'password.confirmed' => Lang::get('auth.texto9'),
            'password.nullable' => Lang::get('auth.texto10'),
            'password.min' => Lang::get('auth.texto11'),
        ]);
    }

    /**
     * Creación del nuevo usuario.
     *
     * @param  array  $data
     * @return User
     */
    protected function create(array $data)
    {
        return User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => bcrypt($data['password']),
        ]);
    }
}
