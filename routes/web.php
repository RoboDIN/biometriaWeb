<?php

use App\Http\Controllers\HistoricoController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\MembroController;
use App\Http\Controllers\ReadBiometryController;
use Illuminate\Support\Facades\Route;

// Rotas configurados o fluxo web do sistema  
Route::get('/', function () { return view('home'); })->name('home');
Route::get('/read-arduino', [ReadBiometryController::class, 'readBiometry']);

// Route::get('/', [ReadBiometryController::class, 'readBiometry']);

// Route::get('/membros', function () {
//     return view('membros');
// })->name('membros')->middleware('auth');
Route::get('/membros', [UserController::class, 'index'])->name('membros.index');

// Route::get('/historico', function () {
//     return view('historico');
// })->name('historico')->middleware('auth');
Route::get('/historico', [HistoricoController::class, 'index'])->name('historico');


// Buscar usuário cadastrado
Route::get('/search', [MembroController::class, 'search'])->name('membro.search');
Route::get('/search/membros', [MembroController::class, 'index'])->name('membro.index');

// Cadastro do usuario
Route::get('/register', [UserController::class, 'create'])->name('user.cadUser');
Route::post('/register', [UserController::class, 'store'])->name('user.store');
Route::get('/executar-script', [UserController::class, 'executarScript']);

//deletar usuário
Route::delete('/user/{email}', [UserController::class, 'destroy'])->name('user.destroy');

require __DIR__ . '/auth.php';






