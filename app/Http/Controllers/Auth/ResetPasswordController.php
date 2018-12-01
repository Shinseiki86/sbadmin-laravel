<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\ResetsPasswords;

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
    protected $redirectTo = '/';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        dump(\Entrust::hasRole('admin'));
        //dump(\Entrust::user()->roles->first()->permissions);
        dd(\Entrust::can('user-edit'));
        //$this->middleware('guest');
    }



    /**
     * Get the response for a successful password reset.
     *
     * @param  string  $response
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\JsonResponse
     */
    protected function sendResetResponse($response)
    {
        dd(\Entrust::can('user-edit'));
        flash_alert( '¡Contraseña modificada para '.$user->username.'!', 'success' );
        if( auth()->check() && \Entrust::hasRole('admin') )
            return redirect('auth/usuarios')->with('status', trans($response));
        else
            return redirect($this->redirectPath())->with('status', trans($response));
    }

}
