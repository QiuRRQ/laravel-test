<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use App\User;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers; // ini adalah traits yang akan dipanggil dari file RegisterUsers.php, kita bisa panggil method dari trait ini

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    // protected $redirectTo = RouteServiceProvider::HOME; // ini gk dipakai karena akan langsung redirect tanpa memanggil mehtod registered dibawah. 
    //jadi api token bakal gk ke isi kalau pakai ini 

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    // public function _register(Request $request){
    //     $this->register($request);
    // }
    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8'],
            'address' => ['required'], 
            'city' => ['required'], 
            'province' => ['required'], 
            'no_telp' => ['required'], 
            'username' => ['required'],
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\User
     */
    protected function create(array $data)
    {
        return User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => bcrypt($data['password']),
            'address' => $data['address'], 
            'city' => $data['city'], 
            'province' => $data['province'], 
            'no_telp' => $data['no_telp'], 
            'username' => $data['username'],
        ]);
    }

    protected function registered(Request $request, $user) // kenapa harus registered method karena method ini akan dicek oleh trair registeruser pakah exist atau tidak. jika exist method ini akan dijalankan.
    {
        $user->generateToken();

        return response()->json(['data' => $user->toArray()], 201);
    }
}
