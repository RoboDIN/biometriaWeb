<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class ReadSerialPort extends Command
{

    protected $signature = 'serial:read';
    protected $description = 'Reads messages from the serial port';

    public function handle()
    {
        $serial = new Serial;
        $serial->deviceSet('COM10'); // Altere para a porta correta
        $serial->confBaudRate(57600);
        $serial->confParity("none");
        $serial->confCharacterLength(8);
        $serial->confStopBits(1);
        $serial->deviceOpen();

        while (true) {
            $message = $serial->readPort();
            if (!empty($message)) {
                // Aqui você pode salvar a mensagem no banco de dados ou em um arquivo
                $this->info("Mensagem recebida: " . trim($message));
            }
            usleep(100000); // Espera 100ms antes de ler novamente
        }

        $serial->deviceClose();
    }
}
