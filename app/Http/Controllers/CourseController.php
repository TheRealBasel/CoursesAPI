<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Course;
use App\Models\ClassRoom;
use App\Http\Resources\CourseResource;
use App\Http\Resources\ClassesResource;

class CourseController extends Controller
{

    public function new_course(Request $request){
        $vlidated_request = $request->validate([
            'course_name' => ['required','string', 'min:3'],
            'course_code' => ['required','string', 'min:3', 'max:6', 'unique:courses,course_code']
        ]);

        $created_course = Course::create($vlidated_request);

        return new CourseResource($created_course);
    }

    public function get_course(Request $request, $id){
        
        $founded_course = Course::findOrFail($id);
        return new CourseResource($founded_course);
    }

}
