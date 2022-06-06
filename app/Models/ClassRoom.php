<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Course;

class ClassRoom extends Model
{
    use HasFactory;

    protected $fillable = [
        'start_time',
        'end_time',
        'days',
        'course_id',
        'teacher_id'
    ];

    protected $casts = [
        'days' => 'array'
    ];

    public function course(){
        return $this->belongsTo(Course::class);
    }
    public function teacher(){
        return $this->belongsTo(User::class);
    }
    public function students(){
        return $this->hasMany(User::class);
    }
}
