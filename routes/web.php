<?php

use App\Http\Controllers\UserController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

// Rotas configurados o fluxo web do sistema  
Route::get('/', function () {
    return view('home');
}); // ->middleware('auth')->name('home');

// Cadastro do usuario
Route::get('/register', [UserController::class, 'create'])->name('cadUser');
Route::post('/register', [UserController::class, 'store'])->name('store');


require __DIR__ . '/auth.php';



