<?php

namespace App\Http\Controllers;

use App\Http\Requests\FacultyRequest;
use App\Http\Requests\SubjectRequest;
use App\Models\Student;
use App\Models\Subject;
use App\Repositories\Subject\SubjectRepositoryInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Mockery\Matcher\Subset;

class SubjectController extends Controller
{

    protected $subjectRepo;

    public function __construct(SubjectRepositoryInterface $subjectRepo)
    {
        $this->subjectRepo = $subjectRepo;
    }
    public function index()
    {
        if (Auth::check()) {
            $user = Auth::user();
            if ($user->hasRole('student')) {

                $student = Student::where('user_id', $user->id)->first();

                if ($student) {
                    $subjectsPoint = $student->subjects;
                }
            }

            else{
                $subjectsPoint = '';
            }

        }
        $subjects = $this->subjectRepo->getLatestRecord();

        return view('admin.subjects.index', compact('subjects','subjectsPoint'));


    }

    public function create()
    {
        $subject = $this->subjectRepo->newModel();

        return view('admin.subjects.create', compact('subject'));
    }

    public function store(SubjectRequest $request)
    {
        $subjects = $this->subjectRepo->create($request->all());
        Session::flash('success', 'Subject has been created successfully.');

        return redirect()->route('subjects.index');
    }

    public function edit($id)
    {
        $subject = $this->subjectRepo->find($id);

        return view('admin.subjects.create', compact('subject', 'id'));
    }

    public function update(SubjectRequest $request, $id)
    {
        $data = $request->all();
        $this->subjectRepo->update($id, $data);
        Session::flash('success', 'Subject has successfully updated.');

        return redirect()->route('subjects.index');
    }

    public function destroy($id)
    {
        $subject = $this->subjectRepo->find($id);

        if ($subject->students()->count('*')) {
            return response()->json(['error' => 'can not delete'], 404);
        }

        $this->subjectRepo->delete($id);

        return response()->json(['data' => $subject], 200);
    }
}
