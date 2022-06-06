<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Course;
use App\Models\ClassRoom;
use App\Http\Resources\CourseResource;
use App\Http\Resources\ClassesResource;
use Illuminate\Validation\Rule;
use App\Models\ClassStudent;

class ClassesController extends Controller
{

    public function new_class(Request $request){
        $validated_request = $request->validate([
            'start_time' => ['required', 'date_format:H:i'],
            'end_time' => ['required','date_format:H:i'],
            'days' => ['required', 'array'],
            'teacher_id' => [
                'required',
                'exists:users,id',
                Rule::exists('model_has_roles', 'model_id')->where(function ($query) {
                    return $query->where('role_id', 3);
                }),
        
            ],
            'course_id' => ['required', 'exists:courses,id']
        ]);
        
        $founded_course = Course::findOrFail($validated_request['course_id']);
        $created_class = ClassRoom::create($validated_request);
        $founded_course->classes()->Save($created_class);
        
        return new ClassesResource($created_class);
    }

    public function get_class(Request $request, $id){        
        $founded_class = ClassRoom::findOrFail($id);
    
        return new ClassesResource($founded_class);
    }
}
