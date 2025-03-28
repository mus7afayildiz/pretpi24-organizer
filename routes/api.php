<?php

use App\Http\Controllers\NoteController;

Route::post('/notes', [NoteController::class, 'store']);

Route::get('/notes', [NoteController::class, 'adding']);

Route::get('/notes/index', [NoteController::class, 'showIndexPage']);

