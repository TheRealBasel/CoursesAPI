<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class LogoutController extends Controller
{
    public function logout (Request $request){

        $request->user()->currentAccessToken()->delete();
        return response()->json([
            'success' => true,
            'message' => 'You have been successfully logged out.'
        ], 200 );
    
    }
}
