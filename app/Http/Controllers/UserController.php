<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\RegisterRequest;


class UserController extends Controller
{
    //
    public function register(Request $request){
        $isExist = User::where('email', $request->email)->first();
        if($isExist){
            return response()->json('Account Already Exist');
        }
        $request['password'] = Hash::make($request['password']);
        
        // create
        $newUser = User::create($request->all());
        // response
        return response()->json($newUser);
    }

    public function login (Request $request){
        $account = User::where('email', $request->email)->first();
        if(!$account){
            return response()->json('Kesalahan di email atau password');
        } 
        $hashedPassword = $account -> password;
        $passwordCheck = Hash::check($request['password'], $hashedPassword);
        if(!$passwordCheck){
            return response()->json('Kesalahan di email atau password');
        }
        
        $token = $account -> createToken('auth')->plainTextToken;

        return response()->json([
            "message" => "Login Berhasil",
            "token" => $token
        ]);

    }

    public function logout (Request $request){
        $request->user()->currentAccessToken()->delete();
        return response()->json([
            "message" => "Logout Berhasil"
        ]);
    }
}
