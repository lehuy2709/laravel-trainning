@extends('admin.layout.master')

@section('title', __('lg.title-students-create'))

@section('content-title', __('lg.title-students-create'))

@section('content')
    {{ Form::model($students, ['route' => 'students.store', 'method' => 'post', 'enctype' => 'multipart/form-data']) }}

    <div class="form-group">
        <label for="exampleInputEmail1">@lang('lg.student-name')</label>
        {!! Form::text('name', old('name'), ['class' => 'form-control', 'placeholder' =>  __('lg.student-name')]) !!}
    </div>

    @error('name')
        <div class="text-danger">
            {{ $message }}
        </div>
    @enderror

    {{-- <div class="form-group">
        <label for="exampleInputEmail1">Faculty</label>
        {!! Form::select('faculty_id', $faculties, null, ['class' => 'form-control']) !!}
    </div> --}}

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
        <label for="exampleInputEmail1">@lang('lg.student-phone')</label>
        {!! Form::text('phone', old('phone'), ['class' => 'form-control', 'placeholder' => __('lg.student-phone')]) !!}
    </div>
    @error('phone')
        <div class="text-danger">
            {{ $message }}
        </div>
    @enderror

    <div class="form-group">
        <label for="exampleInputEmail1">@lang('lg.student-avatar')</label>
        {!! Form::file('avatar', ['class' => 'form-control']) !!}
    </div>
    @error('avatar')
        <div class="text-danger">
            {{ $message }}
        </div>
    @enderror

    <div class="form-group">
        <label for="exampleInputEmail1">@lang('lg.student-gender')</label>
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
        <label for="exampleInputEmail1">@lang('lg.student-address')</label>
        {!! Form::text('address', old('address'), ['class' => 'form-control', 'placeholder' => __('lg.student-address')]) !!}
    </div>
    @error('address')
        <div class="text-danger">
            {{ $message }}
        </div>
    @enderror

    <div class="form-group">
        <label for="exampleInputEmail1">@lang('lg.student-birhday')</label>
        {!! Form::date('birthday', old('birthday'), ['class' => 'form-control']) !!}
    </div>
    @error('birthday')
        <div class="text-danger">
            {{ $message }}
        </div>
    @enderror

    <div style="margin-bottom:20px">
        {!! Form::submit(__('lg.btn-create'), ['class' => 'btn btn-primary']) !!}
        <a href="{{ Route('students.index') }}" class="btn btn-default">@lang('lg.btn-back')</a>
    </div>

    {!! Form::close() !!}
@endsection
