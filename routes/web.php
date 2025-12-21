<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FrontHomeController;
use App\Http\Controllers\Back\BackHomeController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\Back\CategoryController;
use App\Http\Controllers\Back\CourseController;
use App\Http\Controllers\Back\LessonController;
use App\Http\Controllers\Back\EnrollmentController;
use App\Http\Controllers\Front\EnrollmentController as FrontEnrollmentController;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

//front routes
route::prefix('front')->name('front.')->group(function () {
    route::get('/', FrontHomeController::class)->middleware('auth')->name('index');
    route::view ('/login', 'front.auth.login')->name('login');
    route::view ('/register', 'front.auth.register')->name('register');
    route::view ('/forget-password', 'front.auth.forget-password')->name('forget-password');
    
    ##-----------------------------------enrollments routes (students)-----------------------------------##
    route::middleware('auth')->group(function () {
        route::post('enrollments', [FrontEnrollmentController::class, 'store'])->name('enrollments.store');
        route::get('enrollments', [FrontEnrollmentController::class, 'index'])->name('enrollments.index');
        route::put('enrollments/{enrollment}', [FrontEnrollmentController::class, 'update'])->name('enrollments.update');
    });
});

require __DIR__.'/auth.php';

//back design routes
route::prefix('back')->name('back.')->group(function () {
    route::get('/', BackHomeController::class)->middleware('admin')->name('index');


    ##-----------------------------------admins routes-----------------------------------##
    route::resource('admins', AdminController::class)->middleware('admin')->names('admins');

    ##-----------------------------------roles routes-----------------------------------##
    route::resource('roles', RoleController::class)->middleware('admin')->names('roles');

    ##-----------------------------------users routes-----------------------------------##
    route::resource('users', UserController::class)->middleware('admin')->names('users');

    ##-----------------------------------categories routes-----------------------------------##
    route::resource('categories', CategoryController::class)->middleware('admin')->names('categories');

    ##-----------------------------------courses routes-----------------------------------##
    route::resource('courses', CourseController::class)->middleware('admin')->names('courses');

    ##-----------------------------------lessons routes-----------------------------------##
    route::resource('lessons', LessonController::class)->middleware('admin')->names('lessons');

    ##-----------------------------------enrollments routes (admin - read only)-----------------------------------##
    route::middleware('admin')->group(function () {
        route::get('enrollments', [EnrollmentController::class, 'index'])->name('enrollments.index');
        route::get('enrollments/{enrollment}', [EnrollmentController::class, 'show'])->name('enrollments.show');
    });

    
    require __DIR__.'/adminAuth.php';
});

