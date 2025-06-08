<?php

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TestController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\QuestionController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\TelegramBotController;

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

Route::get('/', function () {
    return view('welcome');
});

Route::prefix('dashboard')->middleware(['auth'])->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

    Route::resource('questions', QuestionController::class)->middleware('admin.only');

    // Testni boshlash uchun route
    Route::get('/test/start', [TestController::class, 'startTest'])->name('test.start');
    // Testni olish uchun route
    Route::get('/test/{session}/take', [TestController::class, 'takeTest'])->name('test.take');
    // Route::post('/test-session/{session}/answer', [TestController::class, 'saveAnswer'])->name('test.saveAnswer');
    Route::post('/test/{session}/answer', [TestController::class, 'saveAnswer'])->name('test.answer');



    // Route::post('/test/{session}/answer', [TestController::class, 'saveAnswer'])->name('test.answer');

    Route::post('/test/{session}/finish', [TestController::class, 'finishTest'])->name('test.finish');

    Route::get('/test/{session}/result', [TestController::class, 'showResult'])->name('test.result');

    Route::get('/user', [TestController::class, 'userDashboard'])->name('user');

    Route::get('/dashboard/admin', [TestController::class, 'adminDashboard'])->middleware('can:viewAdminDashboard')->name('dashboard.admin');







});




Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
