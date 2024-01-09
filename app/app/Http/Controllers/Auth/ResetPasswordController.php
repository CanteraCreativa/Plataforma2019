<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Foundation\Auth\ResetsPasswords;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;

class ResetPasswordController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset requests
    | and uses a simple trait to include this behavior. You're free to
    | explore this trait and override any methods you wish to tweak.
    |
    */

    use ResetsPasswords;

    /**
     * Where to redirect users after resetting their password.
     *
     * @var string
     */
    protected $redirectTo = '/admin/dashboard';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //$this->middleware('guest');
    }

    public function reset(Request $request)
    {
        $request->validate($this->rules(), $this->validationErrorMessages());

        $this->resetPassword($request->input('email'), $request->input('password'));

        return redirect('/admin/reset-password')->with('status', 'Contraseña modificada exitosamente');
    }

    protected function rules()
    {
        return [
            'email' => 'required|email',
            'password' => 'required|confirmed|min:8',
        ];
    }

    protected function resetPassword($email, $password)
    {
        $user = User::where('email', $email)->first();

        $user->password = Hash::make($password);

        $user->setRememberToken(Str::random(60));

        $user->save();
    }
}
