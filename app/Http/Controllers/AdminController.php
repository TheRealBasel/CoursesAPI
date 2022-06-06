<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Http\Resources\UserResource;

class AdminController extends Controller
{
    public function add_user_role(Request $request){
        $validated_request = $request->validate([
            'user_id' => [ 'required', 'exists:users,id' ],
            'role_name' => [ 'required', 'exists:roles,name' ],
        ]);
        
        $foundedUser = User::findOrFail($validated_request['user_id']);

        $foundedUser->assignRole($validated_request['role_name']);

        return new UserResource($foundedUser);
    }

    public function remove_user_role(Request $request){
        $validated_request = $request->validate([
            'user_id' => [ 'required', 'exists:users,id' ],
            'role_name' => [ 'required', 'exists:roles,name' ],
        ]);
        
        $foundedUser = User::findOrFail($validated_request['user_id']);

        $foundedUser->removeRole($validated_request['role_name']);

        return new UserResource($foundedUser);
    }
}