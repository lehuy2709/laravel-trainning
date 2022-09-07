<?php
namespace App\Repositories\Student;
use App\Repositories\RepositoryInterface;

interface StudentRepositoryInterface extends RepositoryInterface
{
    public function newStudent();

    public function search($data);

    public function getStudents();
}
