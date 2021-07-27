<?php

namespace App\Http\Controllers\Auth;

use App\Models\Authentication\User;
use App\Models\Authentication\Role;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;

// rules
use App\Http\Rules\TrelloCheckUser;

// libraries
use anlutro\cURL\cURL;
use App\Models\Master\Client;
use Carbon\Carbon;

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

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
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
        $this->middleware('guest');
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
            'email'           => 'required|email',
            'username'        => 'required|string|max:255',
            'perusahaan'      => 'required|string|max:255',
            'password'        => 'required|string|min:6|confirmed',
            // 'username_trello' => ['required', new TrelloCheckUser],
            // 'nama'            => 'required',
        ], [
            'username.required' => 'Username tidak boleh kosong',
            'email.required' => 'Email tidak boleh kosong',
            'perusahaan.required' => 'Perusahaan tidak boleh kosong',
            'email.email' => 'Format Email tidak sesuai',
            'password.required' => 'Password tidak boleh kosong',
            'password.confirmed' => 'Password tidak sama',
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\User
     */

    public function showRegistrationForm()
    {
        return view('modules.authentication.register');
    }

    protected function create(array $data)
    {
        $klien = Client::create([
            'code' => 'GUEST',
            'name' => $data['perusahaan'],
        ]);

        $user =  User::create([
            'client_id'  => $klien->id,
            'username'   => $data['username'],
            'name'       => ucfirst($data['username']),
            'last_login' => date('Y-m-d H:i:s'),
            'password'   => bcrypt($data['password']),
            'email'      => $data['email'],
        ]);
        
        $user->roles()->attach(Role::where('name', 'admin')->first());
        
        return $user;
    }
}
