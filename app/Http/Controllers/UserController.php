<?php

// Formulário de criação de usuários

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;

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
            'email' => 'required|email|unique:users',
            'name' => 'required|string|max:255',
            'advisor' => 'nullable|string|max:255',
            'entry_date' => 'date',
            'biometry' => 'image|mimes:png,jpg,jpeg|max:2048',
            'genre' => 'required|in:masculino,feminino,outro',
            'admin' => 'required|boolean',
        ]);

        if ($request->admin) { 
            $validated['password'] = $request->validate([ 'password' => 'required|string|min:8|confirmed', ])['password']; 
        } else { 
            $validated['password'] = $request->input('password') ?? 'defaultpassword'; 
        };

        // Cria o usuário
        $user = new User($validated);

        // Adiciona a biometria (se enviada)
        if ($request->hasFile('biometry')) {
            $user->biometry = $request->file('biometry');
        }

        $user->save();

        return redirect()->route('home')->with('success', 'Usuário cadastrado com sucesso!');
    }
}
