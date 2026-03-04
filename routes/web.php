<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AttendanceController;
use App\Http\Controllers\LeaveController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/register',[AuthController::class,'showRegister']);
Route::post('/register',[AuthController::class,'register']);

Route::get('/login',[AuthController::class,'showLogin'])->name('login');
Route::post('/login',[AuthController::class,'login']);
Route::post('/logout',[AuthController::class,'logout']);


    // Admin Routes
    Route::middleware(['auth', 'role:Admin'])->group(function () {
        Route::get('/admin/dashboard', function () {
            return view('admin.dashboard');
        });
        Route::get('/admin/attendance/today', [App\Http\Controllers\Admin\AttendanceReportController::class, 'today'])->name('attendance.today');
         Route::get('/admin/leaves', [App\Http\Controllers\Admin\LeaveRequestController::class, 'index'])
        ->name('admin.leaves.index');
        Route::post('/admin/leaves/{leave}/approve', [App\Http\Controllers\Admin\LeaveRequestController::class, 'approve'])
        ->name('admin.leaves.approve');
        Route::post('/admin/leaves/{leave}/reject', [App\Http\Controllers\Admin\LeaveRequestController::class, 'reject'])
        ->name('admin.leaves.reject');

        Route::get('/admin/users', [App\Http\Controllers\Admin\UserController::class, 'index'])->name('users.index');
        Route::post('/admin/users/{user}/role', [App\Http\Controllers\Admin\UserController::class, 'updateRole'])->name('admin.users.updateRole');
        Route::delete('/admin/users/{user}', [App\Http\Controllers\Admin\UserController::class, 'destroy'])->name('admin.users.destroy');
        });

    // User Routes
    Route::middleware(['auth',  'role:HR|Teacher|User'])->group(function () {
        Route::get('/user/dashboard', function () {return view('user.dashboard');});
        Route::get('/user/myAttendance', function () {
            return view('user.myAttendance');
        });
        Route::post('attendances/mark', [AttendanceController::class, 'mark'])->name('attendances.mark');
        Route::get('user/dashboard', [AttendanceController::class, 'index'])->name('user.dashboard');
        Route::get('user/myAttendance', [AttendanceController::class, 'myAttendance'])->name('user.myAttendance');
        Route::resource('user/leaves', LeaveController::class)->only(['index', 'show','create', 'store','edit','destroy'])
    ->names('user.leaves');
    });

