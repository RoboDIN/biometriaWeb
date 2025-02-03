<?php

namespace App\Services;

use App\Serial\PhpSerial;  // Certifique-se de importar corretamente a classe

class ArduinoService
{
  protected $serial;

  public function __construct()
  {
    $this->serial = new PhpSerial();  // Instancia a classe PhpSerial
    $this->serial->deviceSet("COM7"); // Defina o caminho da porta serial (no Linux)
    $this->serial->baudRate(9600); // A taxa de baud deve ser a mesma no Arduino
    $this->serial->open();
  }

  public function writeToArduino($message)
  {
    $this->serial->sendMessage($message);  // Envia mensagem para o Arduino
  }

  public function readFromArduino()
  {
    return $this->serial->readPort();  // Lê dados recebidos do Arduino
  }

  public function __destruct()
  {
    $this->serial->close();  // Fecha a conexão serial quando o serviço for destruído
  }
}
