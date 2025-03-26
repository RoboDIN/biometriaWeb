<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ReadBiometryController extends Controller
{
    public function readBiometry()
    {
        $port = "\\\\.\\COM10";
        $baudRate = 57600;

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

        while(true) {

            $data = fgets($handle, 1024);

            if ($data !== false) {

                $data = mb_convert_encoding($data, 'UTF-8', 'auto');

                if (strpos($data, 'INICIO') !== false) {

                    $biometria .= $data;

                    if ($biometria != '') {

                        $biometriaBase64 = base64_encode($biometria);

                        $users = User::whereNotNull('biometry')->get();

                        foreach ($users as $user) {

                            if ($biometriaBase64 == $user->biometry){

                                $startCommand = "LIBERADO\n";
                                fwrite($handle, $startCommand);
                                usleep(100000);
                            }
                        }


                    }

                    ob_flush();
                    flush();
                    break;

                }
            }
        }



        // Enviar comando para o Arduino
        file_put_contents($port, "READ\n");

        // Esperar resposta
        sleep(2);
        $fingerprintID = trim(file_get_contents($port));

        if (is_numeric($fingerprintID) && $fingerprintID > 0) {
            return view('home', ['fingerprintID' => $fingerprintID]);
        }

        return view('home', ['error' => 'Nenhuma digital detectada']);
    }
}
