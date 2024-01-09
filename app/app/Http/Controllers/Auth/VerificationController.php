<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Foundation\Auth\VerifiesEmails;
use Illuminate\Http\Request;
use Illuminate\Auth\Events\Verified;
use Illuminate\Support\Facades\Auth;

class VerificationController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Email Verification Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling email verification for any
    | user that recently registered with the application. Emails may also
    | be re-sent if the user didn't receive the original email message.
    |
    */

    use VerifiesEmails;

    public function verify(Request $request)
    {
        $user = User::find($request->route('id'));
        if ($request->route('id') == $user->getKey() && $user->markEmailAsVerified()) {
            event(new Verified($user));
        }

        Auth::login($user);
        $token = $user->createToken(NULL)->accessToken;
        $user->token = $token;

        return redirect('/profile/'.$user->id.'/'.$token);

    }

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //$this->middleware('auth:api');
        /* $this->middleware('signed')->only('verify'); */
        //$this->middleware('throttle:6,1')->only('verify', 'resend');
    }
}
