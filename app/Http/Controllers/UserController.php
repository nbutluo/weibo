<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function create()
    {
        return view('users.create');
    }

    public function show(User $user)
    {
        return view('users.show', compact('user'));
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|unique:users,name|max:25',
            'email' => 'required|email|unique:users,email|max:50',
            'password' => 'required|confirmed|max:50',
        ]);

        return;
    }
}
