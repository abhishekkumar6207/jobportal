@extends('layouts.layout')
@section('contant')
    <section class="section-5 bg-2">
        <div class="container py-5">
            <div class="row">
                <div class="col">
                    <nav aria-label="breadcrumb" class=" rounded-3 p-3 mb-4">
                        <ol class="breadcrumb mb-0">
                            <li class="breadcrumb-item"><a href="{{ url('/') }}">Home</a></li>
                            <li class="breadcrumb-item active">Post a Job</li>
                        </ol>
                    </nav>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-3">
                    @include('admin.sidebar')
                </div>
                @if (Session::has('success'))
                    <div class="alert alert-success">
                        <p class="mb-0 pb-0"> {{ Session::get('success') }} </p>
                    </div>
                @endif
                @if (Session::has('errors'))
                    <div class="alert alert-danger">
                        <p class="mb-0 pb-0"> {{ Session::get('error') }} </p>
                    </div>
                @endif
                <div class="col-lg-9">
                    <form action="{{ route('admin.users.update', $user->id) }}" method="POST" id="userForm">
                        @csrf
                        @method('PUT')

                        <div class="card-body p-4">
                            <h3 class="fs-4 mb-1">User Edit</h3>
                            <div class="mb-4">
                                <label for="name" class="mb-2">Name</label>
                                <input type="text" placeholder="Enter Name" id="name" name="name"
                                    class="form-control" value="{{ $user->name }}">
                                <p></p>
                            </div>
                            <div class="mb-4">
                                <label for="email" class="mb-2">Email</label>
                                <input type="text" id="email" name="email" placeholder="Enter Email"
                                    class="form-control" value="{{ $user->email }}">
                                <p></p>
                            </div>
                            <div class="mb-4">
                                <label for="mobile" class="mb-2">Mobile*</label>
                                <input type="text" id="mobile" name="mobile" placeholder="Mobile"
                                    class="form-control" value="{{ $user->mobile }}">
                                <p></p>
                            </div>
                        </div>
                        <div class="card-footer p-4">
                            <button type="submit" class="btn btn-primary">Update</button>
                        </div>
                    </form>

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
        $('#userForm').submit(function(e) {
            e.preventDefault();
            $.ajax({
                url: '{{ route('admin.users.update', $user->id) }}',
                type: 'PUT', // Ensure this is PUT
                dataType: 'json',
                data: $('#userForm').serializeArray(),
                success: function(response) {
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
    </script>
@endsection
