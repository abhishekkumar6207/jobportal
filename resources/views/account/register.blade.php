@extends('layouts.layout')
@section('contant')
    <section class="section-5">
        <div class="container my-5">
            <div class="py-lg-2">&nbsp;</div>
            <div class="row d-flex justify-content-center">
                <div class="col-md-5">
                    <div class="card shadow border-0 p-5">
                        <h1 class="h3">Register</h1>
                        <form action="" name="registerForm" id="registerForm">
                            <div class="mb-3">
                                <label for="" class="mb-2">Name*</label>
                                <input type="text" name="name" id="name" class="form-control"
                                    placeholder="Enter Name">
                                <p></p>
                            </div>
                            <div class="mb-3">
                                <label for="" class="mb-2">Email*</label>
                                <input type="text" name="email" id="email" class="form-control"
                                    placeholder="Enter Email">
                                <p></p>
                            </div>
                            <div class="mb-3">
                                <label for="" class="mb-2">Password*</label>
                                <input type="password" name="password" id="password" class="form-control"
                                    placeholder="Enter Password">
                                <p></p>
                            </div>
                            <div class="mb-3">
                                <label for="" class="mb-2">Confirm Password*</label>
                                <input type="password" name="confirm_password" id="confirm_password" class="form-control"
                                    placeholder="please comfirm Password">
                                <p></p>
                            </div>
                            <button type="submit" class="btn btn-primary mt-2">Register</button>
                        </form>
                    </div>
                    <div class="mt-4 text-center">
                        <p>Have an account? <a href="{{ url('/login') }}">Login</a></p>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title pb-0" id="exampleModalLabel">Change Profile Picture</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form>
                        <div class="mb-3">
                            <label for="exampleInputEmail1" class="form-label">Profile Image</label>
                            <input type="file" class="form-control" id="image" name="image">
                        </div>
                        <div class="d-flex justify-content-end">
                            <button type="submit" class="btn btn-primary mx-3">Update</button>
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('customJs')
    <script>
        $('#registerForm').submit(function(e) {
            e.preventDefault();
            $.ajax({
                url: '{{ route('account.proccesRegister') }}',
                type: 'post',
                data: $('#registerForm').serializeArray(),
                dataType: 'json',
                success: function(response) {
                    if (response.status == false) {

                        var errors = response.errors;
                        if (errors.name) {
                            $("#name").addClass('is-invalid')
                                .siblings('p')
                                .addClass('invalid-feedback')
                                .html(errors.name)
                        } else {
                            $("#name").removeClass('is-invalied')
                                .siblings('p')
                                .removeClass('inviled-feedback')
                                .html('')
                        }

                        if (errors.email) {
                            $("#email").addClass('is-invalied')
                                .siblings('p')
                                .addClass('inviled-feedback')
                                .html(errors.email)
                        } else {
                            $("#email").removeClass('is-invalied')
                                .siblings('p')
                                .removeClass('inviled-feedback')
                                .html('')
                        }

                        if (errors.password) {
                            $("#password").addClass('is-invalied')
                                .siblings('p')
                                .addClass('inviled-feedback')
                                .html(errors.password)
                        } else {
                            $("#password").removeClass('is-invalied')
                                .siblings('p')
                                .removeClass('inviled-feedback')
                                .html('')
                        }


                        if (errors.confirm_password) {
                            $("#confirm_password").addClass('is-invalied')
                                .siblings('p')
                                .addClass('inviled-feedback')
                                .html(errors.Confirm_password)
                        } else {
                            $("#confirm_password").removeClass('is-invalied')
                                .siblings('p')
                                .removeClass('inviled-feedback')
                                .html('')
                        }

                    } else {
                        $("#name").removeClass('is-invalied')
                            .siblings('p')
                            .removeClass('inviled-feedback')
                            .html('');

                        $("#email").removeClass('is-invalied')
                            .siblings('p')
                            .removeClass('inviled-feedback')
                            .html('');

                        $("#password").removeClass('is-invalied')
                            .siblings('p')
                            .removeClass('inviled-feedback')
                            .html('');

                        $("#confirm_password").removeClass('is-invalied')
                            .siblings('p')
                            .removeClass('inviled-feedback')
                            .html('');

                        window.location.href = '{{ route('JobPortal.login') }}'

                    }
                }
            });
        });
    </script>
@endsection
