<?php

namespace App\Repositories\Student;

use App\Repositories\BaseRepository;
use App\Models\Student;
use Carbon\Carbon;
use PhpParser\Node\Expr\FuncCall;

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
    public function search($data)
    {
        $student = $this->model->newQuery();

        if (isset($data['fromAge'])) {
            $student->whereYear('birthday', '<=', Carbon::now()->subYear($data['fromAge'])->format('Y'));
        }

        if (isset($data['toAge'])) {
            $student->whereYear('birthday', '>=', Carbon::now()->subYear($data['toAge'])->format('Y'));
        }

        return $student->paginate(5)->withQueryString();
    }

    public function getStudents()
    {
        return $this->model->select('id', 'name', 'faculty_id', 'email', 'avatar', 'birthday', 'phone', 'created_at', 'updated_at')
            ->with('faculty')
            ->orderBy('updated_at', 'DESC')->paginate(5);
    }
}
