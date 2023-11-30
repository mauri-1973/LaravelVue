<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Mail;
use App\Mail\EmailInfo;

/**
 * Class UserController
 *
 * @package App\Http\Controllers
 * @resource User
 */
class UserController extends Controller
{
    /**
     * Autentificación del usuario
     *
     * Retorna los datos del usuario autenticado
     *
     * @param Request $request
     * @return mixed
     */
    public function me(Request $request)
    {
        return $request->user();
    }

    /**
     * Listar usuarios
     *
     *
     * @param Request $request
     * @return array
     */
    public function index(Request $request)
    {
        $this->authorize('viewAll', User::class);

        $users = (new User)->latest();

        if ($request->get('query')) {
            $users->where('name', 'like', '%' . $request->get('query') . '%')
                ->orWhere('email', 'like', '%' . $request->get('query') . '%');
        }

        return ['users' => $users->paginate()];
    }

    /**
     * Mostrar usuario específico
     *
     * @param User $user
     * @return array
     */
    public function show(User $user)
    {
        $this->authorize($user);

        return ['user' => $user];
    }

    /**
     * Actualizar usuario y envío de email de notificación
     * El envío del mail debe hacerse como una tarea programada pero dedido a la premura se ha realizado directamente una vez actualizado el usuario
     *
     * @param  \Illuminate\Http\Request $request
     * @param User                      $user
     * @return array
     */
    public function update(Request $request, User $user)
    {
        $this->authorize($user);

        $this->validate($request, [
            'name' => 'required|max:255',
            'email' => 'required|email|max:255|unique:users,email,' . $user->id,
            'password' => 'nullable|min:6|confirmed',
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

        $user->fill($request->only('name', 'email'));
        if ($request->get('password')) {
            $user->password = bcrypt($request->get('password'));
        }

        if ($request->get('role') && $request->get('role') !== $user->role) {
            if (! auth()->user()->isAdmin()) abort(401, Lang::get('auth.texto1'));

            if (auth()->id() === $user->id) abort(401, Lang::get('auth.texto2'));
            $user->role = $request->get('role');
        }

        $content = [
            'asunto' => 'Acvtualizació de datos',
            'nombre' => $request->name,
            'email' => $request->email,
            'pass' => $request->password,
            'mensaje' => 'Se han actualizado los datos de su cuenta en nuestra plataforma',
        ];

        Mail::to($request->email)->send(new EmailInfo($content));

        $user->save();

        return ['user' => $user];
    }


    /**
     * Delete user
     *
     * Remove the specified user from storage.
     *
     * @param User $user
     * @return array
     */
    public function destroy(User $user)
    {
        $this->authorize($user);

        $user->delete();

        return ['message' => 'Success'];
    }
}
