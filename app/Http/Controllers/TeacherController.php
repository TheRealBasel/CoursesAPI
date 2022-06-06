<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Http\Resources\UserResource;
use Illuminate\Validation\Rule;
use App\Models\ClassStudent;
use App\Models\ClassRoom;
use App\Http\Resources\ClassesResource;


class TeacherController extends Controller
{
    public function get_teacher_students(Request $request){
        $validated_request = $request->validate([
            'teacher_id' => [
                'required',
                'exists:users,id',
                Rule::exists('model_has_roles', 'model_id')->where(function ($query) {
                    return $query->where('role_id', 3);
                })
            ]
        ]);
        
        $classes = ClassRoom::where('teacher_id', $validated_request['teacher_id'])->pluck('id')->toArray();
        $students_id = ClassStudent::where('class_id', $classes)->pluck('student_id')->toArray();

        return UserResource::collection(User::findMany($students_id));
    }

    public function get_teacher_courses(Request $request){
        $classes = ClassRoom::where('teacher_id', $request->user()->id)->pluck('id')->toArray();
        return ClassesResource::collection(ClassRoom::findMany($classes));
    }

}

