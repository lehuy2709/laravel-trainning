<?php

namespace App\Http\Controllers;

use App\Http\Requests\FacultyRequest;
use App\Http\Requests\SubjectRequest;
use App\Models\Subject;
use App\Repositories\Subject\SubjectRepositoryInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class SubjectController extends Controller
{

    protected $subjectRepo;
    public function __construct(SubjectRepositoryInterface $subjectRepo)
    {
        $this->subjectRepo = $subjectRepo;
    }
    public function index()
    {

        $subjects = $this->subjectRepo->getLatestRecord()->Paginate(5);
        return view('admin.subjects.index', compact('subjects'));
    }


    public function create()
    {

        $subjects = new Subject();
        return view('admin.subjects.create', compact('subjects'));
    }


    public function store(SubjectRequest $request)
    {
        $subjects = $this->subjectRepo->create($request->all());
        Session::flash('success', 'Subject has been created successfully.');
        return redirect()->route('subjects.index');
    }


    public function show($id)
    {
    }


    public function edit($id)
    {

        $subject = $this->subjectRepo->find($id);
        return view('admin.subjects.edit', compact('subject'));
    }


    public function update(FacultyRequest $request, $id)
    {

        $data = $request->all();
        $this->subjectRepo->update($id, $data);
        Session::flash('success', 'Subject has successfully updated.');
        return redirect()->route('subjects.index');
    }


    public function destroy($id)
    {
        $this->subjectRepo->delete($id);
        return redirect()->route('subjects.index');
    }
}
