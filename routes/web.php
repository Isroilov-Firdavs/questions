<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\QuestionController;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TestController;
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

Route::post('/telegram/webhook', [TelegramBotController::class, 'handle']);

Route::prefix('dashboard')->middleware(['auth'])->group(function () {
    // Barcha routinglar shu yerda bo‘ladi

    Route::get('/', function () {
        return view('dashboard');  // dashboard asosiy sahifa
    })->name('dashboard');

    Route::resource('questions', QuestionController::class)->middleware('admin.only');


    // Test haqida ma'lumot sahifasi, "Boshlash" tugmasi shu yerda bo'ladi
    Route::get('/test/info', [TestController::class, 'info'])->name('test.info');

    // Boshlash tugmasi bosilganda POST so'rov qabul qilinadi va test sahifasiga yo'naltiriladi
    Route::post('/test/start', [TestController::class, 'startTest'])->name('test.start');

    // Test yechish sahifasi (savollar chiqadi)
    Route::get('/test/take', [TestController::class, 'takeTest'])->name('test.take');
    Route::post('/test/answer', [TestController::class, 'saveAnswer'])->name('test.answer');

    Route::post('/test/submit', [TestController::class, 'submitTest'])->name('test.submit');
    Route::get('/test/result/{testSession}', [TestController::class, 'showResult'])->name('test.result');





});




Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
