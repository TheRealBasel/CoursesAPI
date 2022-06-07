<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\LogoutController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\ClassesController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\AdminController;
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
            Route::apiResource('role', RoleController::class);
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
        Route::post('register', [RegisterController::class, 'register']);
        Route::post('login', [LoginController::class, 'login']);
        Route::delete('logout', [LogoutController::class, 'logout'])->middleware('auth:sanctum');
    }
);