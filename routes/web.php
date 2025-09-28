<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AppController;

// Route::get('/', function () {
//     return view('welcome');
// });

Route::get('/', [AppController::class, 'index'])->name('index');
// Nouvelle route (avec ID)
Route::get('/article/{id}', [AppController::class, 'show'])->name('articles.show');

Route::get('/gouvernance', [AppController::class, 'gouvernance'])->name('gouvernance');
Route::get('/economie', [AppController::class, 'economie'])->name('economie');
Route::get('/social', [AppController::class, 'social'])->name('social');
Route::get('/sport-culture', [AppController::class, 'sport_culture'])->name('sport-culture');
Route::get('/jeunes-femmes', [AppController::class, 'jeunes_femmes'])->name('jeunes-femmes');
Route::get('/equipe', [AppController::class, 'equipe'])->name('equipe');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

// Articles
Route::get('/articles', [AppController::class, 'articles'
])->middleware(['auth', 'verified'])->name('articles');

// Flash Infos
Route::get('flash_infos', [AppController::class, 'flash_infos'
])->middleware(['auth', 'verified'])->name('flash_infos');

// Page Utilisateurs
Route::get('utilisateurs', [AppController::class, 'utilisateurs'
])->middleware(['auth', 'verified'])->name('utilisateurs');

// Page Dernière vidéos
Route::get('derniere_video', [AppController::class, 'derniere_video'
])->middleware(['auth', 'verified'])->name('derniere_video');



// Options  Utilisateurs
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
