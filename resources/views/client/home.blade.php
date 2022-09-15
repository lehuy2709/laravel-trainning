@extends('admin.layout.master')



@section('title', 'Student')


@section('content')
    @include('admin.layout.alert')

    <!-- Top navbar -->
    <!-- Header -->

    <!-- Page content -->

    <div class="row">
        <div class="col-xl-4 order-xl-2 mb-5 mb-xl-0">
            <div class="card card-profile shadow">
                <div class="row justify-content-center">
                    <div class="col-lg-3 order-lg-2">
                        <div class="card-profile-image" style="top:20px">
                            <a href="#">
                                <img src="{{ asset('storage/images/students/' . $student->avatar) }}" class="rounded-circle"
                                    width="150px" />
                            </a>
                        </div>
                    </div>
                </div>

                <div class="card-body pt-0 pt-md-4">
                    <div class="row">
                        <div class="col">
                            <div class="card-profile-stats d-flex justify-content-center mt-md-5">
                                <div>
                                    <button type="submit" name="edit" data-toggle="modal" data-target="#edit_data_Modal"
                                        class="btn btn-primary btn-sm"><i class="fa fa-upload"> </i></button>
                                </div>
                                <div>
                                    <span class="heading">89</span>
                                    <span class="description">Comments</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="text-center">
                        <h3>
                            {{ $student->name }}<span class="font-weight-light"></span>
                        </h3>
                        <div class="h5 font-weight-300">
                            <i class="ni location_pin mr-2"></i> {{ $student->address }}
                        </div>
                        <div class="h5 mt-4">
                            <i class="ni business_briefcase-24 mr-2"></i>Student
                        </div>
                        <div>
                            <i class="ni education_hat mr-2"></i>University of Computer
                            Science
                        </div>
                        <hr class="my-4" />
                        <p>
                            Ryan — the name taken by Melbourne-raised, Brooklyn-based Nick
                            Murphy — writes, performs and records all of his own music.
                        </p>
                        <a href="#">Show more</a>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-8 order-xl-1">
            <div class="card bg-secondary shadow">
                <div class="card-header bg-white border-0">
                    <div class="row align-items-center">
                        <div class="col-8">
                            <h3 class="mb-0">My account</h3>
                        </div>
                        {{-- <div class="col-4 text-right">
                            <a href="#!" class="btn btn-sm btn-primary">Settings</a>
                        </div> --}}
                    </div>
                </div>
                <div class="card-body">
                    <form action="{{ route('updateStudent', $student->id) }}" enctype="multipart/form-data" method="POST">
                        @csrf
                        <h6 class="heading-small text-muted mb-4">User information</h6>
                        <div class="pl-lg-4">
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="form-group focused">
                                        <label class="form-control-label" for="input-username">Full Name</label>
                                        <input type="text" id="input-username"
                                            class="form-control form-control-alternative" value="{{ $student->name }}"
                                            readonly />
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label class="form-control-label" for="input-email">Email
                                            address</label>
                                        <input type="email" id="input-email" class="form-control form-control-alternative"
                                            value="{{ $student->email }}" readonly />
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group focused">
                                        <label class="form-control-label" for="input-username">Avatar</label>
                                        <input type="file" id="input-username"
                                            class="form-control form-control-alternative" name="avatar" />
                                    </div>
                                    @error('avatar')
                                        <div class="text-danger">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <hr class="my-4" />
                        <!-- Address -->
                        <h6 class="heading-small text-muted mb-4">
                            Contact information
                        </h6>
                        <div class="pl-lg-4">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group focused">
                                        <label class="form-control-label" for="input-address">Address</label>
                                        <input id="input-address" class="form-control form-control-alternative"
                                            value="{{ $student->address }}" type="text" readonly />
                                    </div>
                                </div>
                            </div>
                        </div>
                        <hr class="my-4" />
                        <!-- Description -->
                        <div style="text-align: right">
                            <button href="#!" class="btn btn-primary">Save</button>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>

    <div id="edit_data_Modal" class="modal fade">

        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <div>
                        <h4 class="modal-title">Change Avatar</h4>
                    </div>
                    <div>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>

                </div>
                <div class="modal-body">

                    <form action="" method="post" enctype="multipart/form-data" class="mr-auto p-2" id="edit_form">
                        @csrf
                        <div class="form-group">
                            <label class="filebutton">
                                <span><input type="file" id="myfile" name="avatar" style=""
                                        class="form-control form-control-sm"></span>
                            </label>
                            <button type="submit" class="btn btn-primary btn-lg">Change</button>
                        </div>
                    </form>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default btn-sm" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.1/jquery.min.js" integrity="sha512-aVKKRRi/Q/YV+4mjoKBsE4x3H+BkegoM/em46NNlCqNTmUYADjBbeNefNxYV7giUp0VxICtqdrbqU7iVaeZNXA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script>
        $(document).ready(function() {


            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $('#edit_form').submit(function(e) {
                e.preventDefault();
                // console.log(new FormData(this)
                // console.log(form);

                $.ajax({
                    url: "{{ route('changeAvatar') }}",
                    type: 'POST',
                    dataType: 'JSON',
                    processData: false,
                    contentType: false,
                    data: {
                        data: new FormData(this),
                    },
                    success: function(response) {
                        console.log(response);

                    }
                })
            })



        })
    </script>


@endsection
