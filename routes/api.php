<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\ClassesController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\TeacherController;


use Spatie\Permission\Models\Role;

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

Route::middleware('auth:sanctum')->group( 
    function () {
        /* Admin Routes */
        Route::group(['prefix' => 'admin', 'middleware' => ['role:admin']], function () {
            Route::apiResource('class', ClassesController::class);
            Route::apiResource('courses', CourseController::class);
            Route::post('role', [RoleController::class,'modifyUserRole']);
            Route::delete('role', [RoleController::class,'modifyUserRole']);

        });

        /* Student Routes */
        Route::group(['prefix' => 'student','middleware' => ['role:student']], function () {
            Route::apiResource('class', StudentController::class);
        });

        /* Teacher Routes */
        Route::group(['prefix' => 'teacher','middleware' => ['role:teacher']], function () {
            Route::get('students', [TeacherController::class, 'getTeacherStudents']);
            Route::get('courses', [TeacherController::class, 'getTeacherCourses']);
        });
    }
);

Route::prefix('/auth')->group(
    function () {
        Route::post('register', [AuthController::class, 'register']);
        Route::post('login', [AuthController::class, 'login']);
        Route::delete('logout', [AuthController::class, 'logout'])->middleware('auth:sanctum');
    }
);