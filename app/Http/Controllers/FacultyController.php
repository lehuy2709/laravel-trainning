<?php

namespace App\Http\Controllers;

use App\Http\Requests\FacultyRequest;
use App\Models\Faculty;
use App\Repositories\Faculty\FacultyRepositoryInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class FacultyController extends Controller
{

    protected $facultyRepo;

    public function __construct(FacultyRepositoryInterface $facultyRepo)
    {
        $this->facultyRepo = $facultyRepo;
    }

    public function index(Request $request)
    {
        $faculties = $this->facultyRepo->getLatestRecord();
        if ($request->ajax()) {
            return response()->json([
                'faculties' => $faculties
            ],200);
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
        Session::flash('success', 'Faculty has been created successfully.');

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

    public function destroy($id)
    {
        $this->facultyRepo->delete($id);
        Session::flash('success', 'Faculty has successfully updated.');

        return redirect()->route('faculties.index');
    }
}
