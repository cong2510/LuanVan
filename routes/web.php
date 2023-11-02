<?php

use App\Http\Controllers\Admin\AdminSanphamController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\AuthContoller;
use App\Http\Controllers\SanphamController;
use App\Http\Middleware\Admin;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Laravel\Socialite\Facades\Socialite;

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

// Dang nhap google
Route::get('auth/google', [AuthContoller::class,'loginGoogle'])->name('loginGoogle');
Route::get('auth/google/callback', [AuthContoller::class,'loginGoogleCallback']);


// Admin
Route::prefix('admin')->middleware(['adminlogin', Admin::class])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'Index'])->name('admindashboard');
    Route::get('/sanpham', [AdminSanphamController::class, 'Index'])->name('adminsanpham');

});

