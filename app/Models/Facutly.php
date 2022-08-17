<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Facutly extends Model
{
    use HasFactory;
    protected $table = 'faculties';
    protected $fillable = [
        'name'
    ];
}
