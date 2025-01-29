@extends('layouts.layout')
@section('contant')
    <section class="section-5 bg-2">
        <div class="container py-5">
            <div class="row">
                <div class="col">
                    <nav aria-label="breadcrumb" class=" rounded-3 p-3 mb-4">
                        <ol class="breadcrumb mb-0">
                            <li class="breadcrumb-item"><a href="{{ url('/') }}">Home</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('admin.users') }}">users</a></li>
                        </ol>
                    </nav>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-3">
                    @include('admin.sidebar')
                </div>
                <div class="col-lg-9">
                    @if (Session::has('success'))
                    <div class="alert alert-success">
                        <p class="mb-0 pb-0"> {{ Session::get('success') }} </p>
                    </div>
                @endif
                @if (Session::has('error'))
                    <div class="alert alert-danger">
                        <p class="mb-0 pb-0"> {{ Session::get('error') }} </p>
                    </div>
                @endif
                    <form action="" method="post" id="editJobForm" name="editJobForm">
                        <div class="card border-0 shadow mb-4">
                            <div class="card-body card-form">
                                <div class="d-flex justify-content-between">
                                    <div>
                                        <h3 class="fs-4 mb-1">users</h3>
                                    </div>
                                    <div style="margin-top: -10px;">
                                    </div>

                                </div>
                                <div class="table-responsive">
                                    <table class="table ">
                                        <thead class="bg-light">
                                            <tr>
                                                <th scope="col">ID</th>
                                                <th scope="col">NAME</th>
                                                <th scope="col">EMAIL</th>
                                                <th scope="col">MOBILE</th>
                                                <th scope="col">ACTION</th>
                                            </tr>
                                        </thead>
                                        <tbody class="border-0">
                                            @if ($users->isNotEmpty())
                                                @foreach ($users as $user)
                                                    <tr class="active">
                                                        <td>
                                                            <div class="job-name fw-500">{{ $user->id }}</div>

                                                        </td>
                                                        <td>{{ $user->name }}</td>
                                                        <td>{{ $user->email }}</td>
                                                        <td>
                                                            {{ $user->mobile }}

                                                        </td>
                                                        <td>
                                                            <div class="action-dots">
                                                                <button href="#" class="btn"
                                                                    data-bs-toggle="dropdown" aria-expanded="false">
                                                                    <i class="fa fa-ellipsis-v" aria-hidden="true"></i>
                                                                </button>
                                                                <ul class="dropdown-menu dropdown-menu-end">

                                                                    <li><a class="dropdown-item"
                                                                            href="{{ route('admin.users.edit', $user->id) }}"><i
                                                                                class="fa fa-edit" aria-hidden="true"></i>
                                                                            Edit</a></li>
                                                                    <li>
                                                                        <a class="dropdown-item" href="#"
                                                                            onclick="deleteUser({{ $user->id }})">
                                                                            <i class="fa fa-trash" aria-hidden="true"></i>
                                                                            Delete
                                                                        </a>
                                                                    </li>
                                                                </ul>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            @endif


                                        </tbody>

                                    </table>
                                </div>
                                <div>
                                    {{ $users->links() }}
                                </div>
                            </div>
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
    <script type="text/javascript">
        function deleteUser(id) {
            if (confirm('Are you sure you want to delete?')) {
                $.ajax({
                    type: "DELETE",
                    url: "{{ route('admin.users.destroy') }}", // Correctly format the URL with the id parameter
                    data: {
                        "id": id
                    },
                    dataType: "json",
                    success: function(response) {
                        if (response.status) {
                    alert('User deleted successfully');
                    window.location.reload(); // Page reload after deletion
                } else {
                    alert('Failed to delete the user');
                }
            }
                });
            }
        }
    </script>
@endsection
