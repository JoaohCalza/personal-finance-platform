<?php

use App\Http\Controllers\CarteiraController;
use App\Http\Controllers\CategoriaController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::view('/', 'welcome')->name('home');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::view('dashboard', 'dashboard')->name('dashboard');
});

Route::middleware(['auth', 'verified'])->group(function () {
    Route::resource('categorias', CategoriaController::class);
    Route::resource('carteiras', CarteiraController::class);
    Route::get('usuarios', [UserController::class, 'index'])->name('usuarios.index');
});

require __DIR__.'/settings.php';
