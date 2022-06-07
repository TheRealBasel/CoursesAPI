<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ClassRoom;
use App\Http\Resources\ClassesResource;
use Illuminate\Validation\Rule;
use App\Models\ClassStudent;

class StudentController extends Controller
{
    public function store(Request $request){
        $request->validate([
            'class_id' => ['required', 'exists:class_rooms,id'],
            'student_id' => [
                'required',
                'exists:users,id',
                Rule::exists('model_has_roles', 'model_id')->where(function ($query) {
                    return $query->where('role_id', $this->STUDENT_ROLE_ID);
                })
            ],
        ]);
        
        ClassStudent::create($request->toArray());

        $founded_class = ClassRoom::find($request->class_id);

        return new ClassesResource($founded_class);
    }

    public function destroy(Request $request){
        $request->validate([
            'class_id' => ['required', 'numeric', 'exists:class_rooms,id'],
            'student_id' => ['required', 'numeric'],
        ]);
        
        $student = ClassStudent::where('class_id', $request->class_id)->whereOrFail('student_id', $request->student_id)->first();
        
        $student->delete();

        return response()->json([
            'success' => true,
            'message' => 'Student deleted from class'
        ], 200);
    }
}
