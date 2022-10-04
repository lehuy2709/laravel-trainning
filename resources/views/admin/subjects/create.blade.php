@extends('admin.layout.master')

@section('title',  __('lg.title-subjects-create'))

@section('content-title', isset($id) ? __('lg.title-subjects-update') :  __('lg.title-subjects-create'))

@section('content')
    @include('admin.layout.alert')

    @if (isset($id))
        {{ Form::model($subject, ['route' => ['subjects.update', $id], 'method' => 'PUT']) }}
    @else
        {{ Form::model($subject, ['route' => 'subjects.store', 'method' => 'post']) }}
    @endif

    <div class="form-group">
        {{ Form::label('name', __('lg.subject-name')) }}
        {{ Form::text('name', $subject->name, ['class' => 'form-control', 'placeholder' => __('lg.subject-name')    ]) }}
    </div>

    <div style="margin-bottom:20px">
        {{ Form::submit(isset($id) ?  __('lg.btn-save') :  __('lg.btn-create'), ['class' => 'btn btn-primary']) }}
        <a href="{{ Route('subjects.index') }}" class="btn btn-default">@lang('lg.btn-back')</a>
    </div>

    {{ Form::close() }}
@endsection
