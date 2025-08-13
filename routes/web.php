<?php

use App\Http\Controllers\AppController;
use Illuminate\Support\Facades\Route;

Route::get('/', [AppController::class, 'index'])->name('index');
Route::get('/gouvrnance', [AppController::class, 'gouvernance'])->name('gouvernance');
Route::get('/economie', [AppController::class, 'economie'])->name('economie');
Route::get('/social', [AppController::class, 'social'])->name('social');
Route::get('/sport-culture', [AppController::class, 'sport_culture'])->name('sport-culture');
Route::get('/jeunes-femmes', [AppController::class, 'jeunes_femmes'])->name('jeunes-femmes');
Route::get('/equipe', [AppController::class, 'equipe'])->name('equipe');