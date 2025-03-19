<?php

// use Illuminate\Support\Facades\Route;

// Route::get('/', function () {
//     return view('welcome');
// });


use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    $heureServeur = now();
    $resultatSQL = DB::select("SELECT NOW() AS heure_db");
    $heureDB = $resultatSQL[0]->heure_db ?? 'Non disponible';
    
    //$resultatSQL = DB::select("SELECT 1 as result FROM dual");
    //$resultatSQL = DB::raw("SELECT NOW()")->getValue(DB::connection()->getPdo());
    //$resultatSQL = DB::scalar("SELECT NOW()");
    
    return view('index', compact('heureServeur', 'heureDB'));
});


