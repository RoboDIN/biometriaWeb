<?php

use App\Http\Controllers\UserController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

// Rotas configurados o fluxo web do sistema  
Route::get('/', function () {
    return view('home');
})->name('home')->middleware('auth');

// Cadastro do usuario
Route::get('/register', [UserController::class, 'create'])->name('cadUser');
Route::post('/register', [UserController::class, 'store'])->name('store');

// Rota de leitura de menssagem enviado pelo arduino
Route::post('/arduino/data', function (Illuminate\Http\Request $request) {
    $data = $request->input('message');
    session()->flash('arduinoMessage', $data);
    return response()->json(['status' => 'success']);
});


require __DIR__ . '/auth.php';



