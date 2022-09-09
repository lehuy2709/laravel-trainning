<?php

namespace App\Http\Controllers;

use App\Http\Requests\FacultyRequest;
use App\Http\Requests\SubjectRequest;
use App\Jobs\SendMailSubjectsJob;
use App\Models\Student;
use App\Models\Subject;
use App\Repositories\Student\StudentRepositoryInterface;
use App\Repositories\Subject\SubjectRepositoryInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;
use Mockery\Matcher\Subset;

class SubjectController extends Controller
{

    protected $subjectRepo;
    protected $studentRepo;

    public function __construct(SubjectRepositoryInterface $subjectRepo, StudentRepositoryInterface $studentRepo)
    {
        $this->subjectRepo = $subjectRepo;
        $this->studentRepo = $studentRepo;
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
            } else {
                $subjectsPoint = '';
            }
        }
        $subjects = $this->subjectRepo->getLatestRecord();

        return view('admin.subjects.index', compact('subjects', 'subjectsPoint'));
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

    public function sendMail($id)
    {
        $subjects = $this->subjectRepo->getAll();
        // dd($subjects);
        $student = $this->studentRepo->find($id);
        $subject = $student->subjects;
        // dd($subject);
        $listSubject = [];
        if ($subject->count() == 0) {
            $listSubject = $subjects;
        } else {
            foreach ($subjects as $value) {
                for ($i = 0; $i < $subject->count(); $i++) {
                    if ($value->id == $subject[$i]->id) {
                        break;
                    } elseif ($i == $subject->count() - 1) {
                        $listSubject[] = $value;
                    }
                }
            }
        }
        $sendMail = new SendMailSubjectsJob($listSubject);
        dispatch($sendMail);
    }
}
