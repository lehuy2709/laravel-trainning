@extends('admin.layout.master')

@section('title', 'Edit Subject')

@section('content-title', 'Edit Subject')

@section('content')
    @include('admin.layout.alert')
    {!! Form::model($subject, ['route' => ['subjects.update', $subject->id], 'method' => 'PUT']) !!}


    <div class="form-group">
        <label for="exampleInputEmail1">Name</label>
        {!! Form::text('name', old('name'), ['class' => 'form-control']) !!}
    </div>


    <div style="margin-bottom:20px">
        {!! Form::submit('Save  ', ['class' => 'btn btn-primary']) !!}
        <a href="{{ Route('subjects.index') }}" class="btn btn-info">Back</a>
    </div>

    {!! Form::close() !!}



@endsection
