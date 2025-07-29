<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\TeamController;
use App\Http\Controllers\AnalyticsController;
use App\Http\Controllers\AIController; // 1. Tambahkan import untuk AIController
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// Route untuk halaman utama - Welcome page
Route::get('/', function () {
    return view('welcome');
})->name('welcome');

// Grup route yang memerlukan otentikasi (user harus login)
Route::middleware('auth')->group(function () {
    // Route untuk Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Route untuk Profile
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Route resource untuk Tasks (CRUD)
    Route::resource('tasks', TaskController::class);
    Route::post('/tasks/{task}/submit', [TaskController::class, 'submit'])->name('tasks.submit');
    Route::get('/tasks/{task}/download', [TaskController::class, 'download'])->name('tasks.download');

    // Grup route khusus untuk Admin
    Route::middleware('admin')->group(function () {

        Route::delete('/team/{user}', [TeamController::class, 'destroy'])->name('team.destroy');

        // Route untuk Team Management
        Route::get('/team', [TeamController::class, 'index'])->name('team.index');
        Route::patch('/team/{user}/role', [TeamController::class, 'updateRole'])->name('team.updateRole');
        
        // Route untuk Analytics
        Route::get('/analytics', [AnalyticsController::class, 'index'])->name('analytics.index');

        // 2. TAMBAHKAN ROUTE UNTUK AI CHATBOT DI SINI
        Route::post('/ai/process-command', [AIController::class, 'processCommand'])->name('ai.command');
    });

    // Route untuk Notifications (berlaku untuk semua user yang login)
    Route::get('/notifications/latest', [App\Http\Controllers\NotificationController::class, 'getLatest'])->name('notifications.latest');
    Route::post('/notifications/mark-as-read', [App\Http\Controllers\NotificationController::class, 'markAsRead'])->name('notifications.markAsRead');
});


// Memuat route otentikasi (login, register, dll.)
require __DIR__.'/auth.php';
