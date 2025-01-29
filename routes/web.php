<?php

use App\Http\Controllers\AccountController;
use App\Http\Controllers\admin\DashboardController;
use App\Http\Controllers\admin\JobApplicationController;
use App\Http\Controllers\admin\jobController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\JobPortalController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;
use Illuminate\Types\Relations\User;

// Route::get('/', function () {
//     return view('index');
// });
Route::get('/', [JobPortalController::class, 'index']);

Route::get('/findJobs', [JobPortalController::class, 'findJobs']);

Route::get('/login', [JobPortalController::class, 'login'])->name('JobPortal.login');



Route::get('/forgot/password', [AccountController::class, 'forgotPassword'])->name('forgotPassword');
Route::post('/proccess/forgot/password', [AccountController::class, 'proccessForgotPassword'])->name('proccessForgotPassword');



Route::get('/postJob', [AccountController::class, 'postJob'])->name('postJob');

Route::get('/account', [JobPortalController::class, 'account'])->name('account.profile')->middleware('web');

Route::get('/myJob', [JobPortalController::class, 'myJob']);

Route::get('/jobsApplied', [JobPortalController::class, 'jobsApplied']);

Route::get('/savedJobs', [JobPortalController::class, 'savedJobs'])->name('savedJob');

Route::get('/register', [JobPortalController::class, 'register']);

Route::post('/proccesRegister', [AccountController::class, 'procces_register'])->name('account.proccesRegister');

Route::post('/authenticate', [AccountController::class, 'authenticate'])->name('authenticate');

Route::get('/logout', [AccountController::class, 'logout'])->name('logout');

Route::put('/update-profile', [AccountController::class, 'updateProfile'])->name('updateProfile');

Route::post('/update-profile-pic', [AccountController::class, 'updateProfilePic'])->name('updateProfilePic');

Route::post('/savePostJob', [AccountController::class, 'savePostJob'])->name('savePostJob');

Route::get('/my-job/edit/{jobId}', [AccountController::class, 'editJob'])->name('editJob');

Route::post('/updatePostJob/{jobId}', [AccountController::class, 'updatePostJob'])->name('updatePostJob');
Route::post('/deleteJob', [AccountController::class, 'deleteJob'])->name('deleteJob');

Route::get('/jobDetail/{id}', [JobPortalController::class, 'jobDetail'])->name('jobDetail');

Route::post('/applyJob', [JobPortalController::class, 'applayJob'])->name('applyJob');

Route::post('/saveJob', [JobPortalController::class, 'saveJob'])->name('saveJob');

Route::post('/removeJob-application', [JobPortalController::class, 'removeJobs'])->name('removeJob');

Route::post('/removeSaveJobs', [JobPortalController::class, 'removeSaveJobs'])->name('removeSaveJobs');

Route::post('/change/Password', [AccountController::class, 'changePassword'])->name('changePassword');

Route::group(['prefix' => 'admin'], function () {

    Route::get('/dashboard', [DashboardController::class, 'index'])->name('admin.dashboard');
    Route::get('/users', [UserController::class, 'index'])->name('admin.users');
    Route::get('/users/{id}', [UserController::class, 'edit'])->name('admin.users.edit');
    Route::put('/users/update/{id}', [UserController::class, 'update'])->name('admin.users.update');
    Route::delete('admin/users/delete', [UserController::class, 'destroy'])->name('admin.users.destroy');

    Route::get('/jobs', [jobController::class, 'index'])->name('admin.jobs');

    Route::get('/jobs/edit/{id}', [jobController::class, 'edit'])->name('admin.jobs.edit');

    Route::put('/jobs/{id}', [jobController::class, 'update'])->name('admin.jobs.update');

    Route::delete('admin/job/delete', [jobController::class, 'destroy'])->name('admin.jobs.destroy');
    Route::get('/jobs/appication', [JobApplicationController::class, 'index'])->name('admin.jobApplication');
    Route::delete('admin/applications/delete', [JobApplicationController::class, 'destroy'])->name('admin.applications.destroy');
});
