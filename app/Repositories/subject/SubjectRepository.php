<?php

namespace App\Repositories\Subject;
use App\Repositories\BaseRepository;
use App\Models\Subject;

class SubjectRepository extends BaseRepository implements SubjectRepositoryInterface
{
    public function getModel()
    {
        return Subject::class;
    }

    public function newSubject()
    {
        return new $this->model;
    }
}
