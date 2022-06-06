<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class RegisterController extends Controller
{
    public function register (Request $request){

        $validated_request = $request->validate([
            'email' => ['required','email:rfc,dns','unique:users,email'],
            'password' => ['required', 'string', 'min:6'],
            'first_name' => ['required', 'alpha', 'min:3', 'max:12'],
            'last_name' => ['required', 'alpha', 'min:3', 'max:12']
        ]);

        $user = User::create([
            'email' => $validated_request['email'], 
            'password' => Hash::make($validated_request['password']),
            'first_name' => $validated_request['first_name'],
            'last_name' => $validated_request['last_name']
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
}
