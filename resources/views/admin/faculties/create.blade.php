@extends('admin.layout.master')

@section('title', 'Create Faculty')

@section('content-title', 'Create Faculty')

@section('content')
    @include('admin.layout.alert')
    {{ Form::model($faculties,['route' => 'faculties.store', 'method' => 'post']) }}


    <div class="form-group">
        <label for="exampleInputEmail1">Name</label>
        {!! Form::text('name', old('name'), ['class' => 'form-control', 'placeholder' => 'Enter Name']) !!}
    </div>


    <div style="margin-bottom:20px">
        {!! Form::submit('Create', ['class' => 'btn btn-primary']) !!}
        <a href="{{ Route('faculties.index') }}" class="btn btn-info">Back</a>
    </div>

    {!! Form::close() !!}



@endsection