<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Mail;
use App\Http\Controllers\NoteController;
use App\Http\Controllers\TagController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\AttachmentController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/categories/edit', function () {
    return view('welcome');
});


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
    Route::resource('notes', NoteController::class);
    Route::get('/notes', [NoteController::class, 'index'])->name('notes.index');
    Route::delete('/attachments/{attachment}/delete', [AttachmentController::class, 'destroy'])->name('attachments.destroy');
    Route::delete('/attachments/{attachmentId}/delete', [AttachmentController::class, 'removeAttachment']);
    Route::post('/attachments/{note}/store', [AttachmentController::class, 'store'])->name('attachments.store');
    Route::delete('/notes/{note}/tag/{tag}', [NoteController::class, 'removeTag'])->name('notes.removeTag');
    Route::delete('/notes/{note}/tags/{tag}', [NoteController::class, 'removeTagFromNote']);
    Route::post('/notes/{note}/add-tag', [NoteController::class, 'addTag'])->name('notes.addTag');
    Route::put('/notes/{note}', [NoteController::class, 'update'])->name('notes.update');
    Route::delete('/tag/{tag}', [TagController::class, 'destroy'])->name('tag.destroy');
    Route::resource('categories', CategoryController::class);
});

Route::get('/test-mail', function () {
    Mail::raw('Test email', function ($message) {
        $message->to('ton_email@exemple.com')
                ->subject('Test Laravel Mail');
    });
    return 'Email envoyé';
});
require __DIR__.'/auth.php';
