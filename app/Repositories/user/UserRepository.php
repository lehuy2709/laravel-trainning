<?php

namespace App\Repositories\Subject;

use App\Repositories\BaseRepository;
use App\Models\User;

class UserRepository extends BaseRepository implements SubjectRepositoryInterface
{
    public function getModel()
    {
        return User::class;
    }

    public function newSubject()
    {
        return new $this->model;
    }
}
