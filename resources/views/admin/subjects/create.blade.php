@extends('admin.layout.master')

@section('title', 'Create Faculty')

@section('content-title', isset($id) ? 'Update Subject' : 'Create Subject')

@section('content')
    @include('admin.layout.alert')

    @if (isset($id))
        {{ Form::model($subject, ['route' => ['subjects.update', $id], 'method' => 'PUT']) }}
    @else
        {{ Form::model($subject, ['route' => 'subjects.store', 'method' => 'post']) }}
    @endif

    <div class="form-group">
        {{ Form::label('name', 'Subject Name') }}
        {{ Form::text('name', $subject->name, ['class' => 'form-control', 'placeholder' => 'Enter Name']) }}
    </div>

    <div style="margin-bottom:20px">
        {{ Form::submit(isset($id) ? 'Save' : 'Create', ['class' => 'btn btn-primary']) }}
        <a href="{{ Route('subjects.index') }}" class="btn btn-default">Back</a>
    </div>

    {{ Form::close() }}
@endsection
