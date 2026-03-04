<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/register',[AuthController::class,'showRegister']);
Route::post('/register',[AuthController::class,'register']);

Route::get('/login',[AuthController::class,'showLogin'])->name('login');
Route::post('/login',[AuthController::class,'login']);
Route::post('/logout',[AuthController::class,'logout']);

Route::middleware(['auth'])->group(function () {

    Route::get('/admin/dashboard', function () {
        if(auth()->user()->role != 'admin'){
            abort(403);
        }
        return view('admin.dashboard');
    });

    Route::get('/user/dashboard', function () {
        if(auth()->user()->role != 'user'){
            abort(403);
        }
        return view('user.dashboard');
    });

});