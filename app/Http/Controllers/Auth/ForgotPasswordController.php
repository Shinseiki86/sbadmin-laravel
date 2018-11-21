<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\SendsPasswordResetEmails;

class ForgotPasswordController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset emails and
    | includes a trait which assists in sending these notifications from
    | your application to your users. Feel free to explore this trait.
    |
    */

    use SendsPasswordResetEmails;

    protected $redirectPath = '/';
    protected $subject = 'Cambio de contraseña';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }



    
    /**
     * Display the password reset view for the given token.
     *
     * @param  string $token
     *
     * @return Response
    public function showLinkRequestForm( $token = null )
    {
        //Si no está autenticado y no llegó un token, redirige a recuperar por email.
        if (auth()->guest() && is_null( $token )) {
            //return redirect('password/reset');
            return view( 'auth.passwords.email' );
        }

        $email = Input::get('email');
        //Si está autenticado y no llegó un token...
        if ( auth()->check() && is_null($token) ){
            //Si el rol es admin y el id recibido por GET no es null...
            if( \Entrust::hasRole('admin') && Input::get('id') !== null)
                $user = \App\Models\User::findOrFail(Input::get('id'));
            else
                $user = auth()->user();

            $email = $user->email;
            $token = \Password::getRepository()->create( $user );
        }

        return view( 'auth.passwords.reset' )
                ->with( 'email', $email )
                ->with( 'token', $token );

    }
     */
}
