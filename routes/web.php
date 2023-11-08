<?php

use App\Http\Controllers\Admin\AdminSanphamController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\AuthContoller;
use App\Http\Controllers\SanphamController;
use App\Http\Middleware\Admin;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Laravel\Socialite\Facades\Socialite;
use App\Http\Controllers\Admin\RoleController;

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

Route::get('/', [SanphamController::class, 'index'])->name('index');
Route::get('/sanpham', [SanphamController::class, 'TrangSanPham'])->name('sanpham');

// Dang nhap, dang ky
Route::get('/dang-nhap', [AuthContoller::class, 'login'])->name('login');
Route::get('/dang-ky', [AuthContoller::class, 'signup'])->name('signup');
Route::get('/verify/{token}', [AuthContoller::class, 'verify']);
Route::post('/dang-nhap-user', [AuthContoller::class, 'loginUser'])->name('loginUser');
Route::post('/tao-tai-khoan', [AuthContoller::class, 'createUser'])->name('createUser');
Route::get('/dang-xuat', [AuthContoller::class, 'logoutUser'])->name('logoutUser');
route::get('/quen-mat-khau', [AuthContoller::class, 'forgotPassword'])->name('forgotPassword');
route::post('/quen-mat-khau', [AuthContoller::class, 'storeForgotPassword'])->name('storeForgotPassword');
Route::get('/reset-password/{token}', [AuthContoller::class, 'resetPassword']);
Route::post('/reset-password/{token}', [AuthContoller::class, 'postResetPassword']);

// Dang nhap google
Route::get('auth/google', [AuthContoller::class, 'loginGoogle'])->name('loginGoogle');
Route::get('auth/google/callback', [AuthContoller::class, 'loginGoogleCallback']);


// Admin
Route::prefix('admin')->middleware(['adminlogin', Admin::class])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'Index'])->name('admindashboard');

    Route::controller(AdminSanphamController::class)->group(function () {
        Route::get('/all/sanpham', 'AllProduct')->name('all.product');
    });


    Route::controller(RoleController::class)->group(function () {
        //Permission
        Route::get('/all/permission', 'AllPermission')->name('all.permission');
        Route::get('/add/permission', 'AddPermission')->name('add.permission');
        Route::post('/store/permission', 'StorePermission')->name('store.permission');
        Route::get('/edit/permission/{id}', 'EditPermission')->name('edit.permission');
        Route::post('/update/permission', 'UpdatePermission')->name('update.permission');
        Route::get('/delete/permission/{id}', 'DeletePermission')->name('delete.permission');

        Route::get('/import/permission', 'ImportPermission')->name('import.permission');
        Route::get('/export', 'Export')->name('export');
        Route::post('/import', 'Import')->name('import');
        //Role

    });


});

