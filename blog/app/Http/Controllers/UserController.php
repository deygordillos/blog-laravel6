<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index() {
        $users = User::latest()->get();

        return view('users.index', [
            'users' => $users
        ]);
    }

    public function store(Request $req) {
        // Validation
        $req->validate([
            'name' => 'required',
            'email' => ['required', 'email', 'unique:users'],
            'password' => ['required', 'min:8']
        ]);

        User::create([
            'name' => $req->name,
            'email' => $req->email,
            'password' => bcrypt($req->password)
        ]);

        return back();
    }

    public function destroy(User $user) {
        $user->delete();

        return back();
    }
}
