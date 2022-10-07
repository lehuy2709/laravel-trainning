@extends('admin.layout.master')

@section('title')
    @lang('lg.title-facutiles-create')
@endsection

@section('content-title')
    @if (isset($id))
        @lang('lg.title-facutiles-update')
    @else
        @lang('lg.title-facutiles-create')
    @endif
@endsection

@section('content')
    @include('admin.layout.alert')

    @if (isset($id))
        {{ Form::model($faculty, ['route' => ['faculties.update', $id], 'method' => 'PUT']) }}
    @else
        {{ Form::model($faculty, ['route' => 'faculties.store', 'method' => 'post']) }}
    @endif

    <div class="form-group">
        {{ Form::label('name', __('lg.facu-name')) }}
        {{ Form::text('name', $faculty->name, ['class' => 'form-control', 'placeholder' => __('lg.facu-name')]) }}
    </div>

    <div style="margin-bottom:20px">
        {{ Form::submit(isset($id) ? __('lg.btn-save') : __('lg.btn-create'), ['class' => 'btn btn-primary']) }}
        <a href="{{ Route('faculties.index') }}" class="btn btn-default">@lang('lg.btn-back')</a>
    </div>

    {{ Form::close() }}

    @if (isset($id))
        {{ Form::model($faculty, ['route' => ['faculties.destroy', $faculty->id], 'method' => 'DELETE']) }}
        {{ Form::submit(__('lg.btn-delete'), ['class' => 'btn btn-danger', 'onclick' => "return confirm('Are you sure?')"]) }}
        {{ Form::close() }}
    @endif
@endsection
