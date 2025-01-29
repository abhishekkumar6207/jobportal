@extends('layouts.layout')
@section('contant')
    <section class="section-5 bg-2">
        <div class="container py-5">
            <div class="row">
                <div class="col">
                    <nav aria-label="breadcrumb" class=" rounded-3 p-3 mb-4">
                        <ol class="breadcrumb mb-0">
                            <li class="breadcrumb-item"><a href="{{ url('/') }}">Home</a></li>
                            <li class="breadcrumb-item active">My Jobs</li>
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
                    <div class="alert alert-success">
                        <p class="mb-0 pb-0"> {{ Session::get('success') }} </p>
                    </div>
                @endif
                @if (Session::has('errors'))
                    <div class="alert alert-danger">
                        <p class="mb-0 pb-0"> {{ Session::get('errors') }} </p>
                    </div>
                @endif
                    <div class="card border-0 shadow mb-4 p-3">
                        <div class="card-body card-form">
                            <div class="d-flex justify-content-between">
                                <div>
                                    <h3 class="fs-4 mb-1">My Jobs</h3>
                                </div>
                                <div style="margin-top: -10px;">
                                    <a href="{{ url('/postJob') }}" class="btn btn-primary">Post a Job</a>
                                </div>

                            </div>
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
                                        @if ($myJob->isNotEmpty())
                                        @foreach ($myJob as $myJobs)
                                        <tr class="active">
                                            <td>
                                                <div class="job-name fw-500">{{$myJobs->title }}</div>
                                                <div class="info1">{{ $myJobs->jobType->name }} . {{ $myJobs->location }}</div>
                                            </td>
                                            <td>{{\carbon\carbon::parse($myJobs->created_at)->format('d M, Y')}}</td>
                                            <td>0 Applications</td>
                                            <td>
                                                @if ($myJobs->status==1)
                                                <div class="job-status text-capitalize">Active</div>
                                                    @else
                                                    <div class="job-status text-capitalize">block</div>
                                                @endif

                                            </td>
                                            <td>
                                                <div class="action-dots float-end">
                                                    <button href="#" class="btn" data-bs-toggle="dropdown"
                                                        aria-expanded="false">
                                                        <i class="fa fa-ellipsis-v" aria-hidden="true"></i>
                                                </button>
                                                    <ul class="dropdown-menu dropdown-menu-end">
                                                        <li><a class="dropdown-item" href="{{route('jobDetail',$myJobs->id)}}"> <i
                                                                    class="fa fa-eye" aria-hidden="true"></i> View</a></li>
                                                        <li><a class="dropdown-item" href="{{route('editJob',$myJobs->id)}}"><i class="fa fa-edit"
                                                                    aria-hidden="true"></i> Edit</a></li>
                                                                    <li>
                                                                        <a class="dropdown-item" href="#" onclick="deleteJob({{ $myJobs->id }})">
                                                                            <i class="fa fa-trash" aria-hidden="true"></i> Delete
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
                                {{ $myJob->links() }}
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
    function deleteJob(jobid){
        if(confirm("Are you sure you want to delete?")){
           $.ajax({
                type: "post",
                url: "{{route('deleteJob')}}",
                data: {jobid: jobid},
                dataType: "json",
                success: function (response) {
                    window.location.href='{{ url("/myJob") }}'

                }
            });
        }
    }
</script>
@endsection
