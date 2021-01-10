<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});//, 'roles:admin'
Route::group(['middleware' => ['auth:api', 'roles:user']], function () {
    // Route::group(array('prefix' => '/v1'), function () {
    //---*Basic Route for CRUD, Model User *---//
    Route::get('users/', [UserController::class, 'findByEmail'])->name('findByEmail'); //find by Email user

    Route::delete('delete/user/{id}', [UserController::class, 'deleteUser'])->name('deleteUser');// Delete User
    Route::post('user/{id}', [UserController::class, 'updateUser'])->name('updateUser');//Update User: First Name, Last Name, Images
    //---*Basic Route for CRUD, Model User *---//

    //---*Basic Route for CRUD, Model Task *---//
    Route::get('task/', [TaskController::class, 'findTask'])->name('findTasks');// Find task by name
    Route::post('task/create', [TaskController::class, 'createTask'])->name('createTask');// Create task
    Route::get('task/{id}', [TaskController::class, 'startTask'])->name('startTask');// Find task by name
    Route::delete('task/{id}', [TaskController::class, 'destroyTask'])->name('destroyTask');// Delete Task
    Route::put('task/{id}', [TaskController::class, 'updateTask'])->name('updateTask');//Update Task
    //---*Basic Route for CRUD, Model Task *---//

    //---*Basic Route for Model Task *---//
    Route::get('task/{id}/project/', [TaskController::class, 'attachToProject'])->name('attachToProject');
    Route::post('task/{id}/priority',[TaskController::class,'attachPriority'])->name('attachPriority');
    //---*Basic Route for Model Task *---//

    //---*Basic Route for CRUD, Model Project *---//
    Route::post('project/create', [ProjectController::class, 'createProject'])->name('createProject');
    Route::post('project/update/{id}', [ProjectController::class, 'updateProject'])->name('updateProject');
    Route::get('project/find', [ProjectController::class, 'findProject'])->name('findProject');
    Route::delete('project/{id}', [ProjectController::class, 'deleteProject'])->name('deleteProject');
    Route::post('logout/', [AuthController::class, 'logOut'])->name('logOut');
    //---*Basic Route for CRUD, Model Project *---//

    //---*Basic Route for CRUD, Model Coment *---//
    Route::post('project/{id}/comment', [CommentController::class, 'commentProject'])->name('commentProject');
    Route::post('task/{id}/comment', [CommentController::class, 'commentTask'])->name('commentTask');
    Route::post('task/comment/{id}', [CommentController::class, 'updateComment'])->name('updateComment');
    Route::post('project/comment/{id}', [CommentController::class, 'updateCommentProject'])->name('updateCommentProject');
    //---*Basic Route for CRUD, Model Coment *---//

    //---*Basic Route for filters *---//
    Route::get('user/projects',[UserController::class, 'getUserProject'])->name('getUserProject');
    Route::get('user/tasks',[TaskController::class,'taskPriority'])->name('taskPriority');
    Route::get('project/tasks',[TaskController::class,'projectActiveTask'])->name('projectActiveTask');
    Route::get('user/attach',[UserController::class,'attachToProject'])->name('attachToProject');
    //---*Basic Route for filters *---//

    //});
});
//---*Basic Route for UnAuth User *---//
    Route::post('login/', [AuthController::class, 'authUser'])->name('authUser');
    Route::post('create/user', [UserController::class, 'storeUser'])->name('storeUser'); //Create User

