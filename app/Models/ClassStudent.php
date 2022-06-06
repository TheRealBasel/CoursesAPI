<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\ClassRoom;

class ClassStudent extends Model
{
    use HasFactory;

    protected $fillable = [
        'class_id',
        'student_id'
    ];

    public function classes(){
        return $this->belongsTo(ClassRoom::class);
    }
}
