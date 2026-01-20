<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\QueryException;

class UserController extends Controller
{
    public function store(Request $request)
    {
        try {
            User::create([
                'username' => $request->username,
                'email'    => $request->email,
                'password' => bcrypt($request->password),
                'role'     => $request->role,
            ]);

            return redirect()->back()->with('success', 'User created successfully.');

        } catch (QueryException $e) {
            // Check for duplicate entry error (MySQL code 1062)
            if ($e->getCode() == 23000) { // 23000 is the SQLSTATE for integrity constraint violation
                return redirect()->back()->with('error', 'User already exists.');
            }

            return redirect()->back()->with('error', 'Failed to create user.');
        }
    }
}
