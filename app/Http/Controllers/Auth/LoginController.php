<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

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

    use AuthenticatesUsers;//trait itu kayak abstrak class kalau mau override method maka methdo ovverride yang dipanggil. 
                            //kalau mau make method bawaan tinggal make.

    public function login(Request $request)
    {
        $this->validateLogin($request); // ini itu manggil fungsi di trait tersebut.
        
        if ($this->attemptLogin($request)) {
            $user = $this->guard('api')->user();
            $user->generateToken();

            //ini akan mengembalikan API token yang harus digunakan saat request.
            return response()->json([
                'data' => $user->toArray(),
            ]);
            
        }

        return response()->json([
            "error" => "user not registered, check your mail and password"
        ], 400);
    }
    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    // protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        // $this->middleware('guest')->except('logout');
    }
}
