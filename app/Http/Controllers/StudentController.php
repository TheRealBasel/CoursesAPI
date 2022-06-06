<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ClassRoom;
use App\Http\Resources\ClassesResource;
use Illuminate\Validation\Rule;
use App\Models\ClassStudent;

class StudentController extends Controller
{
    public function join_class(Request $request){
        $validated_request = $request->validate([
            'class_id' => ['required', 'exists:class_rooms,id'],
            'student_id' => [
                'required',
                'exists:users,id',
                Rule::exists('model_has_roles', 'model_id')->where(function ($query) {
                    return $query->where('role_id', 2);
                })
            ],
        ]);
        
        $created_student = ClassStudent::create($validated_request);
        $founded_class = ClassRoom::findOrFail($validated_request['class_id']);
        return new ClassesResource($founded_class);
    }

    public function leave_class(Request $request){
        $validated_request = $request->validate([
            'class_id' => ['required', 'numeric', 'exists:class_rooms,id'],
            'student_id' => ['required', 'numeric'],
        ]);
        
        $founded_student = ClassStudent::where('class_id', $validated_request['class_id'])->where('student_id', $validated_request['student_id']);
        if ( $founded_student->first() && $founded_student->first()->delete() ){
            return response()->json([
                'success' => true,
                'message' => 'Student deleted from class'
            ], 200);
        }
        return response()->json([
            'success' => false,
            'message' => 'Student or Class Not found'
        ], 400);
    }
}
