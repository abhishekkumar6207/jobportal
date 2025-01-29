<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Mail\JobNotificationEmail;
use App\Models\CategoryModel;
use App\Models\JobApplicationModel;
use App\Models\JobTypeModel;
use App\Models\PostJob;
use App\Models\SaveJobModel;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class JobPortalController extends Controller
{
    //
    public function index()
    {
        $category = CategoryModel::where('status', 1)
            ->orderBy('name', 'ASC')
            ->take(8)
            ->get();

        $newcategories = CategoryModel::where('status', 1)
            ->orderBy('name', 'ASC')->get();


        $isFeatured    = PostJob::where('status', 1)
            ->orderBy('created_at', 'DESC')
            ->with('jobType')
            ->orWhere('isFeatured', 1)
            ->take(6)
            ->get();

        $letestJob = postJob::where('status', 1)
            ->with('jobType')
            ->orderBy('created_at', 'DESC')
            ->take(6)
            ->get();
        return view('mainContant', [
            'categories' => $category,
            'isFeatured' => $isFeatured,
            'letestJob' => $letestJob,
            'newcategories' => $newcategories
        ]);
    }

    public function jobDetail($id)
    {
        $jobDetail = PostJob::where([
            'id' => $id,
            'status' => 1
        ])->with(['jobType', 'cotegory'])->first();

        if ($jobDetail == null) {
            abort(404);
        }
        $count = 0;
        if (Auth::user()) {
            $count = SaveJobModel::where([
                'user_id' => Auth::user()->id,
                'job_id' => $id
            ])->count();
        }

        $JobApplication = JobApplicationModel::where('job_id', $id)->with('user')->get();


        return view('jobDetail', ['jobDetail' => $jobDetail, 'count' => $count,'JobApplication'=>$JobApplication]);
    }



    public function FindJobs(Request $request)
    {
        $category = CategoryModel::where('status', 1)->get();
        $jobTypes = JobTypeModel::where('status', 1)->get();
        $postJob = PostJob::where('status', 1);

        if (!empty($request->keywords)) {
            $postJob = $postJob->where(function ($query) use ($request) {
                $query->orWhere('title', 'like', '%' . $request->keywords . '%');
                $query->orWhere('keywords', 'like', '%' . $request->keywords . '%');
            });
        }

        if (!empty($request->location)) {
            $postJob = $postJob->where('location', $request->location);
        }

        if (!empty($request->category)) {
            $postJob = $postJob->where('category_id', $request->category);
        }
        // $jobTypesArray = [];
        if (!empty($request->job_type)) {

            $jobTypesArray = explode(',', $request->job_type);
            $postJob = $postJob->whereIn('job_type_id', $jobTypesArray);
        }

        if (!empty($request->experience)) {
            $postJob = $postJob->where('experience', $request->experience);
        }

        $postJob = $postJob->with('jobType');

        if ($request->sort == '0') {
            $postJob = $postJob->orderBy('created_at', 'ASC');
        } else {
            $postJob = $postJob->orderBy('created_at', 'DESC');
        }

        $postJob = $postJob->paginate(6);

        return view('findJobs', [
            'category' => $category,
            'jobType' => $jobTypes,
            'postJob' => $postJob,
            // '$jobTypesArray' => $jobTypesArray
        ]);
    }

    public function applayJob(Request $request)
    {

        $id = $request->id;
        $job = PostJob::where('id', $id)->first();

        if ($job == null) {
            session()->flash('error', 'jobs does not exist');
            return response()->json([
                'status' => false,
                'message' => 'job does not exist'
            ]);
        }
        $employer_id = $job->user_id;
        if ($employer_id == Auth::user()->id) {
            session()->flash('error', 'You can not apply on your own job');
            return response()->json([
                'status' => false,
                'message' => 'You can not apply on your own job'
            ]);
        }
        //you can not apply on a job twise

        $jobApplication = JobApplicationModel::where([
            'user_id' => Auth::user()->id,
            'job_id' => $id,
        ])->count();

        if ($jobApplication > 0) {
            session()->flash('error', 'You already applied on this job.');
            return response()->json([
                'status' => false,
                'message' => 'You can not apply on your own job'
            ]);
        }


        $application = new JobApplicationModel;
        $application->job_id = $id;
        $application->user_id = Auth::user()->id;
        $application->employer_id = $employer_id;
        $application->applied_date = now();
        $application->save();

        //send notification Email to employer
        $employer = User::where('id', $employer_id)->first();
        $mailData = [
            'employer' => $employer,
            'user' => Auth::user(),
            'job' => $job,
        ];
        Mail::to($employer->email)->send(new JobNotificationEmail($mailData));
        session()->flash('success', 'You have successfully applied');
        return response()->json([
            'status' => true,
            'message' => 'You have successfully applied'
        ]);
    }




    public function login()
    {
        return view('login');
    }

    public function postJob()
    {
        return view('account.job.postJob');
    }

    public function account()
    {
        $user = Auth::user();

        if (!$user) {
            // Handle case where user is not authenticated
            return redirect()->route('JobPortal.login');
        }

        $id = $user->id;
        $userDetails = User::where('id', $id)->first();

        return view('account', ['user' => $userDetails]);
    }



    public function myJob()
    {
        $myJob = PostJob::where('user_id', Auth::user()->id)->with('jobType')->orderBy('created_at', 'DESC')->paginate(10);

        return view('myJob', ['myJob' => $myJob]);
    }


    public function jobsApplied()
    {
        $jobApplications = JobApplicationModel::where('user_id', Auth::user()->id)
            ->with(['job', 'job.jobType', 'job.cotegory', 'job.applications'])->orderBy('created_at', 'DESC')->paginate(6);

        // dd($jobApplications);
        return view('jobsApplied', ['jobApplications' => $jobApplications]);
    }

    public function removeJobs(Request $request)
    {
        $jobApplication = JobApplicationModel::where([
            'id' => $request->id,
            'user_id' => Auth::user()->id
        ])
            ->first();
        if ($jobApplication == null) {
            session()->flash('error', 'job application not found');
            return response()->json([
                'status' => false,
            ]);
        }

        JobApplicationModel::find($request->id)->delete();
        session()->flash('success', 'job application removed successfully');
        return response()->json([
            'status' => true,
        ]);
    }



    public function savedJobs()
    {
        //     $jobApplications = JobApplicationModel::where('user_id', Auth::user()->id);
        //     ->with(['job','job.jobType','job.cotegory','job.applications'])
        //     ->get();
        //     // dd($jobApplications);
        // return view('savedJobs', ['jobApplications' => $jobApplications]);

        $saveJob = SaveJobModel::where(['user_id' => Auth::user()->id])
            ->with(['saveJob', 'saveJob.jobType', 'saveJob.applicants'])->orderBy('created_at', 'DESC')->paginate(6);
        return view('savedJobs', ['savedJobs' => $saveJob]);
    }



    public function register()
    {
        return view('account.register');
    }
    public function jobApplide()
    {
        return view('jobApplide');
    }


    public function saveJob(Request $request)
    {

        $id = $request->id;

        $job = PostJob::find($id);

        if ($job == null) {
            session()->flash('error', 'Job not found');
            return response()->json([
                'status' => false
            ]);
        }
        //cheak if user already save the job
        $count = SaveJobModel::where([
            'user_id' => Auth::user()->id,
            'job_id' => $id
        ])->count();

        if ($count > 0) {
            session()->flash('error', 'You already saved this job');
            return response()->json([
                'status' => false
            ]);
        }
        $savedJob = new SaveJobModel;
        $savedJob->job_id = $id;
        $savedJob->user_id = Auth::user()->id;
        $savedJob->save();
        session()->flash('success', 'You have successfully saved the job');
        return response()->json([
            'status' => true
        ]);
    }

    public function removeSaveJobs(Request $request)
    {
        $savedJob = SaveJobModel::where([
            'id' => $request->id,
            'user_id' => Auth::user()->id
        ])
            ->first();
        if ($savedJob == null) {
            session()->flash('error', 'job save not found');
            return response()->json([
                'status' => false,
            ]);
        }

        SaveJobModel::find($request->id)->delete();
        session()->flash('success', 'job save removed successfully');
        return response()->json([
            'status' => true,
        ]);
    }
}
