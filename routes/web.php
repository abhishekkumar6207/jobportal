<?php

use App\Http\Controllers\AccountController;
use App\Http\Controllers\JobPortalController;
use Illuminate\Support\Facades\Route;

// Route::get('/', function () {
//     return view('index');
// });
Route::get('/',[JobPortalController::class,'index']);

Route::get('/findJobs',[JobPortalController::class,'findJobs']);

Route::get('/login',[JobPortalController::class,'login'])->name('JobPortal.login');

Route::get('/postJob',[JobPortalController::class,'postJob']);

Route::get('/account',[JobPortalController::class,'account'])->name('account.profile');

Route::get('/myJob',[JobPortalController::class,'myJob']);

Route::get('/jobsApplied',[JobPortalController::class,'jobsApplied']);

Route::get('/savedJobs',[JobPortalController::class,'savedJobs']);

Route::get('/register',[JobPortalController::class,'register']);

Route::post('/proccesRegister',[AccountController::class,'procces_register'])->name('account.proccesRegister');

Route::post('/authenticate',[AccountController::class,'authenticate'])->name('authenticate');

Route::get('/logout',[AccountController::class,'logout'])->name('logout');

Route::put('/update-profile',[AccountController::class,'updateProfile'])->name('updateProfile');
Route::post('/update-profile-pic',[AccountController::class,'updateProfilePic'])->name('updateProfilePic');




