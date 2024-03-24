<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Course;

class Student extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $fillable = ['name', 'email', 'address', 'contact'];
    public function courses(){
        return $this->belongsToMany(Course::class,'students_courses','student_id','course_id')->withTimestamps();
    }

}
