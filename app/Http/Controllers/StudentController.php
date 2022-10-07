<?php

namespace App\Http\Controllers;

use App\Http\Requests\QuickAddRequest;
use App\Http\Requests\StudentRequest;
use App\Http\Requests\UpdateStudentRequest;
use App\Jobs\SendMailJob;
use App\Mail\AutoSendMail;
use App\Mail\SendMail;
use App\Mail\SendMailSubjects;
use App\Models\Student;
use App\Models\Subject;
use App\Models\User;
use App\Repositories\Faculty\FacultyRepositoryInterface;
use App\Repositories\Student\StudentRepositoryInterface;
use App\Repositories\Subject\SubjectRepositoryInterface;
use App\Repositories\User\UserRepositoryInterface;
use Illuminate\Contracts\Validation\Validator as ValidationValidator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class StudentController extends Controller
{

    protected $studentRepo;
    protected $facultyRepo;
    protected $userRepo;
    protected $subjectRepo;

    public function __construct(StudentRepositoryInterface $studentRepo, FacultyRepositoryInterface $facultyRepo, UserRepositoryInterface $userRepo, SubjectRepositoryInterface $subjectRepo)
    {
        $this->studentRepo = $studentRepo;
        $this->facultyRepo = $facultyRepo;
        $this->userRepo = $userRepo;
        $this->subjectRepo = $subjectRepo;
    }

    public function index(Request $request)
    {
        $students = $this->studentRepo->StdLastRecordS();
        $faculties = $this->facultyRepo->getAll()->pluck('name', 'id');
        $subjects = $this->subjectRepo->count('*');
        $students = $this->studentRepo->search($request->all());

        return view('admin.students.index', compact('students', 'faculties', 'subjects'));
    }

    public function create()
    {
        $students = $this->studentRepo->newModel();
        $faculties = $this->facultyRepo->getAll()->pluck('name', 'id');

        return view('admin.students.create', compact('students', 'faculties'));
    }

    public function store(StudentRequest $request)
    {
        $data = $request->all();
        $data['password'] = Hash::make('123123');
        $createUser = $this->userRepo->create($data);
        $idUser = $createUser->id;
        $data['user_id'] = $idUser;
        $user = $this->userRepo->find($idUser);
        $user->assignRole('student');
        $user->givePermissionTo('read');

        if ($request->hasFile('avatar')) {
            $destination_path = 'public/images/students/';
            $avatar = $request->file('avatar');
            $avatar_name = $avatar->getClientOriginalName();
            $path = $request->file('avatar')->storeAs($destination_path, $avatar_name);
            $data['avatar'] = $avatar_name;
        }

        $this->studentRepo->create($data);
        $mail = new SendMailJob($user);
        dispatch($mail);
        Session::flash('success', 'Student has been created successfully.');

        return redirect()->route('students.index');
    }

    public function quickAdd(QuickAddRequest $request)
    {
        $data = $request->all();
        $data['password'] = Hash::make('123123');
        $createUser = $this->userRepo->create($data);
        $idUser = $createUser->id;
        $data['user_id'] = $idUser;
        $user = $this->userRepo->find($idUser);
        $user->assignRole('student');
        $user->givePermissionTo('read');
        $data['avatar'] = 'userdefault.png';
        $this->studentRepo->create($data);
        $mail = new SendMailJob($user);
        dispatch($mail);

        return response()->json([
            'success' => "Create successfully"
        ], 200);
    }

    public function show($id)
    {
    }

    public function edit($id, Request $request)
    {
        $students = $this->studentRepo->find($id);

        if ($request->ajax()) {
            return response()->json([
                'data' => $students
            ], 200);
        }
    }

    public function update(UpdateStudentRequest $request, $id)
    {
        $this->studentRepo->find($id)->update($request->all());
        $student = $this->studentRepo->find($id);

        if (!empty($student->faculty->name)) {
            $facultyName = $student->faculty->name;
        } else {
            $facultyName = "Unregistered";
        }

        return response()->json(['data' => $student, 'facultyName' => $facultyName, 'student' => $request->all(), 'studentid' => $id, 'message' => 'Cập nhật thông tin sinh viên thành công'], 200);
    }

    public function destroy($id)
    {
        $user = User::join('students', 'students.user_id', 'users.id')->where('students.id', $id)->delete();
        $this->studentRepo->delete($id);

        return response()->json(['data' => 'removed'], 200);
    }

    public function regSubject(Request $request)
    {
        $data = $request->regSubjects;

        if (Auth::check()) {
            $user = Auth::user();
            $student = $this->studentRepo->whereByUserId($user->id);
            if ($data) {
                foreach ($data as $value) {
                    $student->subjects()->attach($student->id, ['subject_id' => $value]);
                    Session::flash('success', 'Successfully registered for the course');
                }
                return redirect()->back();
            }
        }

        Session::flash('error', 'This course is already registered');

        return redirect()->back();
    }

    public function updatePoint($id, Request $request)
    {
        $student = $this->studentRepo->find($id);
        $subjects = $student->subjects;

        return view('admin.students.add_point', compact('student', 'subjects'));
    }

    public function getValueSubject(Request $request)
    {
        $student = $this->studentRepo->find($request->idStudent);
        $subjectsPoint = $student->subjects;

        return response()->json(['data' => $subjectsPoint, 'subject_id' => $request->idSubject], 200);
    }

    public function autoSendMail()
    {
        $students = $this->studentRepo->with(['subjects'])->get();
        $countSubject = $this->subjectRepo->count('id');

        foreach ($students as $value) {
            if ($value->subjects->count() == $countSubject) {
                $listID[] = $value;
            }
        }

        foreach ($listID as $value) {
            for ($i = 0; $i < $countSubject; $i++) {
                if ($value->subjects[$i]->pivot->point === null) {
                    break;
                } elseif ($i == $countSubject - 1) {
                    $avg = round($value->subjects[$i]->pivot->avg('point'));
                    if ($avg < 5) {
                        $sendMail = new AutoSendMail();
                        Mail::to($value->email)->queue($sendMail);
                    }
                }
            }
        }
        $avg = 0;

        $students = Student::where('user_id', '!=', 1)->with('subjects')->get();
        $subject = new Subject();
        $listStudentLearned = [];
        $listStudentFullMark = [];
        foreach ($students as $student) {
            if ($student->subjects->count() === $subject->count()) {
                $listStudentLearned[] = $student;
            }
        }
        foreach ($listStudentLearned as $value) {
            for ($i = 0; $i < $subject->count(); $i++) {
                if ($value->subjects[$i]->pivot->mark === null) {
                    break;
                } elseif ($i == $subject->count() - 1) {
                    $listStudentFullMark[] = $value;
                }
            }
        }

        $result = '';
        foreach ($listStudentFullMark as $student) {
            if ($student->subjects->avg('pivot.mark') > 5) {
                $result = 'OK';
            } else {
                $result = 'Thôi học';
            }
            // Mail::to($student->email)->queue(new AlertMarkMail($result, $student->subjects->avg('pivot.mark')));
        }
        return 0;
    }

    public function subjectDetail($id)
    {
        $subjectDetail = $this->studentRepo->with(['subjects'])->find($id);

        return view('admin.students.subject_detail', compact('subjectDetail'))->render();
    }

    public function studentPoint(Request $request)
    {
        $dataPoint = $request->dataPoint;
        if ($request->ajax()) {
            $student = $this->studentRepo->find($request->id);
            if ($student) {
                for ($i = 0; $i < $student->count(); $i++) {
                    if (isset($dataPoint[$i]) &&  $dataPoint[$i] !== null) {
                        $student->subjects[$i]->pivot->update(
                            ['point' => $dataPoint[$i]]
                        );
                    } else {
                        break;
                    }
                }
            }
        }
        return response()->json([
            'success' => "Update Successfully"
        ]);
    }
}
