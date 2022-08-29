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
    <div>
        <a href="{{ Route('students.create') }}" class="btn btn-success" style="margin-bottom:20px;">Create</a>
    </div>
    @endrole

    <table class='table'>
        <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Avatar</th>
                <th>Gender</th>
                <th>Email</th>
                <th>Faculty</th>
                @role('admin')
                <th>Action</th>
                @endrole
            </tr>
        </thead>
        <tbody>
            @foreach ($students as $item)
                <tr>
                    <td>{{ $item->id }}</td>
                    <td>{{ $item->name }}</td>
                    <td><img src="{{ asset('storage/images/students/' . $item->avatar) }}" alt="" width="100px"></td>
                    <td>{{ $item->gender == 1 ? 'Nam' : 'Nữ' }}</td>
                    <td>{{ $item->email }}</td>
                    <td>{{ $item->faculty->name }}</td>
                    @role('admin')
                    <td style="display: flex; gap:10px;">

                        {!! Form::button('Delete', ['class' => 'btn btn-danger', 'id' => 'delete', 'data' => $item->id]) !!}

                        <div>
                            <button type="button" class="btn btn-info" name="edit" id="edit" data-toggle="modal"
                                data-target="#edit_data_Modal" data-id="{{ $item->id }}"> Edit </button>
                        </div>


                    </td>
                    @endrole
                </tr>
            @endforeach



        </tbody>
    </table>
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
                    {!! Form::text('name', old('name'), ['class' => 'form-control', 'placeholder' => 'Enter Name']) !!}
                    <br />
                    <label> Email Student</label>
                    {!! Form::text('email', old('email'), ['class' => 'form-control', 'placeholder' => 'Enter Email']) !!}
                    <br />
                    <label> Phone Student</label>
                    {!! Form::text('phone', old('phone'), ['class' => 'form-control', 'placeholder' => 'Enter Phone']) !!}
                    <br />
                    <label> Address Student</label>
                    {!! Form::text('address', old('address'), ['class' => 'form-control', 'placeholder' => 'Enter Address']) !!}
                    <br />
                    <label> Faculty Student</label>
                    {!! Form::select('faculty_id', ['demo' => 'avc'], null, ['class' => 'form-control']) !!}
                    <br />
                    <label> Avatar Student</label>
                    {!! Form::file('avatar', ['class' => 'form-control']) !!}
                    <br />
                    <label> BirthDay Student</label>
                    {!! Form::date('birthday', old('birthday'), ['class' => 'form-control']) !!}
                    <br />
                    <label> Gender Student</label>
                    {!! Form::date('birthday', old('birthday'), ['class' => 'form-control']) !!}
                    <br />
                    <input type="submit" name="edit" id="edit" value="Save" class="btn btn-success" />

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
            // delete
            $(document).on('click', '#delete', function() {
                var id = $(this).attr('data');

                Swal.fire({
                        title: 'Are you sure?',
                        text: "Are you sure?",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
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
                                method: 'POST',
                                data: {
                                    id: id,
                                    _method: 'DELETE'
                                },
                                success: function(response) {
                                    Swal.fire(
                                        'Deleted!',
                                        'Deleted Success',
                                        'success'
                                    )
                                    setTimeout((function() {
                                        window.location.reload();
                                    }), 1000);

                                }
                            })

                        }
                    })
            })

            // edit

            $('#edit').click(function(e) {
                var id = $(this).attr('data-id');
                console.log(`id`, id);
                $.ajax({
                    url: 'students/'+id+'/edit',
                    method: 'GET',
                    data: {

                    },
                    dataType:"json",
                    success: function(response) {
                        console.log(`response`, response);
                    }
                })


                 // $.ajax({
                //     url: '',
                //     method: 'POST',
                //     data: {
                //         name: name,
                //         slug: slug,
                //         icon: icon
                //     },
                //     success: function(response) {
                //         Swal.fire({
                //             position: 'center',
                //             icon: 'success',
                //             title: 'Thêm thành công',
                //             showConfirmButton: false,
                //             timer: 700
                //         })
                //         $('#add_data_Modal').modal('hide')
                //         setTimeout((function() {
                //             window.location.reload();
                //         }), 1000);
                //     }
                // })

            })
        })
    </script>

@endsection
