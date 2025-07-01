<?php

use App\Http\Controllers\DatabaseController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ComponentController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\LogController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\StaticController;
use App\Http\Controllers\UserController;

// // // Mật khẩu bạn muốn mã hóa
// $password = 'admin';  // Thay thế bằng mật khẩu thực tế

// // // Mã hóa mật khẩu với bcrypt
// $hashedPassword = password_hash($password, PASSWORD_BCRYPT);

// // // In ra mã băm để bạn có thể sao chép
// echo $hashedPassword;

Route::get('/', [AuthController::class, 'login'])->name('auth.login');
Route::post('login', [AuthController::class, 'loginpost'])->name('auth.loginpost');


Route::middleware('auth')->group(function () {

    // 1. Route Đăng nhập và đăng xuất
    Route::get('logout', [AuthController::class, 'logout'])->name('auth.logout');
    Route::post('logout', [AuthController::class, 'logoutpost'])->name('auth.logoutpost');

    // 2. Route Phân quyền vai trò và quyền hạn
    Route::get('/roles', [RoleController::class, 'index'])->name('roles.index')->middleware('permission:view_roles');
    Route::get('/roles/create', [RoleController::class, 'create'])->name('roles.create');
    Route::post('/roles', [RoleController::class, 'store'])->name('roles.store');
    Route::get('/roles/{role}/permissions', [RoleController::class, 'edit'])->name('roles.permissions.edit')->middleware('permission:detail_roles');
    Route::put('/roles/{role}/permissions', [RoleController::class, 'update'])->name('roles.permissions.update')->middleware('permission:edit_roles');

    // 3. Route Bảng điều khiển và nhật ký
    Route::get('/index', [DashboardController::class, 'index'])->name('index');
    Route::get('/logs', [LogController::class, 'index'])->name('logs.index');

    // 4. Route Quản lý người dùng
    Route::get('/users', [UserController::class, 'index'])->name('users.index');
    Route::get('/users/{user}', [UserController::class, 'show'])->name('users.show');
    Route::get('/users/{user}/roles', [UserController::class, 'editRoles'])->name('users.edit-roles');
    Route::put('/users/{user}/roles', [UserController::class, 'updateRoles'])->name('users.update-roles');

    // 5. Route Người dùng quản lý profile
    Route::get('/profile/{user}/avatar/edit', [ProfileController::class, 'editAvatar'])->name('profile.edit-avatar');
    Route::put('/profile/{user}/avatar/update',  [ProfileController::class, 'updateAvatar'])->name('profile.update-avatar');
    Route::get('/profile/{user}/alias/edit', [ProfileController::class, 'editAlias'])->name('profile.edit-alias');
    Route::put('/profile/{user}/alias/update', [ProfileController::class, 'updateAlias'])->name('profile.update-alias');
    Route::get('/profile/{user}/password/edit', [ProfileController::class, 'editPassword'])->name('profile.edit-password');
    Route::put('/profile/{user}/password/update', [ProfileController::class, 'updatePassword'])->name('profile.update-password');

    // 6. Route Tải về danh sách linh kiện
    Route::get('/components/download', [ComponentController::class, 'download'])->name('components.download');

    // 7. Route Xuất kho và thu hồi linh kiện
    Route::get('/components/{component}/export/confirm', [ComponentController::class, 'exportConfirm'])->name('components.exportConfirm');
    Route::put('/components/{component}/export', [ComponentController::class, 'exportpost'])->name('components.exportpost');
    Route::put('/components/{component}/recall', [ComponentController::class, 'recallpost'])->name('components.recallpost');

    // 8. Route Xem danh sách linh kiện
    Route::get('/components', [ComponentController::class, 'index'])->name('components.index');
    Route::get('/components/export', [ComponentController::class, 'export'])->name('components.export');
    Route::get('/components/stock', [ComponentController::class, 'stock'])->name('components.stock');

    // 9. Route CRUD dữ liệu linh kiện
    Route::get('/components/create', [ComponentController::class, 'create'])->name('components.create');
    Route::post('/components', [ComponentController::class, 'store'])->name('components.store');
    Route::get('/components/{component}', [ComponentController::class, 'show'])->name('components.show');
    Route::get('/components/{component}/edit', [ComponentController::class, 'edit'])->name('components.edit');
    Route::put('/components/{component}', [ComponentController::class, 'update'])->name('components.update');
    Route::delete('/components/{component}', [ComponentController::class, 'destroy'])->name('components.destroy');

    // 10. Route Thống kê
    Route::get('/static', [StaticController::class, 'index'])->name('static.index');

    // 11. Route Tải về danh sách linh kiện
    Route::get('/logs/download', [LogController::class, 'download'])->name('logs.download');
});

// Route kiểm tra kết nối database (system)
Route::get('/check-database', [DatabaseController::class, 'checkDatabaseConnection']);
