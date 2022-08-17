@extends('admin.layout.master')

@section('title', 'Manage Faculty')

@section('content-title', 'Manage Faculty')

@section('content')
    <div>
        <a href="{{Route('faculties.create')}}" class="btn btn-success" style="margin-bottom:20px;">Create</a>
    </div>
    <table class='table'>
        <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>


        </tbody>
    </table>
    <div>

    </div>
@endsection
