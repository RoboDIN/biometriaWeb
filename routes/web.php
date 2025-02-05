<?php

use App\Http\Controllers\UserController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

// Rotas configurados o fluxo web do sistema  
Route::get('/', function () {
    return view('home');
})->name('home')->middleware('auth');

// Cadastro do usuario
Route::get('/register', [UserController::class, 'create'])->name('user.cadUser');
Route::post('/register', [UserController::class, 'store'])->name('user.store');
Route::post('/executar-script', [UserController::class, 'executarScript'])->name('executar.script');


Route::get('/register/serial', [UserController::class, 'startSerial'])->name('user.startSerial');
Route::get('/register/messages', [UserController::class, 'fetchMessages'])->name('user.fetchMessages');

require __DIR__ . '/auth.php';



