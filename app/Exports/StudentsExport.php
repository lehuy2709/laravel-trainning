<?php

namespace App\Exports;

use App\Models\Subject;
use Illuminate\Contracts\Support\Responsable;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class StudentsExport implements FromCollection, Responsable, WithMapping, ShouldAutoSize, WithHeadings
{
    /**
     * @return \Illuminate\Support\Collection
     */
    use Exportable;
    private $fileName = "studentsPoint.xlsx";
    protected $id;

    public function __construct($id)
    {
        $this->id = $id;
    }

    public function collection()
    {
        return Subject::where('id', $this->id)->with('students')->get();
    }

    public function map($subjects): array
    {
        $data = [];

        foreach ($subjects->students as $student) {
            $data[] = [
                $student->id,
                $student->name,
                $student->email,
                $student->pivot->point
            ];
        }

        return $data;
    }

    public function headings(): array
    {
        return [
            'id',
            'name',
            'email',
            'point'
        ];
    }

}
