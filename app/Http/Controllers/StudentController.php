<?php

namespace App\Http\Controllers;

use App\Http\Requests\StudentRequest;
use App\Models\Student;
use App\Repositories\Faculty\FacultyRepositoryInterface;
use App\Repositories\Student\StudentRepositoryInterface;
use App\Repositories\User\UserRepositoryInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;

class StudentController extends Controller
{

    protected $studentRepo;
    protected $facultyRepo;
    protected $userRepo;

    public function __construct(StudentRepositoryInterface $studentRepo, FacultyRepositoryInterface $facultyRepo, UserRepositoryInterface $userRepo)
    {
        $this->studentRepo = $studentRepo;
        $this->facultyRepo = $facultyRepo;
        $this->userRepo = $userRepo;
    }

    public function index()
    {
        $students = $this->studentRepo
            ->getLatestRecord()
            ->with(['faculty'])
            ->Paginate(5);

        return view('admin.students.index', compact('students'));
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
        Session::flash('success', 'Student has been created successfully.');

        return redirect()->route('students.index');
    }


    public function show($id)
    {
    }

    public function edit($id)
    {
        $students = $this->studentRepo->find($id);

        return response()->json([
            'data' => $students
        ], 200);
    }

    public function update(Request $request, $id)
    {
    }

    public function destroy($id)
    {
        $this->studentRepo->delete($id);

        return redirect()->route('students.index');
    }
}
