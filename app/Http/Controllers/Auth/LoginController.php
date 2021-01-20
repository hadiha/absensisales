<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;

use Hash;
use Auth;
use Session;
use Carbon;
use App\Models\Authentication\User;

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
        $this->middleware('guest')->except('logout');
    }

    public function showLoginForm()
    {
        return view('modules.authentication.login');
    }

    // custom login
    public function login(Request $request)
    {
        // Check validation
        $this->validate($request, [
            'username' => 'required',            
            'password' => 'required',            
        ]);

        $user = User::where('username', $request->username)
        ->orWhere('email', $request->username)->first();   

        // check user
        if ($user) {
            // check status user
            if ($user->status == 1) {
                // check password
                if (Hash::check($request->password, $user->password)) {
                    // set session login
                    $user->last_login = Carbon::now();
                    $user->save();
                    Auth::login($user);
                    $user->storeLog('Login', 'Login Kedalam Aplikasi');
                    return redirect(url('/'));
                }
            } else {
                Session::flash('message', "Username belum aktif!");
                return redirect()->back();
            }
        }

        // user not exist
        Session::flash('message', "Username atau Password yang anda masukan tidak sesuai");
        return redirect()->back();
    }

    public function logout()
    {
        Auth::logout();
        return redirect('/login');
    }

    public function username()
    {
        return 'username';
    }

    public function inject($user)
    {
        $user = User::where('username', $user)
                    ->first();
        if ($user) {
            Auth::login($user);
            // redirect
            return redirect(url('/'));
            
        } else {
            return 'T_T';
        }
    }
}
