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
    Route::get('/dashboard', [\App\Http\Controllers\Admin\DashboardController::class, 'index'])->name('dashboard');
    Route::resource('users', \App\Http\Controllers\Admin\UserController::class);
    Route::resource('classes', \App\Http\Controllers\SchoolClassController::class);
    Route::resource('subjects', \App\Http\Controllers\Admin\SubjectController::class);
    Route::get('/attendance', [\App\Http\Controllers\Admin\AttendanceController::class, 'index'])->name('attendance.index');
    Route::get('/attendance/export', [\App\Http\Controllers\Admin\AttendanceController::class, 'export'])->name('attendance.export');
    Route::resource('absence-submissions', \App\Http\Controllers\Admin\AbsenceSubmissionController::class)->only(['index', 'update']);
});

// Teacher Routes
Route::middleware(['auth', 'role:guru'])->prefix('teacher')->name('teacher.')->group(function () {
    Route::get('/dashboard', function () {
        return 'Teacher Dashboard';
    })->name('dashboard');
    Route::resource('classes', \App\Http\Controllers\SchoolClassController::class)->only([
        'index', 'show', 'edit', 'update'
    ]);
    Route::get('/attendance', [\App\Http\Controllers\Teacher\AttendanceController::class, 'index'])->name('attendance.index');
    Route::get('/attendance/create/{school_class}/{subject}', [\App\Http\Controllers\Teacher\AttendanceController::class, 'create'])->name('attendance.create');
    Route::post('/attendance', [\App\Http\Controllers\Teacher\AttendanceController::class, 'store'])->name('attendance.store');
});

// Student Routes
Route::middleware(['auth', 'role:siswa'])->prefix('student')->name('student.')->group(function () {
    Route::get('/dashboard', function () {
        return 'Student Dashboard';
    })->name('dashboard');
    Route::get('/attendance', [\App\Http\Controllers\Student\AttendanceController::class, 'index'])->name('attendance.index');
    Route::resource('absence-submissions', \App\Http\Controllers\Student\AbsenceSubmissionController::class)->only(['create', 'store']);
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});


require __DIR__.'/auth.php';
