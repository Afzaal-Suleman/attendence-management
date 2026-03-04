<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AttendanceController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/register',[AuthController::class,'showRegister']);
Route::post('/register',[AuthController::class,'register']);

Route::get('/login',[AuthController::class,'showLogin'])->name('login');
Route::post('/login',[AuthController::class,'login']);
Route::post('/logout',[AuthController::class,'logout']);


    // Admin Routes
    Route::middleware(['auth', 'role:admin'])->group(function () {
        Route::get('/admin/dashboard', function () {
            return view('admin.dashboard');
        });
    });

    // User Routes
    Route::middleware(['auth', 'role:user'])->group(function () {
        Route::get('/user/dashboard', function () {
            return view('user.dashboard');
        });
        Route::get('/user/myAttendance', function () {
            return view('user.myAttendance');
        });
        Route::post('attendances/mark', [AttendanceController::class, 'mark'])->name('attendances.mark');
        Route::get('user/dashboard', [AttendanceController::class, 'index'])->name('user.dashboard');
        Route::get('user/myAttendance', [AttendanceController::class, 'myAttendance'])->name('user.myAttendance');
    });
