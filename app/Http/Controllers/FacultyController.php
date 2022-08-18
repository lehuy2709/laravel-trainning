<?php

namespace App\Http\Controllers;

use App\Http\Requests\FacultyRequest;
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

    public function index()
    {
        $faculties = $this->facultyRepo->Paginate(5);
        return view('admin.faculty.index', compact('faculties'));
    }

    public function create()
    {
        //

        return view('admin.faculty.create');
    }


    public function store(FacultyRequest $request)
    {
        $this->facultyRepo->create($request->all());
        Session::flash('success', 'Faculty has been created successfully.');
        return redirect()->route('faculties.index');
    }


    public function show($id)
    {
    }


    public function edit($id)
    {
        $faculty = $this->facultyRepo->find($id);

        return view('admin.faculty.edit', compact('faculty'));
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
        return redirect()->route('faculties.index');
    }
}
