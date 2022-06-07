<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Course;
use App\Models\ClassRoom;
use App\Http\Resources\ClassesResource;
use Illuminate\Validation\Rule;

class ClassesController extends Controller
{

    public function store(Request $request){
        $request->validate([
            'start_time' => ['required', 'date_format:H:i'],
            'end_time' => ['required','date_format:H:i'],
            'days' => ['required', 'array'],
            'teacher_id' => [
                'required',
                'exists:users,id',
                Rule::exists('model_has_roles', 'model_id')->where(function ($query) {
                    return $query->where('role_id', $this->TEACHER_ROLE_ID);
                }),
        
            ],
            'course_id' => ['required', 'exists:courses,id']
        ]);
        
        $created_class = ClassRoom::create($request->toArray());
        Course::find($request->course_id)->classes()->save($created_class);
        
        return new ClassesResource($created_class);
    }

    public function show(Request $request, $id){        
        $founded_class = ClassRoom::findOrFail($id);
    
        return new ClassesResource($founded_class);
    }
}
