<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Mail;

Route::get('/', function () {
    return view('welcome');
});
 
Route::get('/categories/edit', function () {
    return view('welcome');
});

Route::resource('categories', \App\Http\Controllers\CategoryController::class);
Route::resource('notes', \App\Http\Controllers\NoteController::class);

Route::get('/test', function () {
    $heureServeur = now();
    $resultatSQL = DB::select("SELECT NOW() AS heure_db");
    $heureDB = $resultatSQL[0]->heure_db ?? 'Non disponible';
    return view('test', compact('heureServeur', 'heureDB'));
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::get('/test-mail', function () {
    Mail::raw('Test email', function ($message) {
        $message->to('ton_email@exemple.com')
                ->subject('Test Laravel Mail');
    });
    return 'Email envoyé';
});
require __DIR__.'/auth.php';
