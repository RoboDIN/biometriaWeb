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

        // Cria o usuário
        $user = new User();
        
        // Valida os dados
        $validated = $request->validate([
            'email' => 'required|email|unique:users',
            'name' => 'required|string|max:255',
            'advisor' => 'nullable|string|max:255',
            'entry_date' => 'date',
            'biometry' => 'string',
            'genre' => 'required|in:masculino,feminino,outro',
            'is_admin' => 'boolean',
        ]);

        if ($request->admin) { 
            $validated['password'] = $request->validate([ 'password' => 'required|string|min:8|confirmed', ])['password']; 
        } else { 
            $validated['password'] = $request->input('password') ?? ''; 
        };

        // $user->biometry = $biometria;
        $user->fill($validated);
        $user->save();

        return redirect()->route('home')->with('success', 'Usuário cadastrado com sucesso!');
    }

    public function executarScript(Request $request) {

        $port = "\\\\.\\COM10";
        $baudRate = 57600; 

        // Definindo os headers para SSE (Server-Sent Events)
        header('Content-Type: text/event-stream');
        header('Cache-Control: no-cache');
        header('Connection: keep-alive');

        $handle = @fopen($port, "r+");

        if (!$handle) {
            echo "data: " . json_encode(['error' => 'Não foi possível abrir a porta serial']) . "\n\n";
            ob_flush();
            flush();
            return;
        }

        $startCommand = "start\n";
        fwrite($handle, $startCommand);
        usleep(100000);

        echo "data: " . json_encode(['message' => 'Comando enviado para iniciar Arduino...']) . "\n\n";
        ob_flush();
        flush();
        
        while (true) {
            $data = fgets($handle, 1024); // Lê a mensagem do Arduino
    
            if ($data !== false) {
                $data = mb_convert_encoding($data, 'UTF-8', 'auto');
                $data = trim(preg_replace('/[^\x20-\x7E]/', '', $data));
    

                if (strpos($data, 'FALHA') !== false) {
                    echo "data: " . json_encode(['message' => 'Execução encerrada!']) . "\n\n";
                    ob_flush();
                    flush();
                    break;

                } elseif (strpos($data, 'FIM') !== false) {
                    
                    echo "biometria: " .json_encode(['biometria' => $biometria]);
                    echo "data: " . json_encode(['message' => 'FINALIZADO']) . "\n\n";
                    break;

                } elseif (strpos($data, 'CONCLUIDO') !== false) {

                    $biometria .= $data;

                } else {
                    echo "data: " . json_encode(['message' => $data]) . "\n\n";
                    ob_flush();
                    flush();
                }
            }
    
            usleep(100000); 
        }
    
       fclose($handle);
    }
}
