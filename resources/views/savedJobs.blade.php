@extends('layouts.layout')
@section('contant')
    <section class="section-5 bg-2">
        <div class="container py-5">
            <div class="row">
                <div class="col">
                    <nav aria-label="breadcrumb" class=" rounded-3 p-3 mb-4">
                        <ol class="breadcrumb mb-0">
                            <li class="breadcrumb-item"><a href="{{ url('/') }}">Home</a></li>
                            <li class="breadcrumb-item active">Saved Jobs</li>
                        </ol>
                    </nav>
                </div>
            </div>
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
            <div class="row">
                <div class="col-lg-3">
                    @include('sidebar')
                </div>
                <div class="col-lg-9">
                    <div class="card border-0 shadow mb-4 p-3">
                        <div class="card-body card-form">
                            <h3 class="fs-4 mb-1">Saved Jobs</h3>
                            <div class="table-responsive">
                                <table class="table ">
                                    <thead class="bg-light">
                                        <tr>
                                            <th scope="col">Title</th>
                                            <th scope="col">Job Created</th>
                                            <th scope="col">Applicants</th>
                                            <th scope="col">Status</th>
                                            <th scope="col">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody class="border-0">
                                        @if ($savedJobs->isNotEmpty())
                                            @foreach ($savedJobs as $saveJob)
                                                <tr class="active">
                                                    <td>
                                                        <div class="job-name fw-500">{{ $saveJob->saveJob->title }}</div>
                                                        <div class="info1">{{ $saveJob->saveJob->jobType->name }} .
                                                            {{ $saveJob->saveJob->location }}</div>
                                                    </td>
                                                    <td>{{ \carbon\carbon::parse($saveJob->created_at)->format('d M, Y') }}
                                                    </td>
                                                    <td>{{ $saveJob->saveJob->applicants->count() }}:Applications</td>
                                                    <td>
                                                        <div class="job-status text-capitalize">active</div>
                                                    </td>
                                                    <td>
                                                        <div class="action-dots float-end">
                                                            <a href="#" class="" data-bs-toggle="dropdown"
                                                                aria-expanded="false">
                                                                <i class="fa fa-ellipsis-v" aria-hidden="true"></i>
                                                            </a>
                                                            <ul class="dropdown-menu dropdown-menu-end">
                                                                <li><a class="dropdown-item"
                                                                        href="{{ route('jobDetail', $saveJob->saveJob->id) }}">
                                                                        <i class="fa fa-eye" aria-hidden="true"></i>
                                                                        View</a></li>
                                                                <li>
                                                                    <a class="dropdown-item" href="javascript:void(0)"
                                                                        onclick="removeSaveJob({{ $saveJob->id }})">
                                                                        <i class="fa fa-trash" aria-hidden="true"></i>
                                                                        Remove
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
                        </div>
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
    <script type="text/javascript">
        function removeSaveJob(id) {
            if (confirm("Are you sure you want to remove?")) {
                $.ajax({
                    type: "post",
                    url: "{{ route('removeSaveJobs') }}",
                    data: {
                        id: id
                    },
                    dataType: "json",
                    success: function(response) {
                        window.location.href = "{{ route('savedJob') }}";

                    }
                });
            }
        }
    </script>
@endsection
