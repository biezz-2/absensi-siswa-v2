<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SchoolClass extends Model
{
    protected $table = 'classes';

    protected $guarded = [];

    public function subjects()
    {
        return $this->belongsToMany(Subject::class, 'class_subject');
    }

    public function homeroomTeacher()
    {
        return $this->belongsTo(Teacher::class, 'teacher_id');
    }

    public function students()
    {
        return $this->hasMany(Student::class);
    }
}
