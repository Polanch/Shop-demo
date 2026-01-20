<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
  public function login(Request $request)
    {
        $credentials = $request->only('login', 'password');

        $fieldType = filter_var($credentials['login'], FILTER_VALIDATE_EMAIL) ? 'email' : 'username';

        if (Auth::attempt([$fieldType => $credentials['login'], 'password' => $credentials['password']])) {
            $user = Auth::user();

            switch ($user->role) {
                case 'Admin':
                    return redirect('/admin/dashboard');
                case 'Consumer':
                    return redirect('/consumer/dashboard');
                default:
                    Auth::logout();
                    return redirect('/')->with('error', 'Unauthorized role.');
            }
        }

        // Failed login -> redirect back to home page
        return redirect('/')->with('error', 'Invalid username/email or password.');
    }

}
