<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class ReadBiometryController extends Controller
{
    public function readBiometry()
    {

        $port = "\\\\.\\COM10";
        $baudRate = 57600;

        exec("mode COM10 BAUD=57600 PARITY=N data=8 stop=1 xon=off");
        usleep(500000);

        header('Content-Type: text/event-stream');
        header('Cache-Control: no-cache');
        header('Connection: keep-alive');
      

        $handle = @fopen($port, "r+");

        if (!$handle) {
            echo "data: " . json_encode(['error' => 'Não foi possível abrir a porta serial']) . "\n\n";
            ob_flush();
            flush();
            exit;
        }


        while(true) {

            $data = fgets($handle, 1024);

            if ($data !== false) {

                $data = mb_convert_encoding($data, 'UTF-8', 'auto');
                
                if (strpos($data, 'FALHA') !== false) {

                    echo "data: " . json_encode(['message' => 'Execução encerrada!']) . "\n\n";
                    ob_flush();
                    flush();
                    break;

                } elseif (strpos($data, 'ACESSADO') !== false) {

                    $IDBiometria = trim(fgets($handle, 1024)); 
                    
                    $user = User::where('biometry', $IDBiometria)->first();
                
                    if ($user) {
                        echo "data: " . json_encode(['message' => "Acesso liberado para {$user->name}"]) . "\n\n";
                    } else {
                        echo "data: " . json_encode(['message' => "Usuário não encontrado para o ID enviado."]) . "\n\n";
                    }
                
                    ob_flush();
                    flush();
                }
            }

            usleep(50000);
        }

    }

}
