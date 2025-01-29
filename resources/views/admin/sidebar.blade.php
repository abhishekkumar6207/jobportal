<div class="card border-0 shadow mb-4 p-3">
    <div class="s-body text-center mt-3">

        @if (Auth::User()->images != '')
            <img src="{{ asset('profile_pic/thumb/'.Auth::User()->images)}}" alt="avatar" class="rounded-circle img-fluid"
                style="width: 150px;">
            @else
            <img src="assets/images/avatar7.png" alt="avatar"  class="rounded-circle img-fluid" style="width: 150px;">
    @endif

        <h5 class="mt-3 pb-0">{{ Auth::User()->name }}</h5>
        <p class="text-muted mb-1 fs-6">{{ Auth::User()->designation }}</p>
        <div class="d-flex justify-content-center mb-2">
            <button data-bs-toggle="modal" data-bs-target="#updateProfileImageModel" type="button" class="btn btn-primary">Change
                Profile Picture</button>
        </div>

    </div>
</div>
<div class="card account-nav border-0 shadow mb-4 mb-lg-0">
    <div class="card-body p-0">
        <ul class="list-group list-group-flush ">
            <li class="list-group-item d-flex justify-content-between p-3">
                <a href="{{ route('admin.users') }}">Users</a>
            </li>
            <li class="list-group-item d-flex justify-content-between align-items-center p-3">
                <a href="{{ route('admin.jobs') }}">Jobs</a>
            </li>
            <li class="list-group-item d-flex justify-content-between align-items-center p-3">
                <a href="{{ route('admin.jobApplication') }}">Job Applications</a>
            </li>

            <li class="list-group-item d-flex justify-content-between align-items-center p-3">
                <a href="#">Logout</a>
            </li>

        </ul>
    </div>
</div>
<div class="modal fade" id="updateProfileImageModel" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title pb-0" id="exampleModalLabel">Change Profile Picture</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="profilePicForm" method="POST" name="profilePicForm">
                    {{-- @method('PUT') --}}
                    <div class="mb-3">
                        <label for="exampleInputEmail1" class="form-label">Profile Image</label>
                        <input type="file" class="form-control" id="image" name="image">
                        <p class="text-danger" id="image-errors"></p>
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


