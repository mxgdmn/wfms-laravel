<?php

namespace App\Http\Controllers;


use App\Http\Requests\StoreLogin;
use App\Http\Requests\StoreUser;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function create()
    {
        return view('user.create');
    }

    public function store(StoreUser $request)
    {
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
        ]);
        session()->flash('success', 'Регистрация успешна');
        Auth::login($user);
        return redirect()->home();
    }

    public function loginForm()
    {
        return view('user.login');
    }

    public function login(StoreLogin $request)
    {
        if(Auth::attempt([
            'email' => $request->email,
            'password' => $request->password,
        ])) {
            session()->flash('success', 'Вы авторизованы!');
            if(Auth::user()->is_admin) {
                return redirect()->route('admin.index');
            }
            else {
                return redirect()->route('home');
            }
        }

        return redirect()->route('login')->with('error', 'Неправильный логин или пароль');
    }

    public function logout()
    {
        Auth::logout();
        return redirect()->route('login.form');
    }
}
