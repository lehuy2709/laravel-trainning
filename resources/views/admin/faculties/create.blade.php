@extends('admin.layout.master')

@section('title', 'Create Faculty')

@section('content-title', isset($id) ? 'Update Faculty' : 'Create Faculty')

@section('content')
    @include('admin.layout.alert')

    @if (isset($id))
        {{ Form::model($faculty, ['route' => ['faculties.update', $id], 'method' => 'PUT']) }}
    @else
        {{ Form::model($faculty, ['route' => 'faculties.store', 'method' => 'post']) }}
    @endif

    <div class="form-group">
        {{ Form::label('name', 'Faculty Name') }}
        {{ Form::text('name', $faculty->name, ['class' => 'form-control', 'placeholder' => 'Enter Name']) }}
    </div>

    <div style="margin-bottom:20px">
        {{ Form::submit(isset($id) ? 'Save' : 'Create', ['class' => 'btn btn-primary']) }}
        <a href="{{ Route('faculties.index') }}" class="btn btn-default">Back</a>
    </div>

    {{ Form::close() }}

    @if (isset($id))
        {{ Form::model($faculty, ['route' => ['faculties.destroy', $faculty->id], 'method' => 'DELETE']) }}
        {{ Form::submit('Delete', ['class' => 'btn btn-danger', 'onclick' => "return confirm('Are you sure?')"]) }}
        {{ Form::close() }}
    @endif
@endsection
