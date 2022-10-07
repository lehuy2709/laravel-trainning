<?php

namespace App\Repositories\Student;

use App\Repositories\BaseRepository;
use App\Models\Student;
use App\Models\Subject;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
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
        if (isset($data['fromPoint']) && isset($data['toPoint'])) {

            $students = Student::with('subjects')->get();
            $countSubject = Subject::count('id');

            foreach ($students as $value) {
                if ($value->subjects->count() == $countSubject) {
                    foreach ($value->subjects as $item) {
                        if ($item->pivot->point) {
                            $listID[] = $value->id;
                            break;
                        }
                    }
                }
            }
            $stds = Student::with('subjects')->whereIn('id', $listID)->get();
            foreach ($stds as $item) {
                foreach ($item->subjects as $value) {
                    $avgs = $value->pivot->select(DB::raw("student_id ,count(subject_id) as abc , avg(point) as avg"))->groupBy('student_id')->havingRaw("abc = $countSubject")->get();
                    break;
                }
            }
            foreach ($avgs as $avg) {
                if ($avg->avg >= $data['fromPoint'] && $avg->avg <= $data['toPoint']) {
                    $idFilter[] = $avg->student_id;
                }
            }
            if (isset($idFilter)) {
                $student->with('subjects')->whereIn('id', $idFilter);
            } else {
                return $student = [];
            }
        }

        return $student->orderByRaw("updated_at DESC, created_at DESC")->paginate(5)->withQueryString();
    }

    public function getStudents()
    {
        return $this->model->select('id', 'name', 'faculty_id', 'email', 'avatar', 'birthday', 'phone', 'created_at', 'updated_at')
            ->orderBy('updated_at', 'DESC')->paginate(5);
    }

    public function whereByUserId($id)
    {
        return $this->model->where('user_id', $id)->first();
    }
    public function StdLastRecordS()
    {
        return $this->model->with('subjects')->orderByRaw("updated_at DESC, created_at DESC")->paginate(5);
    }

    public function whereByFaculty($id)
    {
        return $this->model->where('faculty_id', $id)->get();
    }
}
