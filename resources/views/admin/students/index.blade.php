@extends('admin.layout.master')

@role('admin')
    @section('title', 'Manage Students')
@section('content-title', 'Manage Students')
@else
@section('title', 'List Students')
@section('content-title', 'List Student')
@endrole

@section('content')
@include('admin.layout.alert')
@role('admin')
    <form class="search" action="{{ Route('students.index') }}" method="GET">
        <h3> <i>Search students by age</i> </h3>
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
        <h3> <i>Search students by Point</i> </h3>
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
    <div>
        <a href="{{ Route('students.create') }}" class="btn btn-success btn-sm" style="margin-bottom:20px;"><i
                class="fa fa-plus"></i></a>
    </div>
@endrole

<table class='table'>
    <thead>
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Avatar</th>
            <th>Email</th>
            <th>Faculty</th>
            <th>Point Avg</th>
            <th>Change</th>
            <th>Subjects</th>
            @role('admin')
                <th style="text-align: center">Action</th>
            @endrole
        </tr>
    </thead>
    <tbody>
        @foreach ($students as $item)
            <tr>
                <td>{{ $item->id }}</td>
                <td id="data-name-{{ $item->id }}">{{ $item->name }}</td>
                <td><img src="{{ asset('storage/images/students/' . $item->avatar) }}" alt="" width="100px">
                </td>
                <td id="data-email-{{ $item->id }}">{{ $item->email }}</td>
                <td id="data-faculty-{{ $item->id }}">{{ $item->faculty->name }}</td>

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
            <td id="data-subject-{{ $item->id }}">{{ $item->subjects->count() }} / {{ $subjects }}</td>
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
{{ Form::button('Send All', ['class' => 'btn btn-warning', 'type' => 'submit']) }}
{{ Form::close() }}
</div>
<div>
{{ $students->links() }}
</div>
{{-- modal  EDIT --}}
<div id="edit_data_Modal" class="modal fade">

<div class="modal-dialog">
    <div class="modal-content">
        <div class="modal-header">
            <div>
                <h4 class="modal-title">Edit Students</h4>
            </div>
            <div>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>

        </div>
        <div class="modal-body">
            {{ Form::model($students, ['method' => 'post', 'enctype' => 'multipart/form-data', 'id' => 'edit_form']) }}
            <label> Name Student</label>
            {!! Form::text('name', old('name'), ['class' => 'form-control', 'placeholder' => 'Enter Name', 'id' => 'name']) !!}
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
            <label> Phone Student</label>
            {!! Form::text('phone', old('phone'), [
                'class' => 'form-control',
                'placeholder' => 'Enter Phone',
                'id' => 'phone',
            ]) !!}
            <br />
            <label> Address Student</label>
            {!! Form::text('address', old('address'), [
                'class' => 'form-control',
                'placeholder' => 'Enter Address',
                'id' => 'address',
            ]) !!}
            <br />
            <label> Faculty Student</label>
            {!! Form::select('faculty_id', $faculties, null, ['class' => 'form-control', 'id' => 'faculty']) !!}
            <br />
            <label> BirthDay Student</label>
            {!! Form::date('birthday', old('birthday'), ['class' => 'form-control', 'id' => 'birthday']) !!}
            <br />
            <label> Gender Student</label>
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
            <input type="submit" name="saveEdit" id="saveEdit" value="Save" class="btn btn-success" />

            {!! Form::close() !!}
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
                    console.log(response);
                    $('#edit_data_Modal').modal('hide');
                    Swal.fire(
                        'Updated!',
                        'Update Successfully',
                        'success'
                    )
                    $('#data-gender-' + response.studentid).text(selectedGender == 1 ?
                        "Nam" : "Nữ")
                    $('#data-name-' + response.studentid).text(response.student.name)
                    $('#data-faculty-' + response.studentid).text(response.facultyName)
                }
            })
        })
    })
</script>

@endsection
