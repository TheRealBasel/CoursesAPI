<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class LoginController extends Controller
{
    public function login (Request $request){

        $validated_request = $request->validate([
            'email' => ['required', 'exists:users'],
            'password' => ['required'],
        ]);
        if(Auth::attempt($validated_request)){ 
            
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
}
