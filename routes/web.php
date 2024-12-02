<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\transformController;
use App\Http\Controllers\imgContoller;
use Illuminate\Support\Facades\Route;

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


    Route::get('/img', [imgContoller::class, 'index'])->name('images.index');
    Route::get('/img/create', [imgContoller::class, 'create'])->name('images.create');
    Route::post('/img/create', [imgContoller::class, 'store'])->name('images.store');
    Route::delete('/img/{id}/delete', [imgContoller::class, 'destroy'])->name('images.destroy');
    Route::get('/img/{id}/edit', [imgContoller::class, 'edit'])->name('images.edit');
    Route::put('/img/{id}/update', [imgContoller::class, 'update'])->name('images.update');






    Route::get('/transform', [transformController::class, 'index'])->name('transformation.index');
    Route::get('/transform/create', [transformController::class, 'create'])->name('transformation.create');
    Route::post('/transform/create', [transformController::class, 'transform'])->name('transformation.transform');
    // Route::match(['post', 'put'],'/transform/{id?}/create', [transformController::class, 'transform'])->name('transformation.transform');





});



require __DIR__.'/auth.php';
