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
            Route::group(['prefix' => 'class'], function () {
                Route::post('/', [ClassesController::class, 'new_class']);
                Route::get('/{id}', [ClassesController::class, 'get_class']);
            });

            Route::group(['prefix' => 'courses'], function () {
                Route::post('/', [CourseController::class, 'new_course']);
                Route::get('/{id}', [CourseController::class, 'get_course']);
            });

            Route::group(['prefix' => 'user'], function () {
                Route::post('assign', [AdminController::class, 'add_user_role']);
                Route::post('deassign', [AdminController::class, 'remove_user_role']);
            });

        });

        /* Student Routes */
        Route::group(['prefix' => 'student','middleware' => ['role:student']], function () {
            Route::group(['prefix' => 'class'], function () {
                Route::post('join', [StudentController::class, 'join_class']);
                Route::delete('leave', [StudentController::class, 'leave_class']);
            });
        });

        /* Teacher Routes */
        Route::group(['prefix' => 'teacher','middleware' => ['role:teacher']], function () {
            Route::get('students', [TeacherController::class, 'get_teacher_students']);
            Route::get('courses', [TeacherController::class, 'get_teacher_courses']);
        });

        Route::delete('logout', [LogoutController::class, 'logout']);

    }
);

Route::prefix('/auth')->group(
    function () {
        Route::post('register', [RegisterController::class, 'register']);
        Route::post('login', [LoginController::class, 'login']);
    }
);