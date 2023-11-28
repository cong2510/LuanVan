<?php

use App\Http\Controllers\Admin\AdminOrderController;
use App\Http\Middleware\User;
use App\Http\Middleware\Admin;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthContoller;
use App\Http\Controllers\UserController;
use Laravel\Socialite\Facades\Socialite;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\SanphamController;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\AdminBrandController;
use App\Http\Controllers\Admin\AdminSanphamController;
use App\Http\Controllers\Admin\AdminCategoryController;

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
Route::get('/sanpham/theloai/{id}', [SanphamController::class, 'TrangSanPhamTheLoai'])->name('sanphamtheloai');
Route::get('/sanpham/detail-{id}', [SanphamController::class, 'DetailSanpham'])->name('detailsanpham');
Route::get('/sanpham/timkiem', [SanphamController::class, 'TrangTimKiem'])->name('search');

// Cart
Route::get('/cart', [OrderController::class, 'Cart'])->name('cart');
Route::post('/cart/add', [OrderController::class, 'AddToCart'])->name('addtocart');
Route::delete('cart/remove', [OrderController::class, 'RemoveItem'])->name('removeitem');
Route::post('/cart/update', [OrderController::class, 'UpdateItem'])->name('updateitem');

Route::prefix('user')->middleware(['user', User::class])->group(function () {
    Route::get('/checkout', [OrderController::class, 'Checkout'])->name('checkout');
    Route::post('/checkout/method', [OrderController::class,'CheckoutMethod'])->name('checkoutmethod');
    Route::get('/checkout/success-vnpay', [OrderController::class, 'CheckoutSuccessVNPAY'])->name('checkoutsuccessvnpay');


    Route::get('/infor', [UserController::class, 'InforUser'])->name('inforuser');
    Route::post('/edit', [UserController::class, 'EditUser'])->name('edituser');
    Route::get('/delete-address-{id}', [UserController::class, 'DeleteAddress'])->name('deleteaddress');
    Route::put('/change-password', [UserController::class, 'ChangePassword'])->name('changepassworduser');
});




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

    //Product
    Route::controller(AdminSanphamController::class)->group(function () {
        Route::get('/all/product', 'AllProduct')->name('all.product')->middleware('permission:allProduct');
        Route::get('/add/product', 'AddProduct')->name('add.product')->middleware('permission:addProduct');
        Route::post('/store/product', 'StoreProduct')->name('store.product')->middleware('permission:addProduct');
        Route::get('/edit/product/{id}', 'EditProduct')->name('edit.product')->middleware('permission:editProduct');
        Route::post('/update/product/{id}', 'UpdateProduct')->name('update.product')->middleware('permission:editProduct');
        Route::get('/delete/product/{id}', 'DeleteProduct')->name('delete.product')->middleware('permission:deleteProduct');
        Route::get('/delete/product-image/{id}', 'DeleteProductImage')->name('delete.productimage')->middleware('permission:editProduct');

        Route::get('/export/product', 'Export')->name('export.product');
    });

    //Category
    Route::controller(AdminCategoryController::class)->group(function () {
        Route::get('/all/category', 'AllCategory')->name('all.category')->middleware('permission:allCategory');
        Route::get('/add/category', 'AddCategory')->name('add.category')->middleware('permission:addCategory');
        Route::post('/store/category', 'StoreCategory')->name('store.category')->middleware('permission:addCategory');
        Route::get('/edit/category/{id}', 'EditCategory')->name('edit.category')->middleware('permission:editCategory');
        Route::post('/update/category', 'UpdateCategory')->name('update.category')->middleware('permission:editCategory');
        Route::get('/delete/category/{id}', 'DeleteCategory')->name('delete.category')->middleware('permission:deleteCategory');

    });

    //Brand
    Route::controller(AdminBrandController::class)->group(function () {
        Route::get('/all/brand', 'AllBrand')->name('all.brand')->middleware('permission:allBrand');
        Route::get('/add/brand', 'AddBrand')->name('add.brand')->middleware('permission:addBrand');
        Route::post('/store/brand', 'StoreBrand')->name('store.brand')->middleware('permission:addBrand');
        Route::get('/edit/brand/{id}', 'EditBrand')->name('edit.brand')->middleware('permission:editBrand');
        Route::post('/update/brand', 'UpdateBrand')->name('update.brand')->middleware('permission:editBrand');
        Route::get('/delete/brand/{id}', 'DeleteBrand')->name('delete.brand')->middleware('permission:deleteBrand');

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

    //Order
    Route::controller(AdminOrderController::class)->group(function () {
        Route::get('/all/order', 'AllOrder')->name('all.order')->middleware('permission:allOrder');
        Route::post('/update/order-pending', 'UpdateOrderPending')->name('update.orderpending')->middleware('permission:allOrder');
        Route::post('/update/order-onway', 'UpdateOrderOnWay')->name('update.orderonway')->middleware('permission:allOrder');
    });
});

