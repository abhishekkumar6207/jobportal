<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\CategoryModel;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    // public function home(){
    //     $category = CategoryModel::where('status', 1)->orderBy('name', 'ASC')->take(8)->get();
    //     // Debugging line
    //     dd($category);
    //     return view('hello', ['category' => $category]);
    // }

}
