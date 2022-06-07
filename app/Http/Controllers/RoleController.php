<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Http\Resources\UserResource;

class RoleController extends Controller
{
    public function modifyUserRole (Request $request){
        $request->validate([
            'user_id' => [ 'required', 'exists:users,id' ],
            'role_name' => [ 'required', 'exists:roles,name' ],
        ]);

        if ( $request->isMethod('post') ){
            $user = User::find($request->user_id)->assignRole($request->role_name);
        }else if ($request->isMethod('delete')){
            $user = User::find($request->user_id)->removeRole($request->role_name);
        }
        return new UserResource($user);
    }
}