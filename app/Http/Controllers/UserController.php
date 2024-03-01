<?php

namespace App\Http\Controllers;

use App\Models\User;

class UserController extends Controller
{
    public function getALlUsers(){
        $users = User::all();
        if ($users->isEmpty())
            return response()->json(['message'=>'No users'],404);
        else
            return response()->json($users);
    }

    public function getUserById(string $userID){
        $user = User::find($userID);
        if ($user)
            return response()->json($user);
        else
            return response()->json(['message'=>'User not found'],404);
    }
}
