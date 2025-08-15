<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AppController;

// Route::get('/', function () {
//     return view('welcome');
// });

Route::get('/', [AppController::class, 'index'])->name('index');

Route::get('/gouvernance', [AppController::class, 'gouvernance'])->name('gouvernance');
Route::get('/economie', [AppController::class, 'economie'])->name('economie');
Route::get('/social', [AppController::class, 'social'])->name('social');
Route::get('/sport-culture', [AppController::class, 'sport_culture'])->name('sport-culture');
Route::get('/jeunes-femmes', [AppController::class, 'jeunes_femmes'])->name('jeunes-femmes');
Route::get('/equipe', [AppController::class, 'equipe'])->name('equipe');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
