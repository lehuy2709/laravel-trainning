<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Student extends Model
{
    use HasFactory,SoftDeletes;
    protected $fillable = [
        'name',
        'email',
        'phone',
        'avatar',
        'gender',
        'address',
        'birthday',
        'faculty_id',
        'user_id'
    ];
    public function faculty()
    {
        return $this->belongsTo(Faculty::class);
    }

    public function subjects(){
        return $this->belongsToMany(Subject::class,'student_subject','student_id','subject_id')->withPivot('point');
    }
}
