<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Symfony\Component\Process\Process;
use Symfony\Component\Process\Exception\ProcessFailedException;

class ReadSerialPython extends Command
{
    protected $signature = 'executar:scriptPython';
    protected $description = 'Executa um script Python para ler a porta serial do Arduino';

    public function __construct(){
        parent::__construct();
    }

    public function handle()
    {
        $scriptPath = 'C:\\Users\\lucax\\Desktop\\Projetos RoboDIN\\biometriaWeb\\scripts\\read_arduino.py'; 

        try {

            $process = new Process(['python', $scriptPath]);
            $process->run();

            // Verifica se o comando foi bem-sucedido
            if (!$process->isSuccessful()) {
                throw new ProcessFailedException($process);
            }

            // Exibe o valor retornado pelo script
            $output = $process->getOutput();
            $this->info("Resultado do script: " . $output);

            // Retorne o resultado para o Laravel
            return $output;
    
        } catch (\Exception $e) {
            $this->error('Erro ao executar o script: ' . $e->getMessage());
        }
    }
}
