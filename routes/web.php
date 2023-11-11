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
// Quen mat khau
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
        Route::get('/add/sanpham', 'AddProduct')->name('add.product');
        Route::post('/store/sanpham', 'StoreProduct')->name('store.product');

        Route::get('/export/product', 'Export')->name('export.product');
    });


    //Permission
    Route::controller(RoleController::class)->group(function () {
        Route::get('/all/permission', 'AllPermission')->name('all.permission')->middleware('permission:allPermission');
        Route::get('/add/permission', 'AddPermission')->name('add.permission')->middleware('permission:addPermission');
        Route::post('/store/permission', 'StorePermission')->name('store.permission')->middleware('permission:addPermission');
        Route::get('/edit/permission/{id}', 'EditPermission')->name('edit.permission')->middleware('permission:editPermission');
        Route::post('/update/permission', 'UpdatePermission')->name('update.permission')->middleware('permission:editPermission');
        Route::get('/delete/permission/{id}', 'DeletePermission')->name('delete.permission')->middleware('permission:deletePermission');

        Route::get('/import/permission', 'ImportPermission')->name('import.permission');
        Route::get('/export/permission', 'Export')->name('export.permission');
        Route::post('/import', 'Import')->name('import');
    });

    //Role
    Route::controller(RoleController::class)->group(function () {
        Route::get('/all/roles', 'AllRoles')->name('all.roles')->middleware('permission:allRole');
        Route::get('/add/roles', 'AddRoles')->name('add.roles')->middleware('permission:addRole');
        Route::post('/store/roles', 'StoreRoles')->name('store.roles')->middleware('permission:addRole');
        Route::get('/edit/roles/{id}', 'EditRoles')->name('edit.roles')->middleware('permission:editRole');
        Route::post('/update/roles', 'UpdateRoles')->name('update.roles')->middleware('permission:editRole');
        Route::get('/delete/roles/{id}', 'DeleteRoles')->name('delete.roles')->middleware('permission:deleteRole');

        Route::get('/add/roles/permission', 'AddRolesPermission')->name('add.roles.permission')->middleware('permission:addPermissionToRole');
        Route::post('/store/roles/permission', 'StoreRolesPermission')->name('store.roles.permission')->middleware('permission:addPermissionToRole');
        Route::get('/all/roles/permission', 'AllRolesPermission')->name('all.roles.permission')->middleware('permission:allRolePermission');
        Route::get('/admin/edit/roles/{id}', 'AdminEditRoles')->name('admin.edit.roles')->middleware('permission:editRolePermission');
        Route::post('/admin/update/roles/{id}', 'AdminUpdateRoles')->name('admin.update.roles')->middleware('permission:editRolePermission');
        Route::get('/admin/delete/roles/{id}', 'AdminDeleteRoles')->name('admin.delete.roles')->middleware('permission:deleteRolePermission');

        Route::get('/all/roles/user', 'AllRolesUser')->name('all.roles.user')->middleware('permission:allUser');
        Route::get('/add/roles/user', 'AddRolesUser')->name('add.roles.user')->middleware('permission:addUserRole');
        Route::get('/admin/edit/user/{id}', 'AdminEditUser')->name('admin.edit.user')->middleware('permission:editUserRole');
        Route::post('/store/roles/user', 'StoreRolesUser')->name('store.roles.user')->middleware('permission:addUserRole');
        Route::post('/admin/update/user/{id}', 'AdminUpdateUser')->name('admin.update.user')->middleware('permission:editUserRole');
    });
});

