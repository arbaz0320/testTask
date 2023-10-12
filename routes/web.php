<?php

use App\Http\Controllers\AchievementsController;
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

Route::get('/', function () {
    return view('welcome');
});

Route::get('/users/{user}/achievements', [AchievementsController::class, 'index']);

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('/unlock-achievements', [App\Http\Controllers\AchievementsController::class, 'unlockAchievements'])->name('unlockAchievements');
Route::get('//users/{user}/achievements', [App\Http\Controllers\AchievementsController::class, 'getUserAchievements'])->name('getUserAchievements');
