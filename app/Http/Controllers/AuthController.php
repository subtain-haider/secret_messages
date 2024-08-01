<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\loginRequest;
use App\Http\Requests\RegisterRequest;
use App\Http\Requests\ForgetPasswordRequest;
use Auth;
use App\Models\User;
use Session;
use App\Services\UserService;


class AuthController extends Controller
{
    protected $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }


    public function login()
    {
        if(Auth::check()){
            return redirect()->route('dashboard');
        }
        return view('auth.login');
    }

    public function register()
    {
        if(Auth::check()){
            return redirect()->route('dashboard');
        }
        return view('auth.register');
    }

    public function postLogin(loginRequest $request)
    {
        try {
            if(Auth::attempt($request->validated()))
            {
                return redirect()->route('dashboard');
            }

            Session::flash('error_message', 'Invalid email/password');
            return back();
        } catch (\Throwable $th) {
            \Log::error('Login Error', ['error' => $th->getMessage()]);
            Session::flash('error_message', $th->getMessage());
            return back();
        }
    }

    public function postRegister(RegisterRequest $request)
    {
        try {
            $this->userService->store($request->validated());
            return redirect()->route('dashboard');
        } catch (\Throwable $th) {
            \Log::error('Register Error', ['error' => $th->getMessage()]);
            Session::flash('error_message', $th->getMessage());
            return back();
        }

    }

    public function logout(Request $request)
    {
        if(Auth::check()){
            Auth::logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();
            return redirect()->route('login');
        }

        return redirect()->route('dashboard');
    }

    public function dashboard()
    {
        return view('dashboard');
    }
}
