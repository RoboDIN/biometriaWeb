<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class MembroController extends Controller
{
    public function search(Request $request)
    {
        $termo = $request->input('name');

        if (!$termo) {
            return redirect()->back()->with('erro', 'Digite algo para pesquisar.');
        }

        // Aqui você pode buscar no banco de dados, por exemplo:
        // $resultados = Model::where('campo', 'LIKE', "%{$termo}%")->get();

        return view('resultado', compact('termo'));
    }
}
