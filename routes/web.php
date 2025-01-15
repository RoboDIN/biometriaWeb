<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

// Rotas configurados o fluxo web do sistema 
Route::get('/', function () {
    return view('home');
});



