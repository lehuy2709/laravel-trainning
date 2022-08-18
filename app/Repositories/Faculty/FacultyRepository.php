<?php

namespace App\Repositories\Faculty;

// use App\Models\Facutly;
use App\Repositories\BaseRepository;
use App\Models\Faculty;

class FacultyRepository extends BaseRepository implements FacultyRepositoryInterface
{
    public function getModel()
    {
        return Faculty::class;
    }

    public function newFaculty()
    {
        return new $this->model;
    }
}
