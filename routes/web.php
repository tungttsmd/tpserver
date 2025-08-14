<?php

use App\Exports\UserLogsExport;
use App\Exports\VendorsExport;
use App\Http\Controllers\DatabaseController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ComponentController;
use App\Http\Controllers\PanelController;
use App\Http\Controllers\ComponentExportLogController;
use App\Http\Controllers\UserLogController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ComponentRecallLogController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\StaticController;
use App\Http\Controllers\UserController;
use Maatwebsite\Excel\Facades\Excel;

// // // Mật khẩu bạn muốn mã hóa
// $password = 'admin';  // Thay thế bằng mật khẩu thực tế

// // // Mã hóa mật khẩu với bcrypt
// $hashedPassword = password_hash($password, PASSWORD_BCRYPT);

// // // In ra mã băm để bạn có thể sao chép
// echo $hashedPassword;

Route::get('/', [AuthController::class, 'login'])->name('auth.login');
Route::post('login', [AuthController::class, 'loginpost'])->name('auth.loginpost');


Route::middleware('auth')->group(function () {

    // Livewire: tải xuống
    Route::get('/vendors/download', function () {
        return Excel::download(new VendorsExport, 'vendors.xlsx');
    })->name('vendors.download');
    Route::get('/user-logs/download', function () {
        return Excel::download(new UserLogsExport, 'user-logs.xlsx');
    })->name('user-logs.download');

    // 1. Đăng xuất
    Route::get('logout', [AuthController::class, 'logout'])->name('auth.logout');
    Route::post('logout', [AuthController::class, 'logoutpost'])->name('auth.logoutpost');

    // 2. Quản lý vai trò và phân quyền
    Route::get('/roles', [RoleController::class, 'index'])->name('roles.index')->middleware('permission:role.view');
    Route::get('/roles/create', [RoleController::class, 'create'])->name('roles.create')->middleware('permission:role.create');
    Route::post('/roles/create', [RoleController::class, 'store'])->name('roles.store')->middleware('permission:role.create');
    Route::get('/roles/{role}/permissions', [RoleController::class, 'edit'])->name('roles.permissions.edit')->middleware('permission:role.update');
    Route::put('/roles/{role}/permissions', [RoleController::class, 'update'])->name('roles.permissions.update')->middleware('permission:role.update');

    // 3. Dashboard và logs (chung cho admin hoặc user có quyền xem logs)
    Route::get('/index', [PanelController::class, 'index'])->name('index')->middleware('permission:dashboard.view');
    Route::get('/logs', [UserLogController::class, 'index'])->name('logs.index')->middleware('permission:log.view');
    Route::get('/export-logs', [ComponentExportLogController::class, 'index'])->name('logs.index-component-export')->middleware('permission:component.download_log');
    Route::get('/recall-logs', [ComponentRecallLogController::class, 'index'])->name('logs.index-component-recall')->middleware('permission:component.download_log');

    // 4. Quản lý người dùng
    Route::get('/users', [UserController::class, 'index'])->name('users.index')->middleware('permission:user.view');
    Route::get('/users/{user}', [UserController::class, 'show'])->name('users.show')->middleware('permission:user.view');
    Route::get('/users/{user}/roles', [UserController::class, 'editRoles'])->name('users.edit-roles')->middleware('permission:user.assign_role');
    Route::put('/users/{user}/roles', [UserController::class, 'updateRoles'])->name('users.update-roles')->middleware('permission:user.assign_role');

    // 5. Profile cá nhân (user tự chỉnh sửa)
    Route::get('/profile/{user}/avatar/edit', [ProfileController::class, 'editAvatar'])->name('profile.edit-avatar')->middleware('permission:user.update');
    Route::put('/profile/{user}/avatar/update', [ProfileController::class, 'updateAvatar'])->name('profile.update-avatar')->middleware('permission:user.update');
    Route::get('/profile/{user}/alias/edit', [ProfileController::class, 'editAlias'])->name('profile.edit-alias')->middleware('permission:user.update');
    Route::put('/profile/{user}/alias/update', [ProfileController::class, 'updateAlias'])->name('profile.update-alias')->middleware('permission:user.update');
    Route::get('/profile/{user}/password/edit', [ProfileController::class, 'editPassword'])->name('profile.edit-password')->middleware('permission:user.update');
    Route::put('/profile/{user}/password/update', [ProfileController::class, 'updatePassword'])->name('profile.update-password')->middleware('permission:user.update');

    // 6. Tải về danh sách linh kiện
    Route::get('/components/download', [ComponentController::class, 'download'])->name('components.download')->middleware('permission:component.download_log');

    // 7. Scan linh kiện
    Route::get('/components/scan', [ComponentController::class, 'scan'])->name('components.scan')->middleware('permission:component.scan_qr');
    Route::post('components/scan', [ComponentController::class, 'scanpost'])->name('components.scanpost')->middleware('permission:component.scan_qr');

    // 8. Xuất kho và thu hồi linh kiện
    Route::get('/components/{component}/export/confirm', [ComponentController::class, 'exportConfirm'])->name('components.exportConfirm')->middleware('permission:component.issue');
    Route::put('/components/{component}/export', [ComponentController::class, 'exportpost'])->name('components.exportpost')->middleware('permission:component.issue');
    Route::put('/components/{component}/recall', [ComponentController::class, 'recallpost'])->name('components.recallpost')->middleware('permission:component.recall');

    // 9. Xem danh sách linh kiện
    Route::get('/components', [ComponentController::class, 'index'])->name('components.index')->middleware('permission:component.view');
    Route::get('/components/export', [ComponentController::class, 'export'])->name('components.export')->middleware('permission:component.view');
    Route::get('/components/stock', [ComponentController::class, 'stock'])->name('components.stock')->middleware('permission:component.view');

    // 10. CRUD linh kiện
    Route::get('/components/create', [ComponentController::class, 'create'])->name('components.create')->middleware('permission:component.create');
    Route::post('/components', [ComponentController::class, 'store'])->name('components.store')->middleware('permission:component.create');
    Route::get('/components/{component}', [ComponentController::class, 'show'])->name('components.show')->middleware('permission:component.view');
    Route::get('/components/{component}/edit', [ComponentController::class, 'edit'])->name('components.edit')->middleware('permission:component.update');
    Route::put('/components/{component}', [ComponentController::class, 'update'])->name('components.update')->middleware('permission:component.update');
    Route::delete('/components/{component}', [ComponentController::class, 'destroy'])->name('components.destroy')->middleware('permission:component.delete');

    // 11. Thống kê
    Route::get('/static', [StaticController::class, 'index'])->name('static.index')->middleware('permission:dashboard.view');

    // 12. Tải về logs người dùng
    Route::get('/logs/download', [UserLogController::class, 'download'])->name('logs.download')->middleware('permission:user.download_log');
});
