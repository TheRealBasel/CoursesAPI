<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function register (Request $request){

        $request->validate([
            'email' => ['required','email:rfc,dns','unique:users,email'],
            'password' => ['required', 'string', 'min:6'],
            'first_name' => ['required', 'alpha', 'min:3', 'max:12'],
            'last_name' => ['required', 'alpha', 'min:3', 'max:12']
        ]);

        $user = User::create([
            'email' => $request->email, 
            'password' => Hash::make($request->password),
            'first_name' => $request->first_name,
            'last_name' => $request->last_name
        ]);
    
        return response()->json( [
            'success' => true,
            'data' => [
                'token' => $user->createToken('courses_api')->plainTextToken,
                'roles' => $user->getRoleNames()
            ],
            'message' => 'You have registerd successfully.'
        ], 201 );
    
    }

    public function login (Request $request){

        $request->validate([
            'email' => ['required', 'exists:users'],
            'password' => ['required'],
        ]);
        if(Auth::attempt($request)){ 
            $user = Auth::user(); 
            return response()->json( [
                'success' => true,
                'message' => 'Successfully Logged in',
                'data' => [
                    'token' => $user->createToken('courses_api')->plainTextToken,
                    'roles' => $user->getRoleNames()
                ]
            ], 200 );
        }

        return response()->json( [
            'success' => false,
            'message' => 'credeaintls dont match our records'
        ], 401 );
    }

    public function logout (Request $request){

        $request->user()->currentAccessToken()->delete();
        return response()->json([
            'success' => true,
            'message' => 'You have been successfully logged out.'
        ], 200 );
    }

}
