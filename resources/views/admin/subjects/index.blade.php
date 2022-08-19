@extends('admin.layout.master')

@section('title', 'Manage Subjects')

@section('content-title', 'Manage Subjects')

@section('content')
    @include('admin.layout.alert')
    <div>
        <a href="{{ Route('subjects.create') }}" class="btn btn-success" style="margin-bottom:20px;">Create</a>
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

            @foreach ($subjects as $item)
                <tr>
                    <td>{{ $item->id }}</td>
                    <td>{{ $item->name }}</td>
                    <td style="display: flex; gap:10px;">

                        {!! Form::button('Delete', ['class' => 'btn btn-danger', 'id' => 'delete', 'data' => $item->id]) !!}

                        <div>
                            <a href="{{ Route('subjects.edit', $item->id) }}" class="btn btn-info">Edit</a>
                        </div>


                    </td>
                </tr>
            @endforeach



        </tbody>
    </table>
    <div>
        {!! $subjects->links() !!}
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
