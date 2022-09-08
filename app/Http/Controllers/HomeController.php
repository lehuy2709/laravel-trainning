<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdateStudentRequest;
use App\Models\User;
use App\Repositories\Student\StudentRepositoryInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class HomeController extends Controller
{

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    protected $studentRepo;

    public function __construct(StudentRepositoryInterface $studentRepo)
    {
        $this->studentRepo = $studentRepo;
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        if (Auth::check()) {
            $student = $this->studentRepo->whereByUserId(Auth::id());
            if ($student) {
                return view('client.home', compact('student'));
            }
        }
    }

    public function updateStudent(UpdateStudentRequest $request, $id)
    {
        $data = $request->all();

        if ($request->hasFile('avatar')) {
            $destination_path = 'public/images/students/';
            $avatar = $request->file('avatar');
            $avatar_name = $avatar->getClientOriginalName();
            $path = $request->file('avatar')->storeAs($destination_path, $avatar_name);
            $data['avatar'] = $avatar_name;
        }

        $this->studentRepo->update($id,$data);
        Session::flash('success', 'Updated successfully.');

        return redirect()->back();
    }
}
