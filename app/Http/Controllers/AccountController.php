<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\AccountRequest;
use Illuminate\Contracts\Support\ValidatedData;

class AccountController extends Controller
{
    //
    public function getAllUser(Request $request){
        $users = User::all();
        // response
        return response()->json([
            "message" => "Akun Ditemukan",
            "users" => $users
        ],200);

    }
    public function getSpecificUser(Request $request, string $id){
        // query nyari data usernya dulu
        $user = User::findOrFail($id);
        // response
        return response()->json([
            "message" => "Akun Ditemukan",
            "user" => $user
        ],200);
        

    }
    public function editSpecificUser(AccountRequest $request,string $id){
        $validatedData = $request->validated();

        // Cari Data yang mau diupdate
        $user = User::findOrFail($id);

        if(!empty($validatedData['password'])){
                $validatedData['password'] = Hash::make($validatedData['password']);
        } 
        else {
            // Jika password tidak diisi, jangan update password-nya
            unset($validatedData['password']);
        }

        // Update data
        $user->update($validatedData);

        return response()->json([
            "message" => "Data Akun Berhasil Diupdate",
            "user" => $user
        ],200);


    }
    public function deleteSpecificUser(Request $request, string $id){
        if ($request->user()->id == $id) {
            return response()->json([
                'message' => 'Admin tidak dapat menghapus akunnya sendiri.'
            ], 403); // 403 Forbidden
        }
        
        $user = User::findOrFail($id);
        $user->delete();
        return response()->json([
            "message" => "User dihapus",
            "product" => $user
        ],200);

    }
}
