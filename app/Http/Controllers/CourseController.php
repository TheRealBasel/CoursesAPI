<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Course;
use App\Http\Resources\CourseResource;

class CourseController extends Controller
{

    public function store(Request $request){
        $request->validate([
            'course_name' => ['required','string', 'min:3'],
            'course_code' => ['required','string', 'min:3', 'max:6', 'unique:courses,course_code']
        ]);

        $created_course = Course::create($request->toArray());

        return new CourseResource($created_course);
    }

    public function show(Request $request, $id){
        
        $founded_course = Course::findOrFail($id);
        return new CourseResource($founded_course);
    }

}
