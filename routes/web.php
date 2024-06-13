<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\FileController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect('login');
});

Route::group([
    "middleware" => ["LoggedOut"]
], function () {
    // register route (GET + POST)
    Route::get('/login', [UserController::class, 'login']);
    Route::get('/register', [UserController::class, 'register']);

    // login route (GET + POST)
    Route::post('/login', [AuthController::class, 'login'])->name('login');
    Route::post('/register', [AuthController::class, 'register'])->name('register');
});

Route::group([
    "middleware" => ["LoggedIn"]
], function () {

    // profile route (GET + POST)
    Route::match(['get', 'post'], '/profile', [UserController::class, 'profile'])->name('profile');

    // dashboard route
    Route::get('/dashboard', [UserController::class, 'dashboard'])->name('dashboard');

    // logout route
    Route::get('/logout', [AuthController::class, 'logout'])->name('logout');

    // Show files route
    Route::get('files', [FileController::class, 'show'])->name('files');

    // Upload files route (GET + POST)
    Route::match(['get', 'post'], 'upload', [FileController::class, 'upload'])->name('upload');

    // Show single file
    Route::get('/view/{id}', [FileController::class, 'view'])->name('view');

    // delete single file
    Route::delete('/delete/{id}', [FileController::class, 'delete'])->name('delete');
});
