<?php

// Formulário de criação de usuários

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use phpSerial;

class UserController extends Controller
{
    public function create()
    {
        $messages = $this->getMessages();
        return view('cadUser', compact('messages'));
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
            Storage::put('public/serial_messages.txt', $request->input('serial-messages-input'));
        }

        return redirect()->route('home')->with('success', 'Usuário cadastrado com sucesso!');
    }


    public function startSerial() {
        exec('php artisan serial:read > /dev/null 2>&1 &');
        $this->fetchMessages();
        return redirect()->route('user.create');
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
