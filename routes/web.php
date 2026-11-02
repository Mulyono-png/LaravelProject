<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/home', function () {
    return view('home');
});

Route::get('/about', function () {
    return view('about');
});

Route::get('/layout', function () {
    return view('layout');
});

Route::get('/admin/dashboard', function () {
    return view('admin.dashboard');
});

use App\Http\Controllers\AboutController;
use App\Http\Controllers\ClassroomController;
use App\Http\Controllers\StudentController;

Route::get('/admin/about', [AboutController::class, 'index']);
Route::get('/admin/student', [StudentController::class, 'index']);
Route::get('/admin/classroom', [ClassroomController::class, 'index'])->name('admin.classroom');
