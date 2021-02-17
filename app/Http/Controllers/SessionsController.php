<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;

class SessionsController extends Controller
{
    public function create()
    {
        return view('sessions.create');
    }

    public function store(Request $request)
    {
        $credentials = $this->validate($request, [
            'email' => 'required|email|max:255',
            'password' => 'required|min:6'
        ]);

        if (Auth::attempt($credentials)) {
            session()->flash('success', '欢迎回来');
            return redirect()->route('users.show', [Auth::user()]);
        } else {
            session()->flash('warning', '邮箱或是密码不匹配');
            return redirect()->back()->withInput();
        }
        return;
    }

    public function destroy()
    {
        Auth::logout();
        session()->flash('success', '退出成功');
        return redirect('login');
    }
}
