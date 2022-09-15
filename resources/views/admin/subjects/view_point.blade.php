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
                <td>
                    <div>
                        <a href="{{ Route('exportPoint', $id) }}" class="btn btn-warning btn-sm"><i class="fa fa-download"></i></a>
                    </div>
                </td>

            </tr>
        </tfoot>
    </table>


@endsection
