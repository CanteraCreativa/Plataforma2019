<?php

namespace App\Http\Controllers\Auth;

use App\Events\RolesUpdated;
use App\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Str;
use Laravel\Socialite\Facades\Socialite;

class SocialAuthController extends Controller
{
    // Metodo encargado de la redireccion a Facebook
    public function redirectToProvider($provider)
    {
        if($provider == 'google')
            return Socialite::driver($provider)
                ->setScopes(['openid', 'email'])
                ->stateless()
                ->redirect();

        return Socialite::driver($provider)
            ->stateless()
            ->redirect();
    }

    // Metodo encargado de obtener la información del usuario
    public function handleProviderCallback($provider)
    {

        // Obtenemos los datos del usuario
        request()->session()->put('state',Str::random(40));
        $social_user = Socialite::driver($provider)->stateless()->user();

        // Comprobamos si el usuario ya existe
        if ($user = User::where('email', $social_user->email)->first()) {
            return $this->authAndRedirect($user); // Login y redirección
        } else {
            // En caso de que no exista creamos un nuevo usuario con sus datos.
            $user = User::create([
                'name' => $social_user->email,
                'email' => $social_user->email,
                'password' => bcrypt(md5(date('YmdHis'))),
                'email_verified_at' => date('YmdHis')
            ]);

            $user->assignRole('creative');

            event(new RolesUpdated($user));
            event(new Registered($user));

            $user->account->creativeData->profile_image = $social_user->avatar;

            $user->account->creativeData->save();

            $user->fresh();

            return $this->authAndRedirect($user); // Login y redirección
        }
    }
    // Login y redirección
    public function authAndRedirect($user)
    {
        $token = $user->createToken(NULL)->accessToken;
        $user->token = $token;
        //return response()->json($user);
        //Auth::login($user);

        Cookie::queue('cantera_creativa_session', $token, 1440, null, null, false, false);
        Cookie::queue('rememberMe', 'true', 1440, null, null, false, false);

        return redirect()->to('/profile/'.$user->account->creativeData->id.'/'.$token);
    }
}
