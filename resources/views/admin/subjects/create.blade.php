@extends('admin.layout.master')

@section('title', 'Create Subjects')

@section('content-title', 'Create Subjects')

@section('content')
    @include('admin.layout.alert')
    {{ Form::model($subjects, ['route' => 'subjects.store', 'method' => 'post']) }}


    <div class="form-group">
        <label for="exampleInputEmail1">Name</label>
        {!! Form::text('name', old('name'), ['class' => 'form-control', 'placeholder' => 'Enter Name']) !!}
    </div>


    <div style="margin-bottom:20px">
        {!! Form::submit('Create', ['class' => 'btn btn-primary']) !!}
        <a href="{{ Route('subjects.index') }}" class="btn btn-info">Back</a>
    </div>

    {!! Form::close() !!}



@endsection
