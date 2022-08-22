<?php

namespace App\Repositories\Student;

use App\Repositories\BaseRepository;
use App\Models\Student;

class StudentRepository extends BaseRepository implements StudentRepositoryInterface
{
    public function getModel()
    {
        return Student::class;
    }

    public function newStudent()
    {
        return new $this->model;
    }
}
