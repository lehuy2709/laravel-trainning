<?php

namespace App\Http\Controllers;

use App\Http\Requests\FacultyRequest;
use App\Models\Faculty;
use App\Models\Student;
use App\Repositories\Faculty\FacultyRepositoryInterface;
use App\Repositories\Student\StudentRepositoryInterface;
use App\Repositories\Subject\SubjectRepositoryInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class FacultyController extends Controller
{

    protected $facultyRepo;
    protected $studentRepo;
    protected $subjectRepo;

    public function __construct(FacultyRepositoryInterface $facultyRepo, StudentRepositoryInterface $studentRepo, SubjectRepositoryInterface $subjectRepo)
    {
        $this->facultyRepo = $facultyRepo;
        $this->studentRepo = $studentRepo;
        $this->subjectRepo = $subjectRepo;
    }

    public function index(Request $request)
    {
        $faculties = $this->facultyRepo->getLatestRecord();

        if (Auth::check()) {
            $user = Auth::user();

            if ($user->hasRole('student')) {
                $stdFaculty = $this->studentRepo->whereByUserId($user->id);
                return view('admin.faculties.index', compact('faculties', 'stdFaculty'));
            }
        }

        if ($request->ajax()) {
            return response()->json([
                'faculties' => $faculties
            ], 200);
        }

        return view('admin.faculties.index', compact('faculties'));
    }

    public function create()
    {
        $faculty = $this->facultyRepo->newFaculty();

        return view('admin.faculties.create', compact('faculty'));
    }

    public function store(FacultyRequest $request)
    {
        $this->facultyRepo->create($request->all());
        Session::flash('success', __('lg.create-faculty-success'));

        return redirect()->route('faculties.index');
    }

    public function edit($id)
    {
        $faculty = $this->facultyRepo->find($id);

        return view('admin.faculties.create', compact('faculty', 'id'));
    }

    public function update(FacultyRequest $request, $id)
    {
        $data = $request->all();
        $this->facultyRepo->update($id, $data);
        Session::flash('success', 'Faculty has successfully updated.');

        return redirect()->route('faculties.index');
    }

    public function registerFaculty($id)
    {
        $student = $this->studentRepo->whereByUserId(Auth::user()->id);
        $countSubject = $this->subjectRepo->count('id');
        $sum = 0;
        $count = 0;
        if ($student->faculty_id) {
            Session::flash('error', 'You can not register');

            return redirect()->back();
        }
        foreach ($student->subjects as $std) {
            if ($student->subjects->count() == $countSubject) {
                $count++;
                if (!$std->pivot->point) {
                    Session::flash('error', 'You can not register');

                    return redirect()->back();
                }
                $sum += $std->pivot->point;
            } else {
                Session::flash('error', 'You can not register');

                return redirect()->back();
            }
        }

        if ($sum) {
            $avg = $sum / $count;
            if ($avg < 5) {
                Session::flash('error', 'Your AVG < 5 and You can not register');

                return redirect()->back();
            } else {
                $data = [
                    'faculty_id' => $id
                ];
                $this->studentRepo->update($student->id, $data);
                Session::flash('success', 'Register Successfully');

                return redirect()->back();
            }
        }
        Session::flash('error', 'You can not register');

        return redirect()->back();
    }

    public function destroy($id)
    {
        $students = $this->studentRepo->whereByFaculty($id);
        $studentId = $students->pluck('id');
        $student = $this->studentRepo->newModel();
        $student->whereIn('id', $studentId)->update(['faculty_id' => null]);
        $this->facultyRepo->delete($id);
        Session::flash('success', 'Faculty has successfully updated.');

        return redirect()->route('faculties.index');
    }
}
