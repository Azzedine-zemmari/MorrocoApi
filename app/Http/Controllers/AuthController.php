<?php

namespace App\Http\Controllers;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function store(Request $request){
        $request->validate(
            [
                'name' => 'required',
                'email' => 'required|email|unique:users,email',
                'password'  => 'required',
            ]
            );

        $createUser = User::create([
            'name'  =>  $request->name,
            'email'  =>  $request->email,
            'password'  => Hash::make($request->password),
        ]);
        $token = $createUser->createToken('apptoken')->plainTextToken;

        if($createUser){
            return response()->json([
                "message" => "the user has been created",
                "token" => $token
            ] , 201);
        }else {
            return response()->json([
                "message" => "there must be an error"
            ] , 500);
        }
    }
}
