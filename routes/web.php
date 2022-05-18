<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\PortalController;
use App\Http\Controllers\TeachController;




/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/


Route::get('/', [HomeController::class, 'index'])->name('/')->middleware('islogged');
route::get('error', [HomeController::class, 'error'])->name('error');
Route::prefix('/auth')->group(function(){
    Route::get('/login',[HomeController::class, 'loginView'])->name('login');
    Route::get('/login/{msg}',[HomeController::class, 'loginView'])->name('login.msg');
    Route::get('/google', [AuthController::class, 'googleredirect'])->name('googlelogin');
    Route::get('/google/callback', [AuthController::class, 'handleCallback']);
    Route::get('/logout', [AuthController::class, 'logout'])->name('logout');

});

// For Student
Route::get('/dashboard', [StudentController::class, 'index'])->name('student.dashboard')->middleware('islogged')->middleware('majorchoice')->middleware('semesterchoice')->middleware('isstudent');
Route::get('/project/{id}', [StudentController::class, 'projectOverview'])->name('projectById')->middleware('islogged')->middleware('majorchoice')->middleware('semesterchoice')->middleware('isstudent');
Route::get('/major-choice', [StudentController::class, 'majorChoiceView'])->middleware('islogged')->name('major-choice')->middleware('isstudent');
Route::get('/semester-choice', [StudentController::class, 'semesterChoiceView'])->middleware('islogged')->name('semester-choice')->middleware('isstudent');
Route::get('/browse', [StudentController::class, 'browseView'])->middleware('islogged')->middleware('isstudent')->name('student.browse');
Route::get('/join/{id}/{code}', [StudentController::class, 'joining'])->middleware('islogged')->middleware('isstudent');




// For Teacher

Route::prefix('/teach')->group(function(){
    Route::get('/',[TeachController::class, 'index'])->name('teach.dashboard')->middleware('islogged')->middleware('isteacher');
    Route::get('/project/{project_id}',[TeachController::class, 'projectOverView'])->name('teach.project-overview')->middleware('islogged')->middleware('isteacher');
    Route::get('/browse', [TeachController::class, 'browseView'])->middleware('islogged')->middleware('isteacher')->name('teach.browse');

});

// For Portal

Route::prefix('/portal')->group(function(){
    Route::get('/',[PortalController::class, 'index'])->middleware('islogged')->middleware('isadmin')->name('portal.dashboard');
    Route::get('/students',[PortalController::class, 'studentManager'])->middleware('islogged')->middleware('isadmin')->name('portal.studentManager');
    Route::get('/user/{id}',[PortalController::class, 'studentView'])->middleware('islogged')->middleware('isadmin');
    Route::get('/mentors',[PortalController::class, 'mentorManager'])->middleware('islogged')->middleware('isadmin')->name('portal.mentorManager');
    Route::get('/admins',[PortalController::class, 'adminManager'])->middleware('islogged')->middleware('isadmin')->name('portal.adminManager');
    Route::get('/projects',[PortalController::class, 'projectManager'])->middleware('islogged')->middleware('isadmin')->name('portal.projectManager');
    Route::get('/project/{id}', [PortalController::class, 'projectOverview'])->middleware('islogged')->middleware('isadmin')->name('portal.projectOverview');
});


