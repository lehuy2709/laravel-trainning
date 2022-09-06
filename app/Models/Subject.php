<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subject extends Model
{
    use HasFactory;
    protected $fillable = [
        'name'
    ];

    public function students(){
        return $this->belongsToMany(Student::class,'student_subject','student_id','subject_id')->withPivot('point');
    }
}
