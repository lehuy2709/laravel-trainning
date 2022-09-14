<?php

namespace App\Http\Controllers;

use App\Http\Requests\FacultyRequest;
use App\Http\Requests\SubjectRequest;
use App\Jobs\SendMailSubjectsJob;
use App\Mail\SendMailSubjects;
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
                $student = $this->studentRepo->whereByUserId($user->id);

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
        $student = $this->studentRepo->find($id);
        $subject = $student->subjects;
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

        $sendMail = new SendMailSubjects($listSubject);
        Mail::to($student->email)->queue($sendMail);
        session::flash('success', 'Send mail successfully');

        return redirect()->back();
    }

    public function sendMailAll()
    {
        $subjects = $this->subjectRepo->getAll();
        $students = $this->studentRepo->getAll();

        foreach ($students as $value) {
            if ($value->subjects->count() != $subjects->count()) {
                $listIds[] = $value->id;
            }
        }

        foreach ($listIds as $value) {
            $listSubject = [];
            $student = $this->studentRepo->find($value);
            $subject_student = $student->subjects;

            if ($subject_student->count() == 0) {
                $listSubject = $subjects;
            } else {
                foreach ($subjects as $value) {
                    for ($i = 0; $i < $subject_student->count(); $i++) {
                        if ($value->id == $subject_student[$i]->id) {
                            break;
                        } elseif ($i == $subject_student->count() - 1) {
                            $listSubject[] = $value;
                        }
                    }
                }
            }
            $sendMail = new SendMailSubjects($listSubject);
            Mail::to($student->email)->queue($sendMail);
        }
        session::flash('success', 'Send mail successfully');

        return redirect()->back();
    }
}
