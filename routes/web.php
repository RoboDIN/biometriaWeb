<?php

use App\Http\Controllers\HistoricoController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\MembroController;
use App\Http\Controllers\ReadBiometryController;
use Illuminate\Support\Facades\Route;


//Edição de usuários
Route::get('/user/{email}/edit', [UserController::class, 'edit'])->name('user.edit');
Route::put('/user/{email}', [UserController::class, 'update'])->name('user.update');

// Rotas configurados o fluxo web do sistema  
Route::get('/', function () { return view('home'); })->name('home')->middleware('auth');
Route::get('/read-arduino', [ReadBiometryController::class, 'readBiometry'])->middleware('auth');

Route::get('/membros', [UserController::class, 'index'])->name('membros.index')->middleware('auth');
Route::get('/historico', [HistoricoController::class, 'index'])->name('historico')->middleware('auth');

// Buscar usuário cadastrado
Route::get('/search', [MembroController::class, 'search'])->name('membro.search')->middleware('auth');
Route::get('/search/membros', [MembroController::class, 'index'])->name('membro.index')->middleware('auth');

// Cadastro do usuario
Route::get('/register', [UserController::class, 'create'])->name('user.cadUser')->middleware('auth');
Route::post('/register', [UserController::class, 'store'])->name('user.store')->middleware('auth');
Route::get('/executar-script', [UserController::class, 'executarScript'])->middleware('auth');

//deletar usuário
Route::delete('/user/{email}', [UserController::class, 'destroy'])->name('user.destroy');

require __DIR__ . '/auth.php';






