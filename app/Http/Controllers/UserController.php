<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    //show register form
    public function create()
    {
        return view('users.register');
    }
    //create new user
    public function store(Request $request){
        $formField = $request->validate([
            'name' => ['required', 'min:3'],
            'email' => ['required', 'email', Rule::unique('users', 'email')],
            'password' => 'required|min:6|confirmed',
        ]);

        //Hash password
        $formField['password'] = bcrypt($formField['password']);
        //create user
        $user = User::create($formField);
        //Login
        auth()->login($user);
        //Redirect
        return redirect('/')->with('message', 'User created and log in.');
    }

    public function logout(Request $request){
        auth()->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/')->with('message', 'User logged out.');
    }

    //Show login form
    public function login() {
        return view('users.login');
    }

    //Authenticate user

    public function authenticate(Request $request) {
        $formField = $request->validate([
            'email' => ['required', 'email'],
            'password' => 'required|min:6',
        ]);

        if (auth()->attempt($formField)) {
            $request->session()->regenerate();
            return redirect('/')->with('message', 'User logged in.');
        }

        return back()->withErrors([
            'email' => 'Invalid credentials',
        ])->onlyInput('email');
    }

}
