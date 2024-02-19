<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;


class AuthController extends Controller
{
    public function register(Request $request){
        $request->validate([
            'name' => ['required'],
            'email' => ['required', 'email' , 'unique:users'],
            'password' => ['required' , 'min:8']
        ]);

        $user = User::create([
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'password' => Hash::make($request->input('password')),
        ]);

        Auth::login($user);

        return response()->json(['message' => 'Successfully registered and logged in']);
    }

    public function login(Request $request){
        $request->validate([
            'email'=> ['required'],
            'password'=>['required']
        ]);

        if(Auth::attempt($request->only('email', 'password'))){
            $request->session()->regenerate();
            return response()->json(Auth::user(), 200);
        }
        throw ValidationException::withMessages([
            'email'=>['The provided credentials are incorrect.']
        ]);
    }

    public function logout(Request $request){
        Auth::logout();
        $request->session()->invalidate();
    }
}
