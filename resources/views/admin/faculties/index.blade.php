@extends('admin.layout.master')

@section('title', 'Manage Faculty')

@section('content-title', 'Manage Faculty')

@section('content')

    @include('admin.layout.alert')

    <div>
        <a href="{{ Route('faculties.create') }}" class="btn btn-success btn-sm" style="margin-bottom:20px;"><i class="fa fa-plus"></i></a>
    </div>

    <table class='table'>
        <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($faculties as $item)
                <tr>
                    <td>{{ $item->id }}</td>
                    <td>{{ $item->name }}</td>
                    <td style="display: flex; gap:10px;">
                        <div>
                            <a href="{{ Route('faculties.edit', $item->id) }}" class="btn btn-info btn-sm"><i  class="fa fa-edit"></i></a>
                        </div>
                        {{ Form::button('<i class="fa fa-trash"></i>', ['class' => 'btn btn-danger btn-sm', 'id' => 'delete', 'data' => $item->id]) }}
                    </td>
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
                                    console.log(`response`, response);
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
