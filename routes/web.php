<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FrontHomeController;
use App\Http\Controllers\Back\BackHomeController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
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

    require __DIR__.'/adminAuth.php';
});

