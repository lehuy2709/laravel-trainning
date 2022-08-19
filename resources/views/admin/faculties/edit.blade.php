@extends('admin.layout.master')

@section('title', 'Edit Faculty')

@section('content-title', 'Edit Faculty')

@section('content')
    @include('admin.layout.alert')
    {!! Form::model($faculty, ['route' => ['faculties.update', $faculty->id], 'method' => 'PUT']) !!}


    <div class="form-group">
        <label for="exampleInputEmail1">Name</label>
        {!! Form::text('name', old('name'), ['class' => 'form-control']) !!}
    </div>


    <div style="margin-bottom:20px">
        {!! Form::submit('Save  ', ['class' => 'btn btn-primary']) !!}
        <a href="{{ Route('faculties.index') }}" class="btn btn-info">Back</a>
    </div>

    {!! Form::close() !!}



@endsection
