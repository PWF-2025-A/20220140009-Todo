
<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TodoController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\CategoryController;
use Illuminate\Support\Facades\Route;

// Halaman awal
Route::get('/', function () {
    return view('welcome');
});

// Dashboard (perlu login dan verifikasi)
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

// Group route yang memerlukan autentikasi
Route::middleware(['auth', 'verified'])->group(function () {

    //  Profile routes
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    //  Todo routes (bisa diakses semua user)
    Route::resource('todo', TodoController::class)->except(['show']);
    Route::patch('/todo/{todo}/complete', [TodoController::class, 'complete'])->name('todo.complete');
    Route::patch('/todo/{todo}/uncomplete', [TodoController::class, 'uncomplete'])->name('todo.uncomplete');
    Route::delete('/todo', [TodoController::class, 'destroyCompleted'])->name('todo.deleteallcompleted');

    //  Category routes (bisa diakses semua user)
    Route::resource('category', CategoryController::class)->except(['show']);

    //  User list untuk semua user (misalnya lihat daftar user)
    Route::get('/user', [UserController::class, 'index'])->name('user.index');

    //  Khusus admin
    Route::middleware(['admin'])->group(function () {
        Route::patch('/user/{user}/makeadmin', [UserController::class, 'makeadmin'])->name('user.makeadmin');
        Route::patch('/user/{user}/removeadmin', [UserController::class, 'removeadmin'])->name('user.removeadmin');
        Route::delete('/user/{user}', [UserController::class, 'destroy'])->name('user.destroy');

    });
});

// Routing autentikasi
require __DIR__.'/auth.php';
