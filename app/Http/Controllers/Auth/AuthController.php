<?php

namespace App\Http\Controllers\Auth;

use App\User;
use Validator;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\ThrottlesLogins;
use Illuminate\Foundation\Auth\AuthenticatesAndRegistersUsers;

class AuthController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Registration & Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users, as well as the
    | authentication of existing users. By default, this controller uses
    | a simple trait to add these behaviors. Why don't you explore it?
    |
    */

    use AuthenticatesAndRegistersUsers;//, ThrottlesLogins;

    /**
     * Where to redirect users after login / registration.
     *
     * @var string
     */
    protected $redirectTo = '/';
    protected $redirectAfterLogout = "/login";

    /**
     * Create a new authentication controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware($this->guestMiddleware(), ['except' => 'logout']);
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => 'required|max:255',
            'password' => 'required|min:6|confirmed',
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return User
     */
    protected function create(array $data)
    {
        return User::create([
            'name' => $data['name'],
            'password' => bcrypt($data['password']),
        ]);
    }

    public function logout()
    {
        if(Auth::guard($this->getGuard())->logout()){

        }

        return redirect(property_exists($this, 'redirectAfterLogout') ? $this->redirectAfterLogout : '/');
    }
    public function loginUsername()
    {
        return property_exists($this, 'name') ? $this->name : 'email';
    }
    protected function getCredentials(Request $request)
    {
        return $request->only('name', 'password');
    }
    protected function sendFailedLoginResponse(Request $request)
    {
        return redirect()->back()
            ->withInput($request->only('name', 'remember'))
            ->withErrors([
                'name'=> $this->getFailedLoginMessage(),
            ]);
    }
    protected function validateLogin(Request $request)
    {
        $this->validate($request, [
            'name' => 'required', 'password' => 'required',
        ]);
    }
}
