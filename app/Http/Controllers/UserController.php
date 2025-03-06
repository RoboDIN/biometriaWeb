<?php

// Formulário de criação de usuários
namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;


class UserController extends Controller
{
    public function create() {
        return view('cadUser');
    }

    public function index()
    {
        // Busca todos os usuários, selecionando apenas a coluna "name"
        $users = User::select('name')->get();

        // Passa os usuários para a view
        return view('membros', compact('users'));
    }

    public function store(Request $request) {
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

        // $biometricImage = $this->captureBiometric();

        // // Adiciona a biometria (se enviada)
        // if ($biometricImage) {

        //     $imageContent = file_get_contents($biometricImage->getRealPath());
        //     $base64Image = base64_encode($imageContent);
        //     $user->biometry = $base64Image;
        // }

        $user->save();

        // Adiciona as mensagens da porta serial ao campo oculto
        if ($request->has('serial_messages')) {
            Storage::put('public/serial_messages.txt', 
            $request->input('serial-messages-input'));
        }

        return redirect()->route('home')->with('success', 'Usuário cadastrado com sucesso!');
    }

    public function executarScript(Request $request) {

        $port = "\\\\.\\COM10";
        $baudRate = 115200; 

        $handle = @fopen($port, "r");

        if (!$handle) {
            return response()->json(['error' => 'Não foi possível abrir a porta serial'], 500);
        }

        $timeout = 1;  // Tempo em segundos
        $read = [$handle];
        $write = null;
        $except = null;

        // Verifica se há dados disponíveis para ler dentro do tempo limite
        if (stream_select($read, $write, $except, $timeout)) {
            // Há dados disponíveis, agora podemos ler
            $data = fgets($handle, 1024);  // Lê até 1024 bytes
            fclose($handle);

            // Limpa caracteres não imprimíveis
            $data = mb_convert_encoding($data, 'UTF-8', 'auto');
            $data = trim(preg_replace('/[^\x20-\x7E]/', '', $data));

            return response()->json(['dados' => trim($data)]);
        } else {
            // Nenhum dado foi recebido dentro do tempo limite
            fclose($handle);
            return response()->json(['error' => 'Sem dados disponíveis na porta serial'], 500);
        }
       
    }
}
