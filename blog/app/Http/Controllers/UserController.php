<?php

namespace App\Http\Controllers;

use App\User;
use App\Http\Requests\UserRequest;

class UserController extends Controller
{
    public function index() {
        $users = User::latest()->get();

        return view('users.index', [
            'users' => $users
        ]);
    }

    public function store(UserRequest $req) {
        
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
