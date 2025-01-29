<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\CategoryModel;
use App\Models\JobTypeModel;
use App\Models\PostJob;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\View;

use function PHPUnit\Framework\assertNotEmpty;

class jobController extends Controller
{

    public function index()
    {
        $job = PostJob::orderBy('created_at', 'DESC')->with('user', 'applications')->paginate(4);
        return view("admin.jobs.list", [
            'jobs' => $job

        ]);
    }


    public function edit($id)
    {
        $job = PostJob::findOrFail($id);
        $categories = CategoryModel::orderBy('name', 'ASC')->where('status', 1)->get();
        $jobType = JobTypeModel::orderBy('name', 'ASC')->where('status', 1)->get();

        return view('admin.jobs.edit', ['categories' => $categories, 'jobType' => $jobType, 'job' => $job]);
    }

    public function update(Request $request, $id)
    {

        $Rules = [
            'title' => 'required|min:4|max:100',
            'category' => 'required',
            'jobType' => 'required',
            'vacancy' => 'required|integer',
            'location' => 'required|max:50',
            'description' => 'required',
            'company_name' => 'required|max:75',
        ];
        $validator = Validator::make($request->all(), $Rules);

        if ($validator->passes()) {
            $postJob = PostJob::find($id);
            $postJob->title = $request->title;
            $postJob->category_id = $request->category;
            $postJob->job_type_id = $request->jobType;
            $postJob->vacancy = $request->vacancy;
            $postJob->salary = $request->salary;
            $postJob->location = $request->location;
            $postJob->description = $request->description;
            $postJob->benefits = $request->benefits;
            $postJob->responsibility = $request->responsibility;
            $postJob->qualifications = $request->qualifications;
            $postJob->experience = $request->experiance;
            $postJob->keywords = $request->keywords;
            $postJob->company_name = $request->company_name;
            $postJob->company_location = $request->location;
            $postJob->company_website = $request->website;
            $postJob->status = $request->status; // Ye 1 ya 0 hoga, based on user selection
            $postJob->isFeatured = !empty($request->isFeatured) ? $request->isFeatured : 0;
            $postJob->save();
            session()->flash('success', 'Update added successfully');
            return response()->json([
                'status' => true,
                'errors' => []
            ]);
        } else {

            return response()->json([
                "status" => false,
                'errors' => $validator->errors()
            ]);
        }
    }


    public function destroy(Request $request){
        $id=$request->id;
          $job=PostJob::find($id);
          if( $job==null){
            session()->flash('error', 'Either job deleted or not found');
               return response()->json([
                "status" => false

            ]);
          }
          $job->delete();
          session()->flash('success', 'job deleted successfully');
          return response()->json([
            "status" => true

        ]);
    }
}
