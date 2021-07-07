<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\School\ActivityOverviewController;
use App\Http\Controllers\School\StudentOverviewController;
use App\Http\Controllers\School\StudentsController;
use App\Http\Controllers\SportService\ActivityController;
use App\Http\Controllers\SportService\ProviderController;
use App\Http\Controllers\SportService\AddSchoolController;
use App\Http\Controllers\SportService\AddTeacherController;
use App\Http\Controllers\SportService\LinkSchoolActivityController;
use App\Http\Controllers\SportService\UserOverviewController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| These routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group.
*/

// When the 'guest' enters the website it will automatically redirect to the login page
Route::redirect('/', '/login');

Route::middleware(['auth:sanctum', 'verified'])->get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

// School endpoints
Route::group(['middleware' => 'auth'], function () {
    // To add student to the database / application
    Route::get('/students', [StudentsController::class, 'index'])->name('students');
    Route::post('/students', [StudentsController::class, 'store']);

    // All endpoints related to activities
    Route::get('/activity-overview', [ActivityOverviewController::class, 'index'])->name('activity-overview');

    // All endpoints related to student overview
    Route::get('/student-overview', [StudentOverviewController::class, 'index'])->name('student-overview');
    Route::delete('/student-overview/{student}', [StudentOverviewController::class, 'destroy'])->name('student-overview.destroy');
    Route::get('/student-overview/{student}/edit', [StudentOverviewController::class, 'edit'])->name('student-overview.edit');
    Route::put('/student-overview/{student}', [StudentOverviewController::class, 'update'])->name('student-overview.update');
});

// SportService endpoints
Route::group(['middleware' => 'auth'], function () {
    // To add school to the database / application
    Route::get('/add-schools', [AddSchoolController::class, 'index'])->name('add-schools');
    Route::post('/add-schools', [AddSchoolController::class, 'store']);

    // To add providers for the sport activities
    Route::get('/add-providers', [ProviderController::class, 'index'])->name('add-providers');
    Route::post('/add-providers', [ProviderController::class, 'store']);

    // To add Teachers for Schools
    Route::get('/add-teachers', [AddTeacherController::class, 'index'])->name('add-teachers');
    Route::post('/add-teachers', [AddTeacherController::class, 'store']);

    // To add activity to the database
    Route::get('/enter-activity', [ActivityController::class, 'index'])->name('enter-activity');
    Route::post('/enter-activity', [ActivityController::class, 'store']);

    // All endpoints related to User overview
    Route::get('/user-overview', [UserOverviewController::class, 'index'])->name('user-overview');
    Route::delete('/user-overview/{school}', [UserOverviewController::class, 'destroy'])->name('user-overview.destroy');
    Route::delete('/delete-teacher/{teacher}', [UserOverviewController::class, 'destroyTeacher'])->name('delete-teacher');

    // All endpoints to link activity to a school
    Route::get('/linkschool', [LinkSchoolActivityController::class, 'index'])->name('link-school-activity');
});

require_once __DIR__ . '/jetstream.php';
require_once __DIR__ . '/fortify.php';
