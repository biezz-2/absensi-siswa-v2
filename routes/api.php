<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\NicknameController;

// Public API routes
Route::post('/login', [AuthController::class, 'login']);
Route::post('/suggest-nickname', [NicknameController::class, 'suggest'])->name('api.nickname.suggest');

Route::middleware('auth:sanctum')->group(function () {
    // Common authenticated routes
    Route::get('/user', function (Request $request) {
        return $request->user();
    });
    Route::post('/logout', [AuthController::class, 'logout']);

    // Admin API Routes
    Route::middleware('role:admin')->prefix('admin')->name('api.admin.')->group(function () {
        Route::get('/stats', function () { return response()->json(['message' => 'Admin stats endpoint']); });
        Route::apiResource('users', '\App\Http\Controllers\Api\Admin\UserController');
        Route::apiResource('classes', '\App\Http\Controllers\Api\Admin\ClassController');
        Route::apiResource('subjects', '\App\Http\Controllers\Api\Admin\SubjectController');
        Route::get('/attendance', function () { return response()->json(['message' => 'Admin attendance endpoint']); });
    });

    // Teacher API Routes
    Route::middleware('role:guru')->prefix('teacher')->name('api.teacher.')->group(function () {
        Route::get('/classes', function () { return response()->json(['message' => 'Teacher classes endpoint']); });
        Route::get('/classes/{class_id}/students', function ($class_id) { return response()->json(['message' => "Students for class {$class_id}"]); });
        Route::post('/attendance', function () { return response()->json(['message' => 'Teacher attendance submission endpoint']); });
        Route::get('/attendance/history', function () { return response()->json(['message' => 'Teacher attendance history endpoint']); });
    });

    // Student API Routes
    Route::middleware('role:siswa')->prefix('student')->name('api.student.')->group(function () {
        Route::get('/attendance', function () { return response()->json(['message' => 'Student attendance endpoint']); });
        Route::get('/schedule', function () { return response()->json(['message' => 'Student schedule endpoint']); });
        Route::post('/absence-submission', function () { return response()->json(['message' => 'Student absence submission endpoint']); });
    });
});