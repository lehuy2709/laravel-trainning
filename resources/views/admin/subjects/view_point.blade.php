@extends('admin.layout.master')

@section('title', 'Manage Point')
@section('content-title', 'Manage Point')


@section('content')

    @include('admin.layout.alert')
    <table class='table'>
        <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Point</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($subject_point as $item)
                @foreach ($item->students as $value)
                    <tr>
                        <td>{{ $value->id }}</td>
                        <td>{{ $value->name }}</td>
                        <td>{{ $value->pivot->point }}</td>
                    </tr>
                @endforeach
            @endforeach
        </tbody>
        <tfoot>
            <tr>
                <td colspan="4">
                    <div class="flex-two">
                        <div>
                            <a href="{{ Route('exportPoint', $id) }}" class="btn btn-warning btn-sm"><i
                                    class="fa fa-download"></i></a>
                        </div>

                        <div>
                            <button type="submit" name="edit" data-toggle="modal" data-target="#edit_data_Modal"
                                class="btn btn-primary btn-sm"><i class="fa fa-upload"> </i></button>
                        </div>

                    </div>
                </td>

            </tr>
        </tfoot>
    </table>

    <div id="edit_data_Modal" class="modal fade">

        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <div>
                        <h4 class="modal-title">Import Points</h4>
                    </div>
                    <div>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>

                </div>
                <div class="modal-body">
                    <form action="{{ route('importPoint', $id) }}" method="post" enctype="multipart/form-data"
                        class="mr-auto p-2">
                        @csrf
                        <div class="form-group">
                            <label class="filebutton">
                                <span><input type="file" id="myfile" name="myfile" style=""
                                        class="form-control form-control-sm"></span>
                            </label>
                            <button type="submit" class="btn btn-primary btn-lg">Import</button>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default btn-sm" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

@endsection
