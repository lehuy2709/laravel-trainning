<?php

use App\Http\Controllers\FacultyController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\LanguageController;
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
    Route::post('student/quick-add', [StudentController::class,'quickAdd'])->name('quickAdd');
    Route::get('update-point/{id}', [StudentController::class,'updatePoint'])->name('updatePoint');
    Route::get('export/{id}', [SubjectController::class,'exportPoint'])->name('exportPoint');
    Route::post('import/{id}', [SubjectController::class,'importPoint'])->name('importPoint');
    Route::get('view-point/{id}', [SubjectController::class,'viewPoint'])->name('viewPoint');
    Route::get('get-subject-value/{id}', [StudentController::class,'getValueSubject'])->name('getValueSubject');
    Route::get('student/{id}/subject-detail', [StudentController::class,'subjectDetail'])->name('subject.detail');
    Route::put('student/{id}/point', [StudentController::class,'studentPoint'])->name('student.point');


});

Route::middleware('auth', 'permission:read')->group(function () {
    Route::resource('faculties', FacultyController::class)->only('index');
    Route::resource('subjects', SubjectController::class)->only('index');
    Route::get('home', [HomeController::class, 'index'])->name('home');
    Route::post('student/{id}/update', [HomeController::class, 'updateStudent'])->name('updateStudent');
    Route::post('student/change', [HomeController::class, 'changeAvatar'])->name('changeAvatar');
    Route::post('send-mail/{id}', [SubjectController::class, 'sendMail'])->name('sendMail');
    Route::post('send-mail-all', [SubjectController::class, 'sendMailAll'])->name('sendMailAll');
    Route::put('register-faculty/{id}', [FacultyController::class, 'registerFaculty'])->name('registerFaculty');
});
Route::post('register-subject', [StudentController::class, 'regSubject'])->name('registerSubject');
Route::get('lang/{lang}', [LanguageController::class,'switchLang'])->name('lang.switch');
Auth::routes();



Route::get('/', [App\Http\Controllers\HomeController::class, 'index']);
