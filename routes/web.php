<?php

use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

// Rotas configurados o fluxo web do sistema  
Route::get('/', function () {
    return view('home');
})->name('home')->middleware('auth');

// Cadastro do usuario
Route::get('/register', [UserController::class, 'create'])->name('user.cadUser');
Route::post('/register', [UserController::class, 'store'])->name('user.store');
Route::post('/executar-script', [UserController::class, 'executarScript'])->name('user.executarScript');

require __DIR__ . '/auth.php';






