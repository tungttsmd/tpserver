<?php

use App\Http\Controllers\AuthController;
use App\Http\Livewire\Features\Components\ComponentCreateLivewire;
use App\Http\Livewire\Features\Components\ComponentIndexLivewire;
use App\Http\Livewire\Features\Components\ComponentScanLivewire;
use App\Http\Livewire\Features\Customers\CustomerCreateLivewire;
use App\Http\Livewire\Features\Customers\CustomerIndexLivewire;
use App\Http\Livewire\Features\Exports\ExportLivewire;
use App\Http\Livewire\Features\Locations\LocationCreateLivewire;
use App\Http\Livewire\Features\Locations\LocationIndexLivewire;
use App\Http\Livewire\Features\Logs\LogItemLivewire;
use App\Http\Livewire\Features\Logs\LogUserLivewire;
use App\Http\Livewire\Features\Roles\RoleAuthorizeLivewire;
use App\Http\Livewire\Features\Roles\RoleIndexLivewire;
use App\Http\Livewire\Features\Roles\RoleCreateLivewire;
use App\Http\Livewire\Features\Users\UserCreateLivewire;
use App\Http\Livewire\Features\Users\UserIndexLivewire;
use App\Http\Livewire\Features\Vendors\VendorCreateLivewire;
use App\Http\Livewire\Features\Vendors\VendorIndexLivewire;
use App\Http\Livewire\Features\Stats\StatIndexLivewire;
use App\Http\Livewire\Features\Stats\StatStockVariationLivewire;
use Illuminate\Support\Facades\Route;

// Xác thực
Route::get('/', [AuthController::class, 'login'])->name('auth.login');
Route::post('/', [AuthController::class, 'loginpost'])->name('auth.loginpost');
Route::middleware('auth')->group(function () {
    Route::get('/logout', [AuthController::class, 'logout'])->name('auth.logout');
    Route::post('/logout', [AuthController::class, 'logoutpost'])->name('auth.logoutpost');
});

// Đã xác thực
Route::middleware('auth')->group(function () {

    // Khối linh kiện
    Route::prefix('item')->group(function () {
        Route::get('/create', ComponentCreateLivewire::class)
            ->name('item.create')->middleware(['permission:item.create']);
        Route::get('/scan', ComponentScanLivewire::class)
            ->name('item.scan')->middleware(['permission:item.scan']);
        Route::get('/index', ComponentIndexLivewire::class)
            ->name('item.index')->middleware(['permission:item.index']);
        Route::get('/stockout', ComponentIndexLivewire::class)
            ->name('item.stockout')->middleware(['permission:item.index']);
    });

    // Khối khách hàng
    Route::prefix('customer')->group(function () {
        Route::get('/create', CustomerCreateLivewire::class)
            ->name('customer.create')->middleware(['permission:customer.create']);
        Route::get('/index', CustomerIndexLivewire::class)
            ->name('customer.index')->middleware(['permission:customer.index']);
    });

    // Khối nhà cung cấp
    Route::prefix('vendor')->group(function () {
        Route::get('/create', VendorCreateLivewire::class)
            ->name('vendor.create')->middleware(['permission:vendor.create']);
        Route::get('/index', VendorIndexLivewire::class)
            ->name('vendor.index')->middleware(['permission:vendor.index']);
    });

    // Khối vị trí kho
    Route::prefix('location')->group(function () {
        Route::get('/create', LocationCreateLivewire::class)
            ->name('location.create')->middleware(['permission:location.create']);
        Route::get('/index', LocationIndexLivewire::class)
            ->name('location.index')->middleware(['permission:location.index']);
    });

    // Khối tải xuống file
    Route::prefix('export')->group(function () {
        Route::get('/index', ExportLivewire::class)
            ->name('export.index')->middleware(['permission:export.index']);
    });

    // Khối nhật ký
    Route::prefix('log')->group(function () {
        Route::get('/users', LogUserLivewire::class)
            ->name('log.users')->middleware(['permission:log.users']);
        Route::get('/items', LogItemLivewire::class)
            ->name('log.items')->middleware(['permission:log.items']);
    });

    // Khối người dùng
    Route::prefix('user')->group(function () {
        Route::get('/index', UserIndexLivewire::class)
            ->name('user.index')
            ->middleware(['permission:user.index']);
        Route::get('/create', UserCreateLivewire::class)
            ->name('user.create')
            ->middleware(['permission:user.create']);
    });

    // Khối phân quyền
    Route::prefix('role')->group(function () {
        Route::get('/index', RoleIndexLivewire::class)
            ->name('role.index')
            ->middleware(['permission:role.index']);
        Route::get('/authorize', RoleAuthorizeLivewire::class)
            ->name('role.authorize')
            ->middleware(['permission:role.authorize']);
        Route::get('/create', RoleCreateLivewire::class)
            ->name('role.create')
            ->middleware(['permission:role.create']);
    });

    // Khối thống kê
    Route::prefix('stats')->group(function () {
        Route::get('/', StatIndexLivewire::class)
            ->name('stats.index');
            // ->middleware(['permission:stats.view']);
        Route::get('/stock-variation', StatStockVariationLivewire::class)
            ->name('stats.stock-variation');
            // ->middleware(['permission:stats.view']);
    });
});
