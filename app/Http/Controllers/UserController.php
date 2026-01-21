<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\QueryException;

class UserController extends Controller
{
    public function index()
    {
        $users = User::orderBy('created_at', 'desc')->get();
        return view('admin_users', compact('users'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'username' => 'required|string|max:255|unique:users,username',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:5|confirmed',
            'role' => 'required|in:Admin,Consumer',
        ]);

        try {
            User::create([
                'username' => $request->username,
                'email'    => $request->email,
                'password' => bcrypt($request->password),
                'role'     => $request->role,
                'status'   => 'active',
            ]);

            return redirect()->back()->with('success', 'Account created successfully!');

        } catch (QueryException $e) {
            if ($e->getCode() == 23000) {
                return redirect()->back()->with('error', 'Username or email already exists.');
            }

            return redirect()->back()->with('error', 'Failed to create account.');
        }
    }

    public function toggleStatus(Request $request, $id)
    {
        $user = User::findOrFail($id);
        $user->status = $user->status === 'active' ? 'blocked' : 'active';
        $user->save();

        return redirect()->back()->with('success', 'User status updated successfully!');
    }

    public function destroy($id)
    {
        $user = User::findOrFail($id);
        
        // Prevent deleting yourself
        if ($user->id === Auth::id()) {
            return redirect()->back()->with('error', 'You cannot delete your own account!');
        }

        $user->delete();
        return redirect()->back()->with('success', 'User deleted successfully!');
    }
}
