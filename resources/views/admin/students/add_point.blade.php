@extends('admin.layout.master')

@section('title', 'Point Students')
@section('content-title', 'Update Point Students')

@section('content')
    @include('admin.layout.alert')


    <div class="card-header py-3">
        <h3 class="m-1 font-weight-bold text-primary">Register the subject</h3>
        <h4 class="m-1 text-dark">Student: {{ $student->name }} </h4>
        <div class="float-left m-1">
            <button class="btn btn-success" id="addmore" href="">Add More</button>
        </div>
        <div class="float-right m-1">
            <a class="btn btn-default" href="{{ Route('students.index') }}">Back</a>
        </div>
    </div>

    <div class="card-body">
        <form action="" method="post">
            @csrf
            <table class="table table-bordered">
                <thead>
                    <tr>

                        <th style="text-align: center">Subject</th>
                        <th style="text-align: center">Point</th>
                        <th style="text-align: center">#</th>
                    </tr>
                </thead>

                <tbody id="formadd">
                    <tr id="tr-point">
                        <td>
                            <select name="subject" id="" class="form-control">
                                @foreach ($subjects as $value)
                                    <option value="{{ $value->id }}">{{ $value->name }}</option>
                                @endforeach
                            </select>
                        </td>
                        <td id="td-point">
                            <input type="text" name="point" id="" value="" class="form-control">
                        </td>
                        <td>
                            <button class="btn btn-danger">Delete</button>
                        </td>
                    </tr>
                </tbody>
            </table>
            <button type="submit" class="btn btn-info">Save</button>
        </form>
    </div>

    <script>
        $(document).ready(function() {

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

            $("#addmore").click(function() {

                $('#formadd').append(
                    `
                    <tr id="tr-point">
                        <td>
                            <select name="subject" id="" class="form-control">
                                @foreach ($subjects as $value)
                                    <option value="{{ $value->id }}">{{ $value->name }}</option>
                                @endforeach
                            </select>
                        </td>
                        <td id="td-point">
                            <input type="text" name="point" id="" value="" class="form-control">
                        </td>
                        <td>
                            <button class="btn btn-danger">Delete</button>
                        </td>
                    </tr>
                    `)
                    var a = $('select[name="subject"]')
                    console.log(a.length);
                    for(i=0;i<a.length;i++){
                        console.log(a[i]);
                    }
                    if(a.length>0){
                        a[i].onchange = function(){
                        alert('aaa')
                    }

                    }

                });

                $('select[name="subject"]').change(function(e) {
                    e.preventDefault()
                let value = $(this).val();
                let idStudent = {{ $student->id}};
                $.ajax({
                    url: "{{ route('getValueSubject',"value") }}",
                    method: 'GET',
                    data: {
                        idSubject : value,
                        idStudent:idStudent
                    },
                    success: function(data) {
                        data.data.map(function(res){
                            if(res.pivot.subject_id == data.subject_id){
                                $('input[name="point"]').val(res.pivot.point)
                            }
                        })
                    }
                });

            });








        });


    </script>


@endsection
