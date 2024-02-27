<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use RealRashid\SweetAlert\Facades\Alert;

class LoginController extends Controller
{
    use AuthenticatesUsers;

    protected $redirectTo = RouteServiceProvider::HOME;

    public function username()
    {
        return 'nim';
    }

    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function showLoginForm()
    {
        return view('auth.login');
    }
    public function showLoginFormAdmin()
    {
        return view('auth.admin_login');
    }

    protected function validateLogin(Request $request)
    {
        $request->validate([
            $this->username() => 'required|string',
            'password' => 'required|string',
        ]);
    }

    protected function authenticated(Request $request, $user)
    {
        if ($user->role == 'admin') {
            Alert::success('Login Success', 'Selamat datang admin!');
            return redirect()->route('admin.home');
        } else {
            // if ($request->user()->hasVerifiedEmail()) {
            //     Alert::success('Success', 'Berhasil Login !');
            //     return redirect()->route('home');
            // } else {
            //     $request->user()->sendEmailVerificationNotification();
            //     return redirect()->route('verification.notice');
            // }
            Alert::success('Login Success', 'Selamat datang ' . $user->name . '!');
            return redirect()->route('home');
        }
    }

    protected function sendFailedLoginResponse(Request $request)
    {
        Alert::error('Gagal!', 'NIM atau Password salah!');
        throw ValidationException::withMessages([
            $this->username() => [trans('auth.failed')],
        ]);
    }

    protected function loggedOut(Request $request)
    {
        Alert::success('Success', 'Berhasil Logout!');
        return redirect()->route('login');
    }
}
