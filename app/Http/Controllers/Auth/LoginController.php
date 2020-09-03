<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

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
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function index() {
        return view("auth.login");
    }

    public function authenticate(Request $request) {
        $data = $request->only(["email", "password"]);
        $remember = $request->input("remember", false);

        $validator = $this->validator($data);

        if($validator->fails()) {
            return redirect()->route("login")
                    ->withErrors($validator)
                    ->withInput();
        } 

        if(Auth::attempt($data, $remember)) {
            return redirect()->route("login");
        } else {
            $validator->errors()->add("password", "Email e/ou senha inválido(s)!");
            
            return redirect()->route("login")
                ->withErrors($validator)
                ->withInput();
        }

    }

    public function validator($data) {
        return Validator::make($data, [
            "email" => ["required", "string", "max:255"],
            "password" => ["required", "string", "min:4"]
        ]);
    }

    public function logout() {
        Auth::logout();
        return redirect()->route("login");
    }
}
