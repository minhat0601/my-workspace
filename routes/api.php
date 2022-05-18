<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\TeachController;
use App\Http\Controllers\PortalController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::prefix('/auth')->group(function(){
    Route::post('/login', [HomeController::class, 'login']);
});

Route::prefix('/project')->group(function(){
    Route::post('/task/make-done', [StudentController::class, 'makeDone'])->middleware('islogged')->middleware('majorchoice');
    Route::post('/task/take-it', [StudentController::class, 'takeIt'])->middleware('islogged')->middleware('isstudent');
    
});


Route::prefix('/student')->group(function(){
    Route::post('/major-choice', [StudentController::class, 'majorChoice'])->middleware('islogged')->middleware('isstudent');
    Route::post('/semester-choice', [StudentController::class, 'semesterChoice'])->middleware('islogged')->middleware('isstudent');
    Route::post('/join', [StudentController::class, 'getProjectJoinView'])->middleware('islogged')->middleware('isstudent');
    Route::post('/file-attack', [StudentController::class, 'fileAttack'])->middleware('islogged')->middleware('isstudent');
    Route::post('/browse', [StudentController::class, 'browse'])->middleware('islogged')->middleware('isstudent');
});


Route::prefix('/teacher')->group(function () {
    Route::post('/projects', [TeachController::class, 'getProjectList'])->middleware('islogged')->middleware('isteacher');
    Route::post('/create-task', [TeachController::class, 'createTask'])->middleware('islogged')->middleware('isteacher');
    Route::post('/delete-user', [TeachController::class, 'deleteUser'])->middleware('islogged')->middleware('isteacher');
    Route::post('/feedback', [TeachController::class, 'feedback'])->middleware('islogged')->middleware('isteacher');
    Route::post('/rollback', [TeachController::class, 'rollback'])->middleware('islogged')->middleware('isteacher');
    Route::post('/task-update', [TeachController::class, 'taskUpdate'])->middleware('islogged')->middleware('isteacher');
    Route::post('/task-delete', [TeachController::class, 'taskDelete'])->middleware('islogged')->middleware('isteacher');
    Route::post('/browse', [TeachController::class, 'browse'])->middleware('islogged')->middleware('isteacher');
    Route::post('/join', [TeachController::class, 'getProjectJoinView'])->middleware('islogged')->middleware('isteacher');
    Route::post('/file-attack', [TeachController::class, 'fileAttack'])->middleware('islogged')->middleware('isteacher');


});

Route::prefix('/portal')->group(function (){
    Route::post('/project-create', [PortalController::class, 'projectCreate'])->middleware('islogged')->middleware('isadmin')->name('portal.newProject');
    Route::post('/projects', [PortalController::class, 'getProjectList'])->middleware('islogged')->middleware('isadmin');
    Route::post('/students',[PortalController::class, 'studentManagerAction'])->middleware('islogged')->middleware('isadmin');
    Route::post('/mentors',[PortalController::class, 'mentorManagerAction'])->middleware('islogged')->middleware('isadmin');
    Route::post('/new-mentor',[PortalController::class, 'newMentor'])->middleware('islogged')->middleware('isadmin')->name('portal.newMentor');
    Route::post('/user/search',[PortalController::class, 'userSearchByEmail'])->middleware('islogged')->middleware('isadmin')->name('portal.searchUser');
    Route::post('/new-admin',[PortalController::class, 'newAdmin'])->middleware('islogged')->middleware('isadmin')->name('portal.newAdmin');
    Route::post('/admins',[PortalController::class, 'adminManagerAction'])->middleware('islogged')->middleware('isadmin');
    Route::post('/all-projects',[PortalController::class, 'projectManagerAction'])->middleware('islogged')->middleware('isadmin');
    

    Route::post('/create-task', [PortalController::class, 'createTask'])->middleware('islogged')->middleware('isadmin');
    Route::post('/delete-user', [PortalController::class, 'deleteUser'])->middleware('islogged')->middleware('isadmin');
    Route::post('/feedback', [PortalController::class, 'feedback'])->middleware('islogged')->middleware('isadmin');
    Route::post('/rollback', [PortalController::class, 'rollback'])->middleware('islogged')->middleware('isadmin');
    Route::post('/task-update', [PortalController::class, 'taskUpdate'])->middleware('islogged')->middleware('isadmin');
    Route::post('/task-delete', [PortalController::class, 'taskDelete'])->middleware('islogged')->middleware('isadmin');
    Route::post('/file-attack', [PortalController::class, 'fileAttack'])->middleware('islogged')->middleware('isadmin');
    Route::post('/get-task/{id}', [PortalController::class, 'getTaskByUserId'])->middleware('islogged')->middleware('isadmin');


    Route::post('/account-update', [PortalController::class, 'accountUpdate'])->middleware('islogged')->middleware('isadmin');

    Route::post('/project-update', [PortalController::class, 'projectUpdate'])->middleware('islogged')->middleware('isadmin');
    Route::get('/project-delete/{id}', [PortalController::class, 'projectDelete'])->middleware('islogged')->middleware('isadmin');
});