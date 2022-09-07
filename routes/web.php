<?php

use App\Http\Controllers\FacultyController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\SubjectController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::middleware(['auth', 'role:admin'])->get('admin', function () {
    return view('admin.dashboard.index');
});

Route::middleware('auth', 'role:admin')->group(function () {
    Route::resources([
        'faculties' => FacultyController::class,
        'subjects' => SubjectController::class,
        'students' => StudentController::class,
    ]);
});

Route::middleware('auth','permission:read')->group(function () {
    Route::resource('faculties', FacultyController::class)->only('index');
    Route::resource('subjects', SubjectController::class)->only('index');

});
Route::get('register-subject/{id}', [StudentController::class, 'regSubject'])->name('registerSubject');
Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::get('/', [App\Http\Controllers\HomeController::class, 'index']);

