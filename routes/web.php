<?php

use App\Http\Controllers\UserController;
use App\Http\Controllers\MembroController;
use Illuminate\Support\Facades\Route;

// Rotas configurados o fluxo web do sistema  
Route::get('/', function () {
    return view('home');
})->name('home')->middleware('auth');

Route::get('/membros', function () {
    return view('membros');
})->name('membros')->middleware('auth');

Route::get('/historico', function () {
    return view('historico');
})->name('historico')->middleware('auth');


// Buscar usuário cadastrado
Route::get('/search', [MembroController::class, 'search'])->name('membro.search');

// Cadastro do usuario
Route::get('/register', [UserController::class, 'create'])->name('user.cadUser');
Route::post('/register', [UserController::class, 'store'])->name('user.store');
Route::post('/executar-script', [UserController::class, 'executarScript'])->name('user.executarScript');

require __DIR__ . '/auth.php';






