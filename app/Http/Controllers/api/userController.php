<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;

class userController extends Controller
{
    public function register(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'name' => 'required',
                'email' => 'email|required',
                'password' => 'required|confirmed',
            ]

        );
        if ($validator->fails()) {

            return response()->json([
                'message' => "Request Error",
                'user' => $validator->errors() //untuk menampilka pesan error di parameter tertentu
            ], 422);
        }
        $user = User::create([
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'password' => Hash::make($request->input('password'))
        ]);
        $user->update([
            'email_verified_at' => now()
        ]);
        return response()->json([
            'messages' => "User Created",
            'user' => $user
        ], 200);
    }
    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'email|required',
            'password' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Request Body Error',
                'errors' => $validator->errors()
            ], 402);
        }

        if (!Auth::attempt($request->only('email', 'password'))) {
            return response()->json([
                'message' => 'Unauthorized'
            ], 401);
        }

        $user = User::where('email', $request->email)->firstOrFail();
        $token = $user->createToken('auth_token')->plainTextToken; //pembuatan auth token

        return response()->json([
            'message' => 'User Created',
            'token' => $token
        ]);
    }
    public function user(Request $request)
    {


        return $request->user(); //get data berdasarkan auth token yang saudah dibuat

    }
    public function logout()
    {
        if (!Auth::user()->tokens()->delete()) {
            return response()->json([
                'message' => 'Unauthorized'
            ], 401);
        }
        return response()->json([
            'message' => 'Logged out'
        ]);
    }
}
