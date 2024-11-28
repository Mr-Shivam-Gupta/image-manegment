<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\imagesController;
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

Route::get('/img/{id}/edit', [imgContoller::class, 'index'])->name('images.edit');
Route::get('/img/edit', [imgContoller::class, 'index'])->name('images.update');
Route::get('/img/delete', [imgContoller::class, 'index'])->name('images.destroy');


// Route::resource('images', imagesController::class);


    Route::get('/transformation/list', [ProfileController::class, 'edit'])->name('transformation.index');




});



require __DIR__.'/auth.php';
