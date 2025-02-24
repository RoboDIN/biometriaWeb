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

        $biometria = '';

        while (true) {
            $data = fgets($handle, 1024); // Lê a mensagem do Arduino
    
            if ($data !== false) {
                $data = mb_convert_encoding($data, 'UTF-8', 'auto');
                $data = trim(preg_replace('/[^\x20-\x7E]/', '', $data));
    
                echo "data: " . json_encode(['message' => $data]) . "\n\n";
                ob_flush();
                flush();

                if (strpos($data, 'FALHA') !== false) {

                    echo "data: " . json_encode(['message' => 'Execução encerrada!']) . "\n\n";
                    ob_flush();
                    flush();
                    break;
                }
    
                // Para a execução quando receber a mensagem de finalização
                if (strpos($data, 'FIM') !== false) {

                    $biometria = base64_decode($biometria);  // Se a imagem for base64, você pode decodificar aqui

                    echo "data: " . json_encode(['message' => 'Execução finalizada pelo Arduino']) . "\n\n";
                    ob_flush();
                    flush();
                    break;
                }


            }
    
            usleep(100000); 
        }
    
       fclose($handle);
    }
}
