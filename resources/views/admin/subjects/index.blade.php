@extends('admin.layout.master')



@role('admin')
    @section('title', 'Manage Subjects')
@section('content-title', 'Manage Subjects')
@else
@section('title', 'List Subjects')
@section('content-title', 'List Subjects')
@endrole

@section('content')

@include('admin.layout.alert')
@role('admin')
    <div>
        <a href="{{ Route('subjects.create') }}" class="btn btn-success btn-sm" style="margin-bottom:20px;"><i
                class="fa fa-plus"></i></a>
    </div>
@endrole
<form action="{{ route('registerSubject') }}" method="post">
    @csrf
    <table class='table'>
        <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                @role('student')
                    <th>Point</th>
                    <th>Status</th>
                @endrole
                @role('student')
                <th><button class="btn btn-default btn-sm" id="check-all" type="button">Select All</button></th>
                @endrole
                @role('admin')
                <th>Action</th>
                @endrole
            </tr>
        </thead>
        <tbody>
            @foreach ($subjects as $item)
                <tr>
                    <td>{{ $item->id }}</td>
                    <td>{{ $item->name }}</td>
                    @role('admin')
                        <td style="display: flex; gap:10px;">
                            <div>
                                <a href="{{ Route('viewPoint', $item->id) }}" class="btn btn-warning btn-sm"><i
                                        class="fa fa-eye"></i></a>
                            </div>
                            <div>
                                <a href="{{ Route('subjects.edit', $item->id) }}" class="btn btn-info btn-sm"><i
                                        class="fa fa-edit"></i></a>
                            </div>
                            {{ Form::button('<i class="fa fa-trash"></i>', ['class' => 'btn btn-danger btn-sm', 'id' => 'delete', 'data' => $item->id]) }}
                        </td>
                    @endrole
                    @role('student')
                        @if ($subjectsPoint->isEmpty())
                            <td>None</td>
                            <td><span class="text-danger">haven't studied yet</span></td>
                            <td><input type="checkbox" name="regSubjects[]" value="{{ $item->id }}"></td>
                            </td>
                        @else
                            @for ($i = 0; $i < $subjectsPoint->count(); $i++)
                                @if ($item->id == $subjectsPoint[$i]->id)
                                    @if ($subjectsPoint[$i]->pivot->point == null)
                                        <td>None</td>
                                        <td><span class="text-success">Studying</span> </td>
                                        <td><input type="checkbox" name="" id="" checked disabled></td>
                                    @else
                                        <td>{{ $subjectsPoint[$i]->pivot->point }}</td>
                                        <td><span class="text-primary">Learned</span></td>
                                        <td><input type="checkbox" name="" id="" checked disabled></td>
                                    @endif
                                @break

                            @elseif($i == $subjectsPoint->count() - 1)
                                @if ($item->id !== $subjectsPoint[$i]->id)
                                    <td>None</td>
                                    <td> <span class="text-danger">haven't studied yet</span></td>
                                    <td><input type="checkbox" name="regSubjects[]" value="{{ $item->id }}"></td>
                                @endif
                            @endif
                        @endfor
                    @endif
                @endrole
            </tr>
        @endforeach
    </tbody>
</table>
@role('student')
    <div style="text-align: right;color:white">
        <button class="btn btn-success" id="register-all">Register</button>
    </div>
@endrole
</form>


<div>
{!! $subjects->links() !!}
</div>

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
                    customClass: 'swal-wide',
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
                            url: "subjects/" + id,
                            method: 'POST',
                            data: {
                                id: id,
                                _method: 'DELETE'
                            },
                            success: function(response) {
                                console.log(`response`, response);
                                Swal.fire(
                                    'Deleted!',
                                    'Deleted Success',
                                    'success'
                                )
                                _this.parent().parent().remove();
                            },
                            error: function(response) {
                                console.log(`response`, response);
                                Swal.fire({
                                    icon: 'error',
                                    customClass: 'swal-wide',
                                    title: 'Oops...',
                                    text: 'can not delete',
                                })
                            }
                        })

                    }
                })
        })
        // select all
        $("#check-all").click(function() {
            $(":checkbox").prop("checked", true);
        });

        // $("#register-all").click(function(e) {
        //     e.preventDefault()
        //     var data = []

        //     $("input:checkbox[name=regSubjects]:checked").map(function(){
        //         data.push($(this).val())
        //     })

        //     $.ajax({
        //         url: 'register-subject',
        //         method : "POST",
        //         data: {
        //             ids = check-all
        //         },


        //     })


        // });





    })
</script>
@endsection
