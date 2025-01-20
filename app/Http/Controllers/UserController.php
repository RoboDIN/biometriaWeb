<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function create()
    {
        return view('cadUser');
    }

    public function store(Request $request)
    {
        // Valida os dados
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'orientador' => 'nullable|string|max:255',
            'dataEntrada' => 'nullable|date',
            'biometria' => 'nullable|image|mimes:png,jpg,jpeg|max:2048',
            'sexo' => 'nullable|in:masculino,feminino,outro',
            'admin' => 'required|boolean',
            'password' => 'required|string|min:8|confirmed',
        ]);

        // Cria o usuário
        $user = new User($validated);

        // Adiciona a biometria (se enviada)
        if ($request->hasFile('biometria')) {
            $user->biometria = $request->file('biometria');
        }

        $user->save();

        return redirect()->route('cadUser')->with('success', 'Usuário cadastrado com sucesso!');
    }
}
