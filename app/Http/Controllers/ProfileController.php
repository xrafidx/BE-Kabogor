<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileRequest;
use Illuminate\Http\Request;

class ProfileController extends Controller
{
    //
    public function getMyData(Request $request){
        $user = $request->user();
        return response()->json([
            "Message" => "Data Ditemukan",
            "User" => $user
        ],200);
    }

    public function editMyData(ProfileRequest $request){
        $validatedData = $request->validated();
        $user = $request->user();
        $user ->update($validatedData);
        return response()->json([
            'Message' => "Data Berhasil Diperbarui",
            'User' => $user
        ],200);
    }
}
