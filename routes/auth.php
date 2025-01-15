<!-- REALIZAR AUTENTICAÇÃO NESTE ARQUIVO -->
<?php

use App\Http\Controllers\Auth\AuthController2;

// Rotas de autenticação
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login')->middleware('guest');
Route::post('/login', [AuthController::class, 'login'])->middleware('guest');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout')->middleware('auth');


// Layouts protegidas 
Route::get('/', function () {
    return view('home');
})->middleware('auth')->name('home');