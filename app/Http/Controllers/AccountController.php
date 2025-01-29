<?php

namespace App\Http\Controllers;
use App\Http\Controllers\Controller;
use App\Models\CategoryModel;
use App\Models\JobTypeModel;
use App\Models\PostJob;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\View;
use function Laravel\Prompts\error;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;
use Illuminate\Support\Str;


use Post;

class AccountController extends Controller
{
    //

    public function procces_register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6|same:confirm_password',
            'confirm_password' => "required"
        ]);
        if ($validator->passes()) {
            $user = new User;
            $user->name = $request->name;
            $user->email = $request->email;
            $user->password = Hash::make($request->password);
            $user->save();
            session()->flash('success', 'you have registred successfully');

            return response()->json([
                'status' => true,
                'errors' => []
            ]);
        } else {
            return response()->json([
                'status' => false,
                'errors' => $validator->errors()
            ]);
        }
    }

    public function authenticate(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required'
        ]);
        if ($validator->passes()) {
            if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
                session()->flash('success', 'you have login successfully');
                return redirect()->route('account.profile');
            } else {
                return redirect()->route('JobPortal.login')->with('error', 'Either Email/Password is Incorrect');
            }
        } else {
            return redirect()->route('JobPortal.login')
                ->withErrors($validator)
                ->withInput($request->only('email'));
        }
    }

    public function logout()
    {
        Auth::logout();
        return redirect()->route('JobPortal.login');
    }

    public function updateProfile(Request $request)
    {
        $id = Auth::user()->id;
        $validator = Validator::make($request->all(), [
            'name' => 'required|min:5|max:20',
            'email' => 'required|email|unique:users,email,' . $id . ',id'
        ]);
        if ($validator->passes()) {
            $user = User::find($id);
            $user->name = $request->name;
            $user->email = $request->email;
            $user->mobile = $request->mobile;
            $user->designation = $request->designation;
            $user->save();

            session()->flash('success', 'profile update successfully');

            return response()->json([
                'status' => true,
                'errors' => []
            ]);
        } else {
            return response()->json([
                'status' => false,
                'errors' => $validator->errors()
            ]);
        }
    }








    public function updateProfilePic(Request $request)
    {

        $id = Auth::user()->id;
        $validator = Validator::make($request->all(), [
            'image' => 'required|image',
        ]);
        if ($validator->passes()) {

            $image = $request->image; // Changed 'image' to 'images'
            $ext = $image->getClientOriginalExtension();
            $imageName = $id . '-' . time() . '.' . $ext;
            $image->move(public_path("/profile_pic/"), $imageName);
            // create a thumbnail
            $sorcePath = public_path("/profile_pic/" . $imageName);
            $manager = new ImageManager(Driver::class);
            $image = $manager->read($sorcePath);

            // crop the best fitting 5:3 (600x360) ratio and resize to 600x360 pixel
            $image->cover(150, 150);
            $image->toPng()->save(public_path("/profile_pic/thumb/" . $imageName));

            // delete old profile pic
            File::delete("/profile_pic/thumb/" . Auth::user()->images);
            File::delete("/profile_pic/" . Auth::user()->images);


            User::where('id', $id)->update(['images' => $imageName]);





            session()->flash('success', 'Profile picture updated successfully');

            return response()->json([
                'status' => true,
                'errors' => []
            ]);
        } else {
            return response()->json([
                'status' => false,
                'errors' => $validator->errors()
            ]);
        }
    }

    public function postJob()
    {
        $categories = CategoryModel::orderBy('name', 'ASC')->where('status', 1)->get();
        $jobType = JobTypeModel::orderBy('name', 'ASC')->where('status', 1)->get();
        return view('account.job.postJob', ['categories' => $categories, 'jobType' => $jobType]);
    }

    public function savePostJob(Request $request)
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
            $postJob = new PostJob;
            $postJob->title = $request->title;
            $postJob->category_id = $request->category;
            $postJob->job_type_id = $request->jobType;
            $postJob->user_id = Auth::user()->id;
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
            $postJob->save();
            session()->flash('success', 'job added successfully');
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

    public function editJob(Request $request, $id)
    {

        $categories = CategoryModel::orderBy('name', 'ASC')->where('status', 1)->get();
        $jobType = JobTypeModel::orderBy('name', 'ASC')->where('status', 1)->get();
        $postJob = PostJob::where([
            'user_id' => Auth::user()->id,
            'id' => $id
        ])->first();
        if ($postJob == null) {
            abort(404);
        }
        return view('account.job.editJob', ['categories' => $categories, 'jobType' => $jobType, 'postJob' => $postJob]);
    }


    public function updatePostJob(Request $request, $id)
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
            $postJob->user_id = Auth::user()->id;
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

    public function deleteJob(Request $request)
    {

        $job = postJob::where([
            'user_id' => Auth::user()->id,
            'id' => $request->jobid
        ])->first();

        if ($job == null) {
            session()->flash('error', 'Either job delete or not found.');
            return response()->json([
                'status' => true,

            ]);
        }
        postJob::where('id', $request->jobid)->delete();
        session()->flash('success', 'job delete successfully');
        return response()->json([
            'status' => true,

        ]);
    }


    public function changePassword(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'old_password' => 'required',
            'new_password' => 'required|min:6',
            'confirm_password' => 'required|same:new_password'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'error' => $validator->errors()
            ]);
        }

        if (!Hash::check($request->old_password, Auth::user()->password)) {
            session()->flash('error', 'Your old password is incorrect');
            return response()->json([
                'status' => false,
                'error' => 'Your old password is incorrect'
            ]);
        }
        $user = User::find(Auth::user()->id);
        $user->password = Hash::make($request->new_password);
        $user->save();
        session()->flash('success', 'password updated successfully.');
        return response()->json([
            'status' => true,
        ]);
    }
    public function forgotPassword()
    {
        return view('account.forgotPassword');
    }

    public function proccessForgotPassword(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email|exists:users,email'
        ]);
        if ($validator->fails()) {
            return redirect()->route('forgotPassword')->withInput()->withErrors($validator);
        }
        $token= Str::random(10);
        \DB::table('password_reset_tokens')->insert([
            'email'=>$request->email,
            'token'=>$request->$token,
            'created_at'=>now()
        ]);
    }
}
