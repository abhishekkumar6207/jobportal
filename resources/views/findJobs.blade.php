@extends('layouts.layout')
@section('contant')
    <section class="section-3 py-5 bg-2 ">
        <div class="container">
            <div class="row">
                <div class="col-6 col-md-10 ">
                    <h2>Find Jobs</h2>
                </div>
                <div class="col-6 col-md-2">
                    <div class="align-end">
                        <select name="sort" id="sort" class="form-control">
                            <option value="1"{{ (Request::get('sort')== '1')?'selected' : '' }}>Latest</option>
                            <option value="0" {{ (Request::get('sort')== '0')?'selected' : '' }} >Oldest</option>
                        </select>
                    </div>
                </div>
            </div>

            <div class="row pt-5">
                <div class="col-md-4 col-lg-3 sidebar mb-4">
                    <form action="" name="searchForm" id="searchForm">
                        <div class="card border-0 shadow p-4">
                            <div class="mb-4">
                                <h2>Keywords</h2>
                                <input type="text" value="{{ Request::get('keywords') }}" name="Keywords" id="Keywords"
                                    placeholder="Keywords" class="form-control">
                            </div>

                            <div class="mb-4">
                                <h2>Location</h2>
                                <input type="text" value="{{ Request::get('location') }}" name="location" id="location"
                                    placeholder="Location" class="form-control">
                            </div>

                            <div class="mb-4">
                                <h2>Category</h2>
                                <select name="category" id="category" class="form-control">
                                    <option value="">Select a Category</option>
                                    @if ($category->isNotEmpty())
                                        @foreach ($category as $category)
                                            <option {{ Request::get('category') == $category->id ? 'selected' : '' }}
                                                value="{{ $category->id }}">{{ $category->name }}</option>
                                        @endforeach
                                    @endif

                                </select>
                            </div>

                            <div class="mb-4">
                                <h2>Job Type</h2>
                                @if ($jobType->isNotEmpty())
                                    @foreach ($jobType as $jobTypes)
                                        <div class="form-check mb-2">
                                            {{-- {{ (in_array($jobTypes->id,$jobTypesArray))?'checked':'' }} --}}
                                            <input class="form-check-input school-section" name="job_type"
                                                value="{{ $jobTypes->id }}" type="checkbox" value="1"
                                                id="job-type-{{ $jobTypes->id }}">
                                            <label class="form-check-label "
                                                for="job-type-{{ $jobTypes->id }}">{{ $jobTypes->name }}</label>
                                        </div>
                                    @endforeach
                                @endif

                            </div>

                            <div class="mb-4">
                                <h2>Experience</h2>
                                <select name="experience" id="experience" class="form-control">
                                    <option value="">Select Experience</option>
                                    <option value="1"{{ Request::get('experience') == 1 ? 'selected' : '' }}>1 Year
                                    </option>
                                    <option value="2"{{ Request::get('experience') == 2 ? 'selected' : '' }}>2 Years
                                    </option>
                                    <option value="3"{{ Request::get('experience') == 3 ? 'selected' : '' }}>3 Years
                                    </option>
                                    <option value="4"{{ Request::get('experience') == 4 ? 'selected' : '' }}>4 Years
                                    </option>
                                    <option value="5"{{ Request::get('experience') == 5 ? 'selected' : '' }}>5 Years
                                    </option>
                                    <option value="6"{{ Request::get('experience') == 6 ? 'selected' : '' }}>6 Years
                                    </option>
                                    <option value="7"{{ Request::get('experience') == 7 ? 'selected' : '' }}>7 Years
                                    </option>
                                    <option value="8"{{ Request::get('experience') == 8 ? 'selected' : '' }}>8 Years
                                    </option>
                                    <option value="9"{{ Request::get('experience') == 9 ? 'selected' : '' }}>9 Years
                                    </option>
                                    <option value="10"{{ Request::get('experience') == 10 ? 'selected' : '' }}>10 Years
                                    </option>
                                    <option value="10_plus"{{ Request::get('experience') == 10 ? '10_plus' : '' }}>10+ Years
                                    </option>
                                </select>
                            </div>
                            <button type="submit" class="btn btn-primary">search</button>

                            <a href="{{ url('/findJobs')}}" class="btn btn-secondary mt-3">Reset </a>

                        </div>
                    </form>
                </div>

                <div class="col-md-8 col-lg-9 ">
                    <div class="job_listing_area">
                        <div class="job_lists">
                            <div class="row">
                                @if ($postJob->isNotEmpty())
                                    @foreach ($postJob as $postJobs)
                                        <div class="col-md-4">
                                            <div class="card border-0 p-3 shadow mb-4">
                                                <div class="card-body">
                                                    <h3 class="border-0 fs-5 pb-2 mb-0">{{ $postJobs->title }}</h3>
                                                    <p>{{ Str::words(strip_tags( $postJobs->description), $words = 8, '...') }}</p>
                                                    <div class="bg-light p-3 border">
                                                        <p class="mb-0">
                                                            <span class="fw-bolder"><i class="fa fa-map-marker"></i></span>
                                                            <span class="ps-1">{{ $postJobs->location }}</span>
                                                        </p>
                                                        <p class="mb-0">
                                                            <span class="fw-bolder"><i class="fa fa-clock-o"></i></span>
                                                            <span class="ps-1">{{ $postJobs->jobType->name }}</span>
                                                        </p>
                                                        <p>Keywords:{{ $postJobs->keywords }}</p>
                                                        <p>Experience:{{ $postJobs->experience }}</p>
                                                        @if (!is_null($postJobs->salary))
                                                            <p class="mb-0">
                                                                <span class="fw-bolder"><i class="fa fa-usd"></i></span>
                                                                <span class="ps-1" name="salary"
                                                                    id="salary">{{ $postJobs->salary }}</span>
                                                            </p>
                                                        @endif

                                                    </div>

                                                    <div class="d-grid mt-3">
                                                        <a href="{{ route('jobDetail',$postJobs->id)}}" class="btn btn-primary btn-lg">Details</a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                    {{$postJob->withQueryString()->links()}}
                                @endif

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
    <script>
       $("#searchForm").submit(function(e) {
    e.preventDefault();
    var url = '{{ url('findJobs') }}?';
    var keyword = $('#Keywords').val();
    var location = $('#location').val();
    var category = $('#category').val();
    var experience = $('#experience').val();
    var sort = $('#sort').val();

    if (keyword != "") {
        url += 'Keywords=' + keyword + '&';
    }

    if (location != "") {
        url += 'location=' + location + '&';
    }

    if (category != "") {
        url += 'category=' + category + '&';
    }

    if (experience != "") {
        url += 'experience=' + experience + '&';
    }

    url += 'sort='+sort;

    window.location.href = url;
});


        $("#sort").change(function(){
            $("#searchForm").submit();
        });
    </script>
@endsection
