<?php

namespace App\Http\Controllers;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;


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

    public function login(Request $request){
        $validate = $request->validate([
            'email' => 'required|string|email|max:255',
            'password' => 'required|string|min:8',
        ]);

        $user = User::where('email', $validate['email'])->first();

        if(!$user || !Hash::check($validate['password'], $user->password)){
            return response([
                'message' => 'incorrect data!'
            ], 401);
        }

        $token = $user->createToken('myapptoken')->plainTextToken;

        $response = [
            'user' => $user,
            'token' => $token
        ];

        return response($response, 201);
    }
    public function logout(Request $request){
        Auth::user()->tokens()->delete();

        return [
            'message' => 'logged out!',
        ];
    }
}
