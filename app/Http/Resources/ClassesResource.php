<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\UserResource;
use App\Models\User;
use App\Models\ClassStudent;
use Spatie\Permission\Models\Role;

class ClassesResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        // UserResource::collection(ClassStudent::where('class_id', $this->id)-get())
        $students = ClassStudent::where('class_id', $this->id)->get();
        return [
            'start_time' => $this->start_time,
            'end_time' => $this->end_time,
            'teacher' => $this->teacher_id,
            'students' => $students,
            'days' => $this->days
        ];
    }
}
