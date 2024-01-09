<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;

use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;

use \App\Events\RolesUpdated;
use Illuminate\Support\Facades\Auth;


class ApiAuthController extends Controller
{

    public function register(Request $request)
    {
        $validated_data = $request->validate([
            'name' => 'required|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6|confirmed',
        ]);

        $user = \App\User::create([
            'name' => $validated_data['name'],
            'email' => $validated_data['email'],
            'password' => bcrypt($validated_data['password']),
        ]);

        $user->assignRole('creative');

        event(new RolesUpdated($user));
        event(new Registered($user));

        $user->fresh();

        $token = $user->createToken(NULL)->accessToken;
        $user->token = $token;
        return response()->json($user);

    }

    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            // Authentication passed...
            $user = Auth::user();

            if(!$user->active)
                return response(['message' => "El usuario está suspendido. Por favor, escribí a contacto@canteracreativa.com para solucionarlo. Disculpá las molestias."], 401)->header('Content-Type', 'text/json');

            $token = $user->createToken(NULL)->accessToken;
            $user->token = $token;
            return response()->json($user);
        }
        return response(['message' => 'Correo electrónico o contraseña incorrectos'], 401)->header('Content-Type', 'text/json');
    }

}
