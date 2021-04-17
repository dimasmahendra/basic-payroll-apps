<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

use App\Models\User;

class AuthController extends Controller
{
    public function loginForm() {
        return view('auth/login');
    }

    public function loginProcess(Request $req) {
        $validator = Validator::make($req->all(), [
            'email' => 'required|email',
            'password' => 'required|string',
        ]);
        if($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }
        $login = $validator->validated();

        $user = User::where('email', $login['email'])->first();
        if ($user == null) {
            return back()->withErrors(['all' => 'Invalid email or password'])->withInput();
        }

        $isPasswordValid = Hash::check($login['password'], $user->password);
        if (!$isPasswordValid) {
            return back()->withErrors(['all' => 'Invalid email or password'])->withInput();
        }

        $remember = array_key_exists('remember', $login);
        Auth::login($user, $remember);
        return redirect(route('dashboard'));
    }

    public function registerForm() {
        return view('auth/register');
    }

    public function logoutProcess(Request $req) {
        Auth::logout();
        $req->session()->invalidate();
        $req->session()->regenerateToken();
        return redirect(route('login'));
    }
}
