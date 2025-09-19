<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

use Illuminate\Support\Facades\Auth;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    $role = Auth::user()->role->name;
    switch ($role) {
        case 'admin':
            return redirect()->route('admin.dashboard');
        case 'guru':
            return redirect()->route('teacher.dashboard');
        case 'siswa':
            return redirect()->route('student.dashboard');
        default:
            return view('dashboard');
    }
})->middleware(['auth', 'verified'])->name('dashboard');

// Admin Routes
Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::post('/dashboard/prompt', [\App\Http\Controllers\Admin\DashboardController::class, 'handlePrompt'])->name('dashboard.prompt');
    Route::get('/dashboard', [\App\Http\Controllers\Admin\DashboardController::class, 'index'])->name('dashboard');
    Route::resource('users', \App\Http\Controllers\Admin\UserController::class);
    Route::resource('classes', \App\Http\Controllers\SchoolClassController::class);
    Route::resource('classes.subjects', \App\Http\Controllers\Admin\ClassSubjectController::class)->except(['show']);
    Route::resource('subjects', \App\Http\Controllers\Admin\SubjectController::class);
    Route::get('/attendance', [\App\Http\Controllers\Admin\AttendanceController::class, 'index'])->name('attendance.index');
    Route::get('/attendance/export', [\App\Http\Controllers\Admin\AttendanceController::class, 'export'])->name('attendance.export');
    Route::post('/absence-submissions/summarize', [\App\Http\Controllers\Admin\AbsenceSubmissionController::class, 'summarize'])->name('absence-submissions.summarize');
    Route::resource('absence-submissions', \App\Http\Controllers\Admin\AbsenceSubmissionController::class)->only(['index', 'update']);
});

// Teacher Routes
Route::middleware(['auth', 'role:guru'])->prefix('teacher')->name('teacher.')->group(function () {
    Route::get('/dashboard', [\App\Http\Controllers\Teacher\DashboardController::class, 'index'])->name('dashboard');
    Route::resource('subjects', \App\Http\Controllers\Admin\SubjectController::class);
    Route::resource('classes', \App\Http\Controllers\SchoolClassController::class)->only([
        'index', 'show', 'edit', 'update', 'create', 'store'
    ]);
    Route::get('/attendance', [\App\Http\Controllers\Teacher\AttendanceController::class, 'index'])->name('attendance.index');
    Route::get('/attendance/qrcode/{school_class_id}/{subject_id}', [\App\Http\Controllers\Teacher\AttendanceController::class, 'generateQrCode'])->name('attendance.qrcode');
    Route::get('/attendance/{attendance}/edit', [\App\Http\Controllers\Teacher\AttendanceController::class, 'edit'])->name('attendance.edit');
    Route::put('/attendance/{attendance}', [\App\Http\Controllers\Teacher\AttendanceController::class, 'update'])->name('attendance.update');
    Route::delete('/attendance/{attendance}', [\App\Http\Controllers\Teacher\AttendanceController::class, 'destroy'])->name('attendance.destroy');
    Route::get('/attendance/export', [\App\Http\Controllers\Teacher\AttendanceController::class, 'export'])->name('attendance.export');
    Route::get('/attendance/create/{school_class}/{subject}', [\App\Http\Controllers\Teacher\AttendanceController::class, 'create'])->name('attendance.create');
    Route::post('/attendance', [\App\Http\Controllers\Teacher\AttendanceController::class, 'store'])->name('attendance.store');
});

// Student Routes
Route::middleware(['auth', 'role:siswa'])->prefix('student')->name('student.')->group(function () {
    Route::get('/dashboard', [\App\Http\Controllers\Student\DashboardController::class, 'index'])->name('dashboard');
    Route::get('/attendance/scan', [\App\Http\Controllers\Student\AttendanceController::class, 'scan'])->name('attendance.scan');
    Route::get('/attendance', [\App\Http\Controllers\Student\AttendanceController::class, 'index'])->name('attendance.index');
    Route::resource('absence-submissions', \App\Http\Controllers\Student\AbsenceSubmissionController::class)->only(['create', 'store']);
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});


require __DIR__.'/auth.php';
