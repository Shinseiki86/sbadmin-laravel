<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\App\MenuController;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
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
        //Lista de acciones que no requieren autenticación
        $arrActionsLogin = [
            'logout',
            'login',
            'getLogout',
            'showLoginForm',
        ];

        //Requiere que el usuario inicie sesión, excepto en la vista logout.
        $this->middleware('auth', [ 'except' => $arrActionsLogin ]);

        $this->middleware('permission:user-index',  ['only' => ['index']]);
        $this->middleware('permission:user-create', ['only' => ['showRegistrationForm','register']]);
        $this->middleware('permission:user-edit',   ['only' => ['edit', 'update']]);
        $this->middleware('permission:user-delete', ['only' => ['destroy']]);
    }

    /**
     * Get the login username to be used by the controller.
     *
     * @return string
     */
    public function username()
    {
        return 'username';
    }


    /**
     * Get the needed authorization credentials from the request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    protected function credentials(Request $request)
    {
        $credentials = $request->only($this->username(), 'password');
        $credentials['username'] = strtolower($credentials['username']);
        return $credentials;
    }


    /**
     * The user has been authenticated.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  mixed  $user
     * @return mixed
     */
    protected function authenticated(Request $request, $user)
    {
        //Se crea arreglo en session con los items del menú disponibles
        MenuController::refreshMenu();
    }
}
