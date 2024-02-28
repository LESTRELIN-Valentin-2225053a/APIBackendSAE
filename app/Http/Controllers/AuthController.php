<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;


class AuthController extends Controller
{
    public function register(Request $request){
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:8'
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => "Les données ne sont pas valides"], 409);
        }
        else {
            $user = User::create([
                'name' => $request->input('name'),
                'email' => $request->input('email'),
                'password' => Hash::make($request->input('password')),
            ]);

            Auth::login($user);

            return response()->json(['user' => $user], 201);
        }
    }

    public function login(Request $request){
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => "Les données ne sont pas valides"], 401);
        }
        else {
            if (Auth::attempt($request->only('email', 'password'))) {
                $request->session()->regenerate();
                return response()->json(Auth::user(), 200);
            }
            else {
                return response()->json(['error' => "Les données ne sont pas valides"], 401);
            }
        }
    }

    public function logout(Request $request){
        Auth::logout();
        $request->session()->invalidate();
    }
}
