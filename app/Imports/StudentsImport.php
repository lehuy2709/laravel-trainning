<?php

namespace App\Imports;

use App\Models\Subject;
use Dflydev\DotAccessData\Data;
use Maatwebsite\Excel\Concerns\ToModel;

class StudentsImport implements ToModel
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new Data([
            //
        ]);
    }
}
