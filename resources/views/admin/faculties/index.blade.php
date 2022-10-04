@extends('admin.layout.master')



@role('admin')
    @section('title')
        @lang('lg.title-faculties')
    @endsection
    @section('content-title')
        @lang('lg.title-faculties')
    @endsection
@else
    @section('title', __('lg.student-list-faculty'))
@section('content-title', __('lg.student-list-faculty'))
@endrole

@section('content')

@include('admin.layout.alert')
@role('admin')
    <div>
        <a href="{{ Route('faculties.create') }}" class="btn btn-success btn-sm" style="margin-bottom:20px;"><i
                class="fa fa-plus"></i></a>
    </div>
@endrole
<table class='table'>
    <thead>
        <tr>
            <th>ID</th>
            <th>@lang('lg.facu-name')</th>
            @role('admin')
                <th>@lang('lg.action')</th>
            @endrole
            @role('student')
                @if (!$stdFaculty->faculty_id)
                    <th>@lang('lg.action')</th>
                @else
                    <th>@lang('lg.status')</th>
                @endif
            @endrole
        </tr>
    </thead>
    <tbody>
        @foreach ($faculties as $item)
            <tr>
                <td>{{ $item->id }}</td>
                <td>{{ $item->name }}</td>
                @role('admin')
                    <td style="display: flex; gap:10px;">
                        <div>
                            <a href="{{ Route('faculties.edit', $item->id) }}" class="btn btn-info btn-sm"><i
                                    class="fa fa-edit"></i></a>
                        </div>
                        {{ Form::button('<i class="fa fa-trash"></i>', ['class' => 'btn btn-danger btn-sm', 'id' => 'delete', 'data' => $item->id]) }}
                    </td>
                @endrole
                @role('student')
                    @if (!$stdFaculty->faculty_id)
                        <td>
                            {{ Form::open(['route' => ['registerFaculty', $item->id], 'method' => 'put']) }}
                            {{ Form::button('<i class="fa fa-plus" style="color: white"></i>', ['class' => 'btn btn-success btn-sm', 'type' => 'submit']) }}
                            {{ Form::close() }}
                        </td>
                    @else
                        <td><span class="badge bg-info">Registed</span></td>
                    @break
                @endif
            @endrole
        </tr>
    @endforeach
</tbody>
</table>

<div>
{!! $faculties->links() !!}
</div>

<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    $(document).ready(function() {
        $(document).on('click', '#delete', function() {
            var id = $(this).attr('data');

            Swal.fire({
                    title: 'Are you sure?',
                    text: "Are you sure?",
                    icon: 'warning',
                    customClass: 'swal-wide',
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
                            url: "faculties/" + id,
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
    })
</script>
@endsection
