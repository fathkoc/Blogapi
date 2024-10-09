<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BlogController;


Route::middleware('throttle:60,1')->group(function () {
    Route::get('/blogs', [BlogController::class, 'index'])->name('blogs.index');
    Route::get('/blogs/create', [BlogController::class, 'create'])->name('blogs.create');
    Route::post('/blogs', [BlogController::class, 'store'])->name('blogs.store');
    Route::get('/blogs/{id}', [BlogController::class, 'show'])->name('blogs.show');
    Route::get('/blogs/{id}/edit', [BlogController::class, 'edit'])->name('blogs.edit');
    Route::put('/blogs/{id}', [BlogController::class, 'update'])->name('blogs.update');
    Route::delete('/blogs/{id}', [BlogController::class, 'destroy'])->name('blogs.destroy');
});
