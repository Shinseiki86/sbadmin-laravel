<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;
use Illuminate\Foundation\Auth\SendsPasswordResetEmails;

use App\Models\User;

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
        /* Se inactiva middleware ya que los cambios de contraseña puede realizarlos el rol admin.
        $this->middleware('guest');
        */
    }

    /**
     * Display the form to request a password reset link.
     *
     * @return \Illuminate\Http\Response
     */
    public function showLinkRequestForm()
    {
        //Si no está autenticado y no llegó un token, redirige a recuperar por email.
        if (auth()->guest() ){
            //return redirect('password/reset');
            return view( 'auth.passwords.email' );
        } elseif( \Entrust::hasRole('admin') ){ //Si está autenticado con rol admin...

            $user = Input::has('id') ? User::findOrFail(Input::get('id')) : auth()->user();
            $email = $user->email;
            $token = \Password::getRepository()->create( $user );

            return view( 'auth.passwords.reset' )
                    ->with( 'email', $email )
                    ->with( 'token', $token );
        }


    }


    public function sendEmail($id){
        $user = User::findOrFail($id);
        $this->sendResetLinkEmail($user);
    }



    /**
     * Reset the given user's password.
     *
     * @param  \Illuminate\Contracts\Auth\CanResetPassword  $user
     * @param  string  $password
     * @return void
     */
    protected function resetPassword($user, $password)
    {
        $user->forceFill([
            'password' => bcrypt($password),
            'remember_token' => Str::random(60),
        ])->save();

        flash_alert( '¡Contraseña modificada para '.$user->username.'!', 'success' );
    }


    /**
     * Get the response for after a successful password reset.
     *
     * @param  string  $response
     * @return \Symfony\Component\HttpFoundation\Response
     */
    protected function getResetSuccessResponse($response)
    {
        dd($response);
        if( auth()->check() && \Entrust::hasRole('admin') )
            return redirect('auth/usuarios')->with('status', trans($response));
        else
            return redirect($this->redirectPath())->with('status', trans($response));

    }

}
