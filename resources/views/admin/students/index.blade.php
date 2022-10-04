@extends('admin.layout.master')

@role('admin')
    @section('title', __('lg.title-students'))
@section('content-title', __('lg.title-students'))
@else
@section('title', 'List Students')
@section('content-title', 'List Student')
@endrole

@section('content')
@include('admin.layout.alert')
@role('admin')
    <form class="search" action="{{ Route('students.index') }}" method="GET">
        <h3> <i>@lang('lg.search-age')</i> </h3>
        <div class="input-group">
            <div class="form-group" style="margin-right:10px">
                <input type="search" name="fromAge" id="form1" placeholder="From Age" class="form-control" />
            </div>
            <div class="form-group" style="margin:0 10px;">
                <input type="search" name="toAge" id="form1" placeholder="To Age" class="form-control" />
            </div>
            <div class="form-group" style="margin:0 10px;">
                <button type="submit" class="btn btn-info">
                    <i class="fas fa-search"></i>
                </button>
            </div>

        </div>
    </form>
    <form class="search" action="{{ Route('students.index') }}" method="GET">
        <h3> <i>@lang('lg.search-point')</i> </h3>
        <div class="input-group">
            <div class="form-group" style="margin-right:10px">
                <input type="search" name="fromPoint" id="form1" placeholder="From Point" class="form-control" />
            </div>
            <div class="form-group" style="margin:0 10px;">
                <input type="search" name="toPoint" id="form1" placeholder="To Point" class="form-control" />
            </div>
            <div class="form-group" style="margin:0 10px;">
                <button type="submit" class="btn btn-info">
                    <i class="fas fa-search"></i>
                </button>
            </div>

        </div>
    </form>
    <div style="display:flex; gap:10px">
        <div>
            <a href="{{ Route('students.create') }}" class="btn btn-success btn-sm" style="margin-bottom:20px;"><i
                    class="fa fa-plus"></i></a>
        </div>
        <div>
            <button class="btn btn-success btn-sm" data-toggle="modal"
                data-target="#add_data_Modal">@lang('lg.btn-quick-add')</button>
        </div>
    </div>
@endrole

<table class='table'>
    <thead>
        <tr>
            <th>ID</th>
            <th>@lang('lg.student-name')</th>
            <th>@lang('lg.student-avatar')</th>
            <th>Email</th>
            <th>@lang('lg.facu-name')</th>
            <th>@lang('lg.student-avg')</th>
            <th>@lang('lg.student-detail')</th>
            <th colspan="2">@lang('lg.count-subject')</th>
            @role('admin')
                <th style="text-align: center">@lang('lg.action')</th>
            @endrole
        </tr>
    </thead>
    <tbody>
        @foreach ($students as $item)
            <tr>
                <td>{{ $item->id }}</td>
                <td id="data-name-{{ $item->id }}">{{ $item->name }}</td>
                <td><img src="{{ asset('storage/images/students/' . $item->avatar) }}" alt="" width="50px">
                </td>
                <td id="data-email-{{ $item->id }}">{{ $item->email }}</td>
                @if ($item->faculty)
                    <td id="data-faculty-{{ $item->id }}">{{ $item->faculty->name }}</td>
                @else
                    <td id="data-faculty-{{ $item->id }}">Unregistered</td>
                @endif
                @if ($item->subjects->count() != $subjects)
                    <td>Studying</td>
                @else
                    @for ($i = 0; $i < $subjects; $i++)
                        @if (!$item->subjects[$i]->pivot->point)
                            <td>Studying</td>
                        @break

                    @elseif($i == $subjects - 1)
                        <td id="data-point-{{ $item->id }}">
                            {{ round($item->subjects->avg('pivot.point'), 2) }}
                        </td>
                    @endif
                @endfor
            @endif
            <td>
                {{ Form::model($students, ['route' => ['updatePoint', $item->id], 'method' => 'GET']) }}
                {{ Form::button('<i class="fa fa-eye" style="color: white"></i>', ['class' => 'btn btn-success btn-sm edit', 'type' => 'submit']) }}
                {{ Form::close() }}
            </td>
            <td colspan="2" id="data-subject-{{ $item->id }}">{{ $item->subjects->count() }} /
                {{ $subjects }} <button class="btn btn-primary btn-sm detail" name="detail"
                    data-toggle="modal" data-target="#detail_data_Modal" data-id="{{ $item->id }}"><i
                        class="fa fa-info-circle" style="color: white"></i></button></td>
            @role('admin')
                <td style="display: flex; gap:10px;">
                    @if ($item->subjects->count() !== $subjects)
                        {{ Form::model($students, ['route' => ['sendMail', $item->id], 'method' => 'post']) }}
                        {{ Form::button('<i class="fa fa-bell" style="color: white"></i>', ['class' => 'btn btn-warning btn-sm', 'type' => 'submit']) }}
                        {{ Form::close() }}
                    @endif
                    <div>
                        <a class="btn btn-info btn-sm edit" name="edit" data-toggle="modal"
                            data-target="#edit_data_Modal" data-id="{{ $item->id }}"><i class="fa fa-edit"
                                style="color: white"></i></a>
                    </div>
                    {{ Form::button('<i class="fa fa-trash"></i>', ['class' => 'btn btn-danger btn-sm', 'id' => 'delete', 'data' => $item->id]) }}

                </td>
            @endrole
        </tr>
    @endforeach
</tbody>
</table>
<div style="margin-bottom:20px">
{{ Form::model($students, ['route' => ['sendMailAll'], 'method' => 'post']) }}
{{ Form::button(__('lg.btn-send-all'), ['class' => 'btn btn-warning', 'type' => 'submit']) }}
{{ Form::close() }}
</div>
<div>
@if ($students != [])
    {{ $students->links() }}
@endif
</div>
{{-- modal  EDIT --}}
<div id="edit_data_Modal" class="modal fade">

<div class="modal-dialog">
    <div class="modal-content">
        <div class="modal-header">
            <div>
                <h4 class="modal-title">@lang('lg.title-students-update')</h4>
            </div>
            <div>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>

        </div>
        <div class="modal-body">
            {{ Form::model($students, ['method' => 'post', 'enctype' => 'multipart/form-data', 'id' => 'edit_form']) }}
            <label> @lang('lg.student-name')</label>
            {!! Form::text('name', old('name'), [
                'class' => 'form-control',
                'placeholder' => __('lg.student-name'),
                'id' => 'name',
            ]) !!}
            <div>
                <label class="text-danger" id="edit_error_name" style="display: none"></label>
            </div>
            <br />
            <label> Email Student</label>
            {!! Form::text('email', old('email'), [
                'class' => 'form-control',
                'placeholder' => 'Enter Email',
                'id' => 'email',
                'readonly',
                'disabled',
            ]) !!}
            <br />
            <label> @lang('lg.student-phone')</label>
            {!! Form::text('phone', old('phone'), [
                'class' => 'form-control',
                'placeholder' => __('lg.student-phone'),
                'id' => 'phone',
            ]) !!}
            <div>
                <label class="text-danger" id="edit_error_phone" style="display: none"></label>
            </div>
            <br />
            <label> @lang('lg.facu-name')</label>
            {!! Form::select('faculty_id', $faculties, null, ['class' => 'form-control', 'id' => 'faculty']) !!}
            <br />
            <label> @lang('lg.student-address')</label>
            {!! Form::text('address', old('address'), [
                'class' => 'form-control',
                'placeholder' => __('lg.student-address'),
                'id' => 'address',
            ]) !!}
            <div>
                <label class="text-danger" id="edit_error_address" style="display: none"></label>
            </div>
            <br />
            <label> @lang('lg.student-birhday')</label>
            {!! Form::date('birthday', old('birthday'), ['class' => 'form-control', 'id' => 'birthday']) !!}
            <div>
                <label class="text-danger" id="edit_error_birthday" style="display: none"></label>
            </div>
            <br />
            <label> @lang('lg.student-gender')</label>
            <div class="form-group">
                <div class="form-check">
                    {!! Form::radio('gender', '1', true, ['id' => 'gender']) !!}
                    <label class="form-check-label" for="exampleRadios1">
                        Nam
                    </label>
                </div>
                <div class="form-check">
                    {!! Form::radio('gender', '2', true, ['id' => 'gender']) !!}
                    <label class="form-check-label" for="exampleRadios2">
                        Nữ
                    </label>
                </div>
            </div>
            <br />
            <input type="submit" name="saveEdit" id="saveEdit" value="@lang('lg.btn-save')"
                class="btn btn-success" />

            {!! Form::close() !!}
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">@lang('lg.btn-close')</button>
        </div>
    </div>
</div>
</div>
{{-- end modal --}}

{{-- modal create --}}
<div id="add_data_Modal" class="modal fade">

<div class="modal-dialog">
    <div class="modal-content">
        <div class="modal-header">
            <div>
                <h4 class="modal-title">@lang('lg.student-quick-add')</h4>
            </div>
            <div>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>

        </div>
        <div class="modal-body">
            {{ Form::open(['method' => 'post', 'enctype' => 'multipart/form-data', 'id' => 'create_form']) }}
            <label> @lang('lg.student-name')</label>
            {!! Form::text('name', old('name'), [
                'class' => 'form-control',
                'placeholder' => __('lg.student-name'),
                'id' => 'quickName',
            ]) !!}
            <div>
                <label class="text-danger" id="error_name" style="display: none"></label>
            </div>

            <br />
            <label> Email Student</label>
            {!! Form::text('email', old('email'), [
                'class' => 'form-control',
                'placeholder' => 'Enter Email',
                'id' => 'quickEmail',
            ]) !!}
            <div>
                <label class="text-danger" id="error_email" style="display: none"></label>
            </div>
            <br />
            <label> @lang('lg.student-birhday')</label>
            {!! Form::date('birthday', old('birthday'), ['class' => 'form-control', 'id' => 'quickBirthDay']) !!}
            <div>
                <label class="text-danger" id="error_birthday" style="display: none"></label>
            </div>
            <br />
            <label>@lang('lg.student-phone')</label>
            {!! Form::text('phone', old('phone'), [
                'class' => 'form-control',
                'placeholder' => __('lg.student-phone'),
                'id' => 'quickPhone',
            ]) !!}
            <div>
                <label class="text-danger" id="error_phone" style="display: none"></label>
            </div>
            <br />
            <label> @lang('lg.student-gender')</label>
            <div class="form-group">
                <div class="form-check">
                    {!! Form::radio('genderQuick', '1', true, ['id' => 'genderQuick']) !!}
                    <label class="form-check-label" for="exampleRadios1">
                        Nam
                    </label>
                </div>
                <div class="form-check">

                </div>

                <div class="form-check">
                    {!! Form::radio('genderQuick', '2', true, ['id' => 'genderQuick']) !!}
                    <label class="form-check-label" for="exampleRadios2">
                        Nữ
                    </label>
                </div>
            </div>
            <br />
            <input type="submit" name="saveCreate" id="saveCreate" value="@lang('lg.btn-quick-add')"
                class="btn btn-success" />

            {!! Form::close() !!}
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">@lang('lg.btn-close')</button>
        </div>
    </div>
</div>
</div>
{{-- end modal --}}


{{-- modal detail --}}

<div id="detail_data_Modal" class="modal fade">

<div class="modal-dialog">
    <div class="modal-content">
        <div class="modal-header">
            <div>
                <h4 class="modal-title">@lang('lg.std-subject-detail')</h4>
            </div>
            <div>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>

        </div>
        <div class="modal-body">
            <form id="updateForm">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">@lang('lg.subject-name')</th>
                            <th scope="col">@lang('lg.student-point')</th>
                        </tr>
                    </thead>
                    <tbody id="target">

                    </tbody>

                </table>
            </form>

        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
    </div>
</div>
</div>


{{-- end modal --}}


<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    $(document).ready(function() {
        // setup
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        // delete
        $(document).on('click', '#delete', function() {
            var id = $(this).attr('data');
            var _this = $(this);

            Swal.fire({
                    title: 'Are you sure?',
                    text: "Are you sure?",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    customClass: 'swal-wide',
                    confirmButtonText: 'Yes, delete it!'
                })
                .then((result) => {
                    if (result.isConfirmed) {
                        $.ajaxSetup({
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            }
                        });
                        $.ajax({
                            url: "students/" + id,
                            type: 'DELETE',
                            data: {
                                id: id,
                            },
                            success: function(response) {
                                Swal.fire(
                                    'Deleted!',
                                    'Deleted Success',
                                    'success'
                                )
                                console.log(response);
                                _this.parent().parent().remove();
                            },
                        })

                    }
                })
        })
        // edit
        var id = ''
        $(document).on('click', '.edit', function(e) {
            id = $(this).attr('data-id');
            $.ajax({
                url: 'students/' + id + '/edit',
                type: 'GET',
                data: {
                    id: id,
                    _method: 'GET'
                },
                success: function(response) {
                    $("#name").val(response.data.name)
                    $("#email").val(response.data.email)
                    $("#phone").val(response.data.phone)
                    $("#address").val(response.data.address)
                    $("#faculty").val(response.data.faculty_id)
                    $("#birthday").val(response.data.birthday)
                    if (response.data.gender == 1) {
                        $('input[name=gender][value=1]').prop('checked', true);
                    } else {
                        $('input[name=gender][value=2]').prop('checked', true);
                    }
                }
            })
        })

        $('#edit_form').submit(function(e) {
            var genders = $('[name="gender"]')
            for (var i = 0; i < genders.length; i++) {
                if (genders[i].checked) {
                    selectedGender = genders[i].value;
                }
            }
            e.preventDefault();
            $.ajax({
                url: 'students/' + id,
                type: 'PUT',
                dataType: 'json',
                data: {
                    _method: 'PUT',
                    name: $("#name").val(),
                    phone: $("#phone").val(),
                    address: $("#address").val(),
                    faculty_id: $("#faculty").val(),
                    birthday: $("#birthday").val(),
                    gender: selectedGender,
                },
                success: function(response) {
                    $('#edit_data_Modal').modal('hide');
                    Swal.fire(
                        'Updated!',
                        'Update Successfully',
                        'success'
                    )
                    $('#data-gender-' + response.studentid).text(selectedGender == 1 ?
                        "Nam" : "Nữ")
                    $('#data-name-' + response.studentid).text(response.student.name)
                    if (response.facultyName) {
                        $('#data-faculty-' + response.studentid).text(response.facultyName)
                    }

                },
                error: function(response) {
                    if (response.status == 422) {
                        if (response.responseJSON.errors.name) {
                            $('#edit_error_name').text(response.responseJSON.errors.name[0])
                            $('#edit_error_name').css('display', 'block')
                        } else {
                            $('#edit_error_name').css('display', 'none')
                        }
                        if (response.responseJSON.errors.phone) {
                            $('#edit_error_phone').text(response.responseJSON.errors.phone[
                                0])
                            $('#edit_error_phone').css('display', 'block')
                        } else {
                            $('#edit_error_phone').css('display', 'none')
                        }
                        if (response.responseJSON.errors.address) {
                            $('#edit_error_address').text(response.responseJSON.errors
                                .address[0])
                            $('#edit_error_address').css('display', 'block')
                        } else {
                            $('#edit_error_address').css('display', 'none')
                        }
                        if (response.responseJSON.errors.birthday) {
                            $('#edit_error_birthday').text(response.responseJSON.errors
                                .birthday[0])
                            $('#edit_error_birthday').css('display', 'block')
                        } else {
                            $('#edit_error_birthday').css('display', 'none')
                        }
                    }
                }
            })
        })

        // create
        $('#create_form').submit(function(e) {
            e.preventDefault()
            var genders = $('[name="genderQuick"]')
            for (var i = 0; i < genders.length; i++) {
                if (genders[i].checked) {
                    selectedGender = genders[i].value;
                }
            }
            $.ajax({
                url: "{{ route('quickAdd') }}",
                type: 'post',
                dataType: 'json',
                data: {
                    _method: 'post',
                    gender: selectedGender,
                    name: $('#quickName').val(),
                    email: $('#quickEmail').val(),
                    phone: $('#quickPhone').val(),
                    birthday: $('#quickBirthDay').val()
                },
                success: function(response) {
                    Swal.fire(
                        'Created!',
                        'Create Successfully',
                        'success'
                    )
                    $('#add_data_Modal').modal('hide')

                    setTimeout((function() {
                        window.location.reload();
                    }), 1000);
                },
                error: function(response) {
                    if (response.status == 422) {
                        if (response.responseJSON.errors.name) {
                            $('#error_name').text(response.responseJSON.errors.name[0])
                            $('#error_name').css('display', 'block')
                        } else {
                            $('#error_name').css('display', 'none')
                        }
                        if (response.responseJSON.errors.email) {
                            $('#error_email').text(response.responseJSON.errors.email[0])
                            $('#error_email').css('display', 'block')
                        } else {
                            $('#error_email').css('display', 'none')
                        }
                        if (response.responseJSON.errors.phone) {
                            $('#error_phone').text(response.responseJSON.errors.phone[0])
                            $('#error_phone').css('display', 'block')
                        } else {
                            $('#error_phone').css('display', 'none')
                        }
                        if (response.responseJSON.errors.birthday) {
                            $('#error_birthday').text(response.responseJSON.errors.birthday[
                                0])
                            $('#error_birthday').css('display', 'block')
                        } else {
                            $('#error_birthday').css('display', 'none')
                        }
                    }
                }
            })
        })

        // details
        var idStd = ''
        $(document).on('click', '.detail', function(e) {
            idStd = $(this).attr('data-id');
            $.ajax({
                url: 'student/' + idStd + '/subject-detail',
                type: 'GET',
                success: function(response) {
                    $('#target').html(response)
                }
            })
        })
        // update point
        $('#updateForm').submit(function(e) {
            e.preventDefault()
            var dataPoint = [];
            var point = $("input[name='point']");
            for (i = 0; i < point.length; i++) {
                dataPoint.push(point[i].value)
            }
            $.ajax({
                url: 'student/' + idStd + '/point',
                type: 'put',
                dataType: 'json',
                data: {
                    id: idStd,
                    dataPoint: dataPoint,
                },
                success: function(response) {
                    Swal.fire(
                        'Updated!',
                        response.success,
                        'success'
                    )
                    $('#add_data_Modal').modal('hide')

                    setTimeout((function() {
                        window.location.reload();
                    }), 1000);
                }
            })

        })


    })
</script>
@endsection
