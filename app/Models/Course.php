<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\ClassRoom;

class Course extends Model
{
    use HasFactory;

    protected $fillable = [
        'course_name',
        'course_code'
    ];

    public function classes(){
        return $this->hasMany(ClassRoom::class);
    }
}
