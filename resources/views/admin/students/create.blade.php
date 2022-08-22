@extends('admin.layout.master')

@section('title', 'Create Student')

@section('content-title', 'Create Student')

@section('content')
    {{ Form::model($students, ['route' => 'students.store', 'method' => 'post', 'enctype' => 'multipart/form-data']) }}


    <div class="form-group">
        <label for="exampleInputEmail1">Name</label>
        {!! Form::text('name', old('name'), ['class' => 'form-control', 'placeholder' => 'Enter Name']) !!}
    </div>

    @error('name')
        <div class="text-danger">
            {{ $message }}
        </div>
    @enderror

    <div class="form-group">
        <label for="exampleInputEmail1">Faculty</label>
        {!! Form::select('faculty_id', $faculties, null, ['class' => 'form-control']) !!}
    </div>

    <div class="form-group">
        <label for="exampleInputEmail1">Email</label>
        {!! Form::text('email', old('email'), ['class' => 'form-control', 'placeholder' => 'Enter email']) !!}
    </div>
    @error('email')
        <div class="text-danger">
            {{ $message }}
        </div>
    @enderror
    <div class="form-group">
        <label for="exampleInputEmail1">Phone</label>
        {!! Form::text('phone', old('phone'), ['class' => 'form-control', 'placeholder' => 'Enter phone']) !!}
    </div>
    @error('phone')
        <div class="text-danger">
            {{ $message }}
        </div>
    @enderror
    <div class="form-group">
        <label for="exampleInputEmail1">Avatar</label>
        {!! Form::file('avatar', ['class' => 'form-control']) !!}
    </div>
    @error('avatar')
        <div class="text-danger">
            {{ $message }}
        </div>
    @enderror
    <div class="form-group">
        <label for="exampleInputEmail1">Gender</label>
        <div class="form-check">
            {!! Form::radio('gender', '1', true) !!}
            <label class="form-check-label" for="exampleRadios1">
                Nam
            </label>
        </div>
        <div class="form-check">
            {!! Form::radio('gender', '2', true) !!}
            <label class="form-check-label" for="exampleRadios2">
                Nữ
            </label>
        </div>
    </div>

    <div class="form-group">
        <label for="exampleInputEmail1">Address</label>
        {!! Form::text('address', old('address'), ['class' => 'form-control', 'placeholder' => 'Enter address']) !!}
    </div>
    @error('address')
        <div class="text-danger">
            {{ $message }}
        </div>
    @enderror

    <div class="form-group">
        <label for="exampleInputEmail1">BirthDay</label>
        {!! Form::date('birthday', old('birthday'), ['class' => 'form-control']) !!}
    </div>
    @error('birthday')
        <div class="text-danger">
            {{ $message }}
        </div>
    @enderror


    <div style="margin-bottom:20px">
        {!! Form::submit('Create', ['class' => 'btn btn-primary']) !!}
        <a href="{{ Route('students.index') }}" class="btn btn-info">Back</a>
    </div>

    {!! Form::close() !!}



@endsection
