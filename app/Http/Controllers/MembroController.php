<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;

class MembroController extends Controller
{
    public function search(Request $request)
    {
        $termo = $request->input('name');

        $request->session()->put('search_term', $termo);

        if (!$termo) {
            $users = User::all();
        } else {
            $users = User::where('name', 'LIKE', "%{$termo}%")->get();
        }

        return view('membros', compact('users'));
    }

    public function index(Request $request)
    {
        // Verifica se há um termo de pesquisa na sessão
        $termo = $request->session()->get('search_term', '');

        if ($termo) {
            $users = User::where('name', 'LIKE', "%{$termo}%")->get();
        } else {
            $users = User::all();
        }

        return view('membros', compact('users'));
    }
}
