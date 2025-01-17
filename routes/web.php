<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\Dashboard\Users\UserController;
use App\Http\Controllers\User\HomeController;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\Request;
use App\Http\Controllers\Admin\Dashboard\Product\ProductControllder;
use App\Http\Controllers\Admin\Dashboard\Category\CategoryControllder;
use App\Http\Controllers\Admin\Dashboard\Order\OrderController;
use App\Http\Controllers\Admin\Dashboard\Warehouse\WarehouseController;
use Illuminate\Support\Facades\Auth;

// Dashboard
//, 'verified'
Route::middleware(['role:1'])->prefix('dashboard')->group(function () {

    Route::get('/home', [DashboardController::class, 'index'])->name('dashboard.index');

    Route::prefix('/user')->group(function () {
        Route::get('/', [UserController::class, 'index'])->name('dashboard.user.index');

        // hiển thị trang chỉnh sửa thông tin users
        Route::get('/{id}/edit', [UserController::class, 'edit'])->name('dashboard.user.edit');

        // cập nhật thông tin người users
        Route::put('/{id}', [UserController::class, 'update'])->name('dashboard.user.update');

        // route add user
        Route::get('/create', [UserController::class, 'create'])->name('dashboard.user.create');

        //thêm vào CSDL
        Route::post('/store', [UserController::class, 'store'])->name('dashboard.user.store');

        //xóa user
        Route::delete('/{id}', [UserController::class, 'destroy'])->name('dashboard.user.destroy');
    });

    Route::prefix('category')->group(function () {
        // Danh sách các danh mục
        Route::get('/', [CategoryControllder::class, 'index'])->name('dashboard.category.index');

        // Hiển thị form tạo danh mục
        Route::get('/create', [CategoryControllder::class, 'create'])->name('dashboard.category.create');

        // Lưu danh mục mới
        Route::post('/store', [CategoryControllder::class, 'store'])->name('dashboard.category.store');

        // Hiển thị form chỉnh sửa danh mục
        Route::get('/{id}/edit', [CategoryControllder::class, 'edit'])->name('dashboard.category.edit');

        // Cập nhật danh mục
        Route::put('/{id}', [CategoryControllder::class, 'update'])->name('dashboard.category.update');

        // Xóa danh mục
        Route::delete('{CategoryId}', [CategoryControllder::class, 'destroy'])->name('dashboard.category.destroy');

        // show product
        Route::get('showProduct/{CategoryId}', [CategoryControllder::class, 'showProduct'])->name('dashboard.category.showProduct');
    });


    Route::prefix('product')->group(function () {

        // Danh sách các danh mục
        Route::get('/', [ProductControllder::class, 'index'])->name('dashboard.product.index');

        // Hiển thị form tạo danh mục
        Route::get('/create', [ProductControllder::class, 'create'])->name('dashboard.product.create');

        // Lưu danh mục mới
        Route::post('/store', [ProductControllder::class, 'store'])->name('dashboard.product.store');

        // Hiển thị form chỉnh sửa danh mục
        Route::get('/{ProductId}/edit', [ProductControllder::class, 'edit'])->name('dashboard.product.edit');

        // update product
        Route::put('/{ProductId}', [ProductControllder::class, 'update'])->name('dashboard.product.update');

        // Xóa danh mục
        Route::delete('{ProductId}', [ProductControllder::class, 'destroy'])->name('dashboard.product.destroy');
    });
    Route::prefix('order')->group(function () {

        // Danh sách các danh mục
        Route::get('/', [OrderController::class, 'index'])->name('dashboard.order.index');

        // Hiển thị form tạo danh mục
       /* Route::get('/create', [ProductControllder::class, 'create'])->name('dashboard.product.create');

        // Lưu danh mục mới
        Route::post('/store', [ProductControllder::class, 'store'])->name('dashboard.product.store');

        // Hiển thị form chỉnh sửa danh mục
        Route::get('/{ProductId}/edit', [ProductControllder::class, 'edit'])->name('dashboard.product.edit');

        // update product
        Route::put('/{ProductId}', [ProductControllder::class, 'update'])->name('dashboard.product.update');

        // Xóa danh mục
        Route::delete('{ProductId}', [ProductControllder::class, 'destroy'])->name('dashboard.product.destroy');*/
    });
    Route::prefix('Warehouse')->group(function () {

        // warehouse
        Route::get('/', [WarehouseController::class, 'index'])->name('dashboard.warehouse.index');
        Route::get('/{id}/edit', [WarehouseController::class, 'edit'])->name('dashboard.warehouse.edit');
        Route::put('/{id}', [WarehouseController::class, 'update'])->name('dashboard.warehouse.update');

    });
})->name('dashboard');


// Client

Route::prefix('/')->group(function () {
    Route::prefix('/')->group(function () {
        Route::get('/home', [HomeController::class, 'checkRoleUser'])->name('checkRole');
        Route::get('/trang-chu', [HomeController::class, 'home'])->name('home');
        Route::get('/tin-tuc', 'App\Http\Controllers\User\BlogController@index')->name('tin-tuc');
        Route::get('/san-pham', 'App\Http\Controllers\User\ProductController@index')->name('san-pham');
        Route::get('/danh-muc', 'App\Http\Controllers\User\CategoryController@index')->name('danh-muc');
        Route::get('/gio-hang', 'App\Http\Controllers\User\CartController@index')->name('gio-hang');
        Route::get('/thanh-toan', 'App\Http\Controllers\User\CheckoutController@index')->name('thanh-toan');
    });
    // Quản lí tài khoản
    Route::prefix('/afterlogin')->group(function () {
        Route::get('quan-li-tai-khoan', 'App\Http\Controllers\User\ManagerUser\ManagerUserController@index')->name('manageruser');
        Route::get('don-hang-cua-ban', 'App\Http\Controllers\User\ManagerUser\ManagerOderController@index')->name('manageroder');
        Route::get('quan-li-so-dia-chi', 'App\Http\Controllers\User\ManagerUser\ManagerAddressController@index')->name('manageraddress');
    })->name('afterLogin');
});

Auth::routes();


// Route::get('/email/verify', function () {
//     return view('auth.verify-email');
// })->middleware('auth')->name('verification.notice');

// Route::get('/email/verify/{id}/{hash}', function (EmailVerificationRequest $request) {
//     $request->fulfill();

//     return redirect('/home');
// })->middleware(['auth', 'signed'])->name('verification.verify');

// Route::post('/email/verification-notification', function (Request $request) {
//     $request->user()->sendEmailVerificationNotification();

//     return back()->with('message', 'Verification link sent!');
// })->middleware(['auth', 'throttle:6,1'])->name('verification.send');
