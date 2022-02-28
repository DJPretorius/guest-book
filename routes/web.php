<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\CommentsController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

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

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::get('/dashboard', [CommentsController::class, 'show'])
    ->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware(['auth', 'can:create posts'])->group(function() {
    Route::post('comment', [CommentsController::class, 'createComment'])->name('createComment');
    Route::post('/reply/{post}', [CommentsController::class, 'reply']);
});

Route::middleware(['auth', 'role:admin'])->group(function() {
    Route::get('/admin', [AdminController::class, 'show'])->name('adminDashboard');
});

require __DIR__.'/auth.php';
