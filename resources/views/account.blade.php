@extends('layouts.layout')
@section('contant')
    <section class="section-5 bg-2">
        <div class="container py-5">
            <div class="row">
                <div class="col">
                    <nav aria-label="breadcrumb" class=" rounded-3 p-3 mb-4">
                        <ol class="breadcrumb mb-0">
                            <li class="breadcrumb-item"><a href="{{ url('/') }}">Home</a></li>
                            <li class="breadcrumb-item active">Account Settings</li>
                        </ol>
                    </nav>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-3">
                    @include('sidebar')
                </div>
                <div class="col-lg-9">

                    @if (Session::has('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            {{ session()->get('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif
                    @if (Session::has('error'))
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            {{ session()->get('error') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    <div class="card border-0 shadow mb-4">
                        <form action="" method="GET" id="userForm" name="userForm">
                            @method('PUT')
                            <div class="card-body  p-4">
                                <h3 class="fs-4 mb-1">My Profile</h3>
                                <div class="mb-4">

                                    <label for="" class="mb-2">Name</label>
                                    <input type="text" placeholder="Enter Name" id="name" name="name"
                                        class="form-control" value="{{ $user->name }}">
                                    <p></p>
                                </div>
                                <div class="mb-4">
                                    <label for="" class="mb-2">Email</label>
                                    <input type="text" id="email" name="email" placeholder="Enter Email"
                                        class="form-control" value="{{ $user->email }}">
                                    <p></p>
                                </div>
                                <div class="mb-4">
                                    <label for="" class="mb-2">Designation*</label>
                                    <input type="text" id="designation" name="designation" placeholder="designation"
                                        value="{{ $user->designation }}" class="form-control">
                                </div>
                                <div class="mb-4">
                                    <label for="" class="mb-2">Mobile*</label>
                                    <input type="text" id="mobile" name="mobile" placeholder="Mobile"
                                        value="{{ $user->mobile }}" class="form-control">
                                </div>
                            </div>
                            <div class="card-footer  p-4">
                                <button type="submit" class="btn btn-primary">Update</button>
                            </div>
                        </form>
                    </div>

                    <div class="card border-0 shadow mb-4">
                        <form action="" name="changePasswordForm" id="changePasswordForm">
                            <div class="card-body p-4">
                                <h3 class="fs-4 mb-1">Change Password</h3>
                                <div class="mb-4">
                                    <label for="" class="mb-2">Old Password*</label>
                                    <input type="password" name="old_password" id="old_password" placeholder="Old Password"
                                        class="form-control">
                                    <p></p>
                                </div>
                                <div class="mb-4">
                                    <label for="" class="mb-2">New Password*</label>
                                    <input type="password" name="new_password" id="new_password" placeholder="New Password"
                                        class="form-control">
                                    <p></p>
                                </div>
                                <div class="mb-4">
                                    <label for="" class="mb-2">Confirm Password*</label>
                                    <input type="password" id="confirm_password" name="confirm_password"
                                        placeholder="Confirm Password" class="form-control">
                                    <p></p>
                                </div>
                            </div>
                            <div class="card-footer  p-4">
                                <button type="submit" class="btn btn-primary">Update</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@section('customJs')
    <script>
        $('#userForm').submit(function(e) {
            e.preventDefault()
            $.ajax({
                url: "{{ route('updateProfile') }}",
                type: 'put',
                dataType: 'json',
                data: $('#userForm').serializeArray(),
                success: function(response) {
                    console.log(response);
                    if (response.status == true) {
                        $("#name").removeClass('is-invalid')
                            .siblings('p')
                            .removeClass('invalid-feedback')
                            .html('')

                        $("#email").removeClass('is-invalid ')
                            .siblings('p')
                            .removeClass('invalid-feedback')
                            .html('')
                        window.location.href = "{{ url()->current() }}";
                    } else {
                        var errors = response.errors;
                        if (errors.name) {
                            $("#name").addClass('is-invalid ')
                                .siblings('p')
                                .addClass('invalid-feedback')
                                .html(errors.name)
                        } else {
                            $("#name").removeClass('is-invalid ')
                                .siblings('p')
                                .removeClass('invalid-feedback')
                                .html('')
                        }
                        if (errors.email) {
                            $("#email").addClass('is-invalid ')
                                .siblings('p')
                                .addClass('invalid-feedback')
                                .html(errors.email)
                        } else {
                            $("#email").removeClass('is-invalid ')
                                .siblings('p')
                                .removeClass('invalid-feedback')
                                .html('')

                        }
                    }

                }
            });
        });


        $('#changePasswordForm').submit(function(e) {
            e.preventDefault(e),
                $.ajax({
                    url: "{{ route('changePassword') }}",
                    type: 'post',
                    dataType: 'json',
                    data: $('#changePasswordForm').serializeArray(),
                    success: function(response) {
                        console.log(response);
                        window.location.href = "{{ url()->current() }}";
                        if (response.status == true) {

                            $("#old_password").removeClass('is-invalid ')
                                .siblings('p')
                                .removeClass('invalid-feedback')
                                .html('')
                            $("#new_password").removeClass('is-invalid ')
                                .siblings('p')
                                .removeClass('invalid-feedback')
                                .html('')

                            $("#confirm_password").removeClass('is-invalid ')
                                .siblings('p')
                                .removeClass('invalid-feedback')
                                .html('')

                        } else {
                            var errors = response.errors;
                            if (errors.old_password) {
                                $("#old_password").addClass('is-invalid ')
                                    .siblings('p')
                                    .addClass('invalid-feedback')
                                    .html(errors.old_password)
                            } else {
                                $("#old_password").removeClass('is-invalid ')
                                    .siblings('p')
                                    .removeClass('invalid-feedback')
                                    .html('')
                            }
                            if (errors.new_password) {
                                $("#new_password").addClass('is-invalid ')
                                    .siblings('p')
                                    .addClass('invalid-feedback')
                                    .html(errors.new_password)
                            } else {
                                $("#new_password").removeClass('is-invalid ')
                                    .siblings('p')
                                    .removeClass('invalid-feedback')
                                    .html('')
                            }

                            if (errors.confirm_password) {
                                $("#confirm_password").addClass('is-invalid ')
                                    .siblings('p')
                                    .addClass('invalid-feedback')
                                    .html(errors.confirm_password)
                            } else {
                                $("#confirm_password").removeClass('is-invalid ')
                                    .siblings('p')
                                    .removeClass('invalid-feedback')
                                    .html('')
                            }


                        }

                    }
                });
        });
    </script>
@endsection
