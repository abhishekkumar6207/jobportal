<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\JobApplicationModel;
use Illuminate\Http\Request;

class JobApplicationController extends Controller
{
    //
    public function index(){
        $jobApplication=JobApplicationModel::orderBy('created_at','DESC')
        ->with('job','user','employer')
        ->paginate();
        return view('admin.job-Applications.jobApplication',[
            'jobApplications'=>$jobApplication
        ]);
    }

    public function destroy(Request $request){
    $id=$request->id;
        $application=JobApplicationModel::find($id);
        if($application==null){
            session()->flash('error', 'Either job deleted or not found');
            return response()->json([
             "status" => false
            ]);
        }
        $application->delete();
        session()->flash('error', 'Either job deleted or not found');
            return response()->json([
             "status" => true
            ]);

    }
}
