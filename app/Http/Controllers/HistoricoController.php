<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Access; // Certifique-se de que o modelo Access existe

class HistoricoController extends Controller
{
    public function index()
    {
        // Recupera todos os acessos com os dados do usuário relacionado
        $acessos = Access::with('user')->get();

        // Passa os dados para a view
        return view('historico', compact('acessos'));
    }
}