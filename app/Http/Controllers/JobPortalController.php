<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use App\Models\User;

class JobPortalController extends Controller
{
    //
    public function index(){
        return view('mainContant');
    }
    public function FindJobs(){
        return view('findJobs');
    }
    public function login(){
        return view('login');
    }

    public function postJob(){
        return view('postJob');
    }

    public function account(){
        $id=Auth::user()->id;
        $user=User::where('id',$id)->first();
        return view('account',['user'=>$user]);
        return view('sidebar',['user'=>$user]);
    }


    public function myJob(){
        return view('myJob');
    }
    public function jobsApplied(){
        return view('jobsApplied');
    }

    public function savedJobs(){
        return view('savedJobs');
    }
    public function register(){
        return view('account.register');
    }


    
  
 
 
   
    public function jobApplide(){
        return view('jobApplide');
    }
   
}
