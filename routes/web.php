<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TodoController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\CategoryController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::get('/todo', [TodoController::class, 'index']) -> name ('todo.index');
Route::get('/todo/create', [TodoController::class, 'create']) -> name ('todo.create');
Route::get('/todo/edit', [TodoController::class, 'edit']) -> name ('todo.edit');
Route::get('/todo/{todo}/edit', [TodoController::class, 'edit']) -> name ('todo.edit');

Route::patch('/todo/{todo}/complete', [TodoController::class, 'complete']) -> name ('todo.complete');
Route::patch('/todo/{todo}/uncomplete', [TodoController::class, 'uncomplete']) -> name ('todo.uncomplete');
Route::patch('/todo/{todo}', [TodoController::class, 'update']) -> name ('todo.update');
Route::delete('/todo/{todo}', [TodoController::class, 'destroy']) -> name ('todo.destroy');
Route::delete('/todo', [TodoController::class, 'destroyCompleted']) -> name ('todo.deleteallcompleted');

Route::resource('todo', TodoController::class)->except(['show']);

Route::get('/user', [UserController::class, 'index']) -> name ('user.index');

Route::middleware(['auth', 'admin'])->group(function () {
    Route::resource('user', UserController::class)->except(['show']);
    Route::patch('/user/{user}/makeadmin', [UserController::class, 'makeadmin']) -> name ('user.makeadmin');
    Route::patch('/user/{user}/removeadmin', [UserController::class, 'removeadmin']) -> name ('user.removeadmin');
    Route::delete('/user/{user}', [UserController::class, 'destroy']) -> name ('user.destroy');
});

Route::get('/categories', [CategoryController::class, 'index']) -> name ('categories.index');
Route::get('/categories/create', [CategoryController::class, 'create']) -> name ('categories.create');
Route::get('/categories/{category}/edit', [CategoryController::class, 'edit']) -> name ('categories.edit');
Route::patch('/categories/{category}', [CategoryController::class, 'update']) -> name ('categories.update');
Route::delete('/categoris/{category}', [CategoryController::class, 'destroy']) -> name ('categories.destroy');

Route::resource('categories', CategoryController::class)->except(['show']);




require __DIR__.'/auth.php';
