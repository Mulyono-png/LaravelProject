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
use App\Http\Controllers\SubjectController;
use App\Http\Controllers\TeacherController;

Route::get('/admin/about', [AboutController::class, 'index']);
Route::get('/admin/student', [StudentController::class, 'index'])->name('admin.student.index');
Route::get('/admin/student/create', [StudentController::class, 'create'])->name('admin.student.create');
Route::post('/admin/student', [StudentController::class, 'store'])->name('admin.student.store');
Route::get('/admin/student/{student}/edit', [StudentController::class, 'edit'])->name('admin.student.edit');
Route::put('/admin/student/{student}', [StudentController::class, 'update'])->name('admin.student.update');
Route::delete('/admin/student/{student}', [StudentController::class, 'destroy'])->name('admin.student.destroy');
Route::get('/admin/classroom', [ClassroomController::class, 'index'])->name('admin.classroom');

Route::prefix('admin')->name('admin.')->group(function () {
    Route::resource('teacher', TeacherController::class)->except(['show']);
    Route::resource('subject', SubjectController::class)->except(['show']);
});
