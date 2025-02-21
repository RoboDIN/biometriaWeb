<?php

// Formulário de criação de usuários
namespace App\Http\Controllers;

use Symfony\Component\Process\Process;
use Symfony\Component\Process\Exception\ProcessFailedException;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Exception;
use App\Models\User;
use phpSerial;


class UserController extends Controller
{
    public function create() {
        $messages = $this->getMessages();
        return view('cadUser', compact('messages'));
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

        // Definir o tempo limite para esperar dados (5 segundos)
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


    public function startSerial() {
        exec('php artisan serial:read > /dev/null 2>&1 &');
        $this->fetchMessages();
        return redirect()->route('user.cadUser');
    }

    public function fetchMessages() {
        $messages = $this->getMessages();
        return response()->json($messages);
    }

    private function getMessages() {
        $filePath = storage_path('app/public/serial_messages.txt');
        if (file_exists($filePath)) {
            $messages = file($filePath, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
        } else {
            $messages = [];
        }
        return $messages;
    }


    // private function captureBiometric() {

    //     // Inicializa a comunicação serial com o Arduino
    //     $serial = new phpSerial();
    //     $serial->deviceSet("COM3");                 // Porta de serial conectado o arduino
    //     $serial->confBaudRate(9600);                // Configuração de tava de baud para comunicação
    //     $serial->confParity("none");                // Verifica se houve erros em transmissão de dados
    //     $serial->confCharacterLength(8);            // Define a quantidade de bit que cada caracter é composto
    //     $serial->confStopBits(1);                   // Indica o térmico de uma unidade de dados 
    //     $serial->deviceOpen();                      // Abre a porta serial para comunicação 

    //     $serial->sendMessage("CAPTURE_BIOMETRY");   // Sinal de comando para capturar a imagem

    //     $biometricData = $serial->readPort();       // Lê a imagem enviada pelo arduino

    //     $serial->deviceClone();                     // Fecha porta serial


    //     if (!$biometricData) {
    //         return null; 
    //     }

    //     $image = imagecreatefromstring($biometricData);

    //     // Verificação se é uma imagem válida 
    //     if ($image === false) {
    //         return null;
    //     }

    //     // Salva a imagem como um arquivo PNG
    //     $imagePath = storage_path('app/public/biometries/' . uniqid() . '.png');
    //     imagepng($image, $imagePath);

    //     // Libera a memória da imagem
    //     imagedestroy($image);

    //     return new \Illuminate\Http\File($imagePath); // Retorna o arquivo para ser armazenado

    // }
}
