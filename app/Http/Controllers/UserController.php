<?php

// Formulário de criação de usuários
namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;


class UserController extends Controller
{
    public function edit($email)
    {
        // Busca o usuário pelo email ou lança um erro 404 caso não encontre
        $user = User::findOrFail($email);
        // Retorna a view de edição passando o usuário
        return view('editUser', compact('user'));
    }
    
    public function update(Request $request, $email)
    {
        // Busca o usuário a ser editado
        $user = User::findOrFail($email);
    
        // Define as regras de validação (não incluímos a digital)
        $rules = [
            'name'       => 'required|string|max:255',
            'advisor'    => 'nullable|string|max:255',
            'entry_date' => 'date',
            'genre'      => 'required|in:masculino,feminino,outro',
            'is_admin'   => 'boolean',
        ];
    
        // Caso a opção de admin esteja marcada, pode validar a senha se for informada
        if ($request->is_admin) {
            $rules['password'] = 'nullable|string|min:8|confirmed';
        }
    
        $validated = $request->validate($rules);
    
        // Caso a senha tenha sido informada, criptografa; se não, não altera
        if (!empty($validated['password'])) {
            $validated['password'] = bcrypt($validated['password']);
        } else {
            // Se a senha não for enviada, remove o campo para que o update não modifique o valor atual
            unset($validated['password']);
        }
    
        // Atualiza os dados do usuário (não incluímos o campo biometry, evitando alterações na digital)
        $user->update($validated);
    
        return redirect()->route('membros.index')->with('success', 'Usuário atualizado com sucesso!');
    }
    


    public function destroy($email)
    {
    // Procura o usuário pelo email (chave primária)
    $user = User::findOrFail($email);
    $user->delete(); // Soft delete (devido ao uso do trait SoftDeletes)

    return redirect()->route('membros.index')->with('success', 'Usuário excluído com sucesso!');
    }
    
    public function create() {
        return view('cadUser');
    }

    public function index()
    {
    // Buscando os usuários com as colunas 'email' e 'name'
    $users = User::select('email', 'name')->get();

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
            'biometry' => 'required',
            'genre' => 'required|in:masculino,feminino,outro',
            'is_admin' => 'boolean',
        ]);

        if ($request->is_admin) { 
            $validated += $request->validate([
                'password' => 'required|string|min:8|confirmed',
            ]);
        } else {
            $validated['password'] = null; 
        }

        $user->fill($validated);


        if (!empty($validated['password'])) {
            $user->password = bcrypt($validated['password']);
        } else {
            $user->password = null;
        }

        $user->save();
    

        return redirect()->route('home')->with('success', 'Usuário cadastrado com sucesso!');
    }

    public function executarScript(Request $request) {

        $port = "\\\\.\\COM10";
        $baudRate = 57600;

        // Reinicia a porta serial antes de abrir
        exec("mode COM10 BAUD=57600 PARITY=N data=8 stop=1 xon=off");
        usleep(500000); 

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

        $setupComplete = false;
        $timeout = 5; 
        $statTime = time();
        
        # Verificacao do setup
        while (true) {

            if (time() - $statTime > $timeout) {
                echo "data: " . json_encode(['message' => 'Conexão perdida ! Verifique a conexão com o sensor!']) . "\n\n";
                ob_flush();
                flush();
                break;
            }

            $data = fgets($handle, 1024); 
    
            if ($data !== false) {
                $data = mb_convert_encoding($data, 'UTF-8', 'auto');

                if (strpos($data, 'READY') !== false || strpos($data, 'OK') !== false) {
                    $setupComplete = true;
                    break; // Se o setup for concluído, sai do loop
                }
            }

            usleep(100000); 
        }

        if ($setupComplete) {

            $startCommand = "start\n";
            fwrite($handle, $startCommand);
            usleep(100000);
    
            echo "data: " . json_encode(['message' => 'Comando enviado para iniciar Arduino...']) . "\n\n";
            ob_flush();
            flush();
    
            $biometria = '';
            $lastDataTime = microtime(true);

            // Agora que o Arduino está pronto, continua o processo de leitura de dados
            while (true) {

                $data = fgets($handle, 1024); // Lê a mensagem do Arduino
    
                if ($data !== false) {

                    $data = mb_convert_encoding($data, 'UTF-8', 'auto');
            
                    if (strpos($data, 'FALHA') !== false) {
                        echo "data: " . json_encode(['message' => 'Execução encerrada!']) . "\n\n";
                        ob_flush();
                        flush();
                        break;
    
                    } elseif (strpos($data, 'CAPTURANDO') !== false){


                        $IDbiometria = fgets($handle, 1024);

                        echo "data: " . json_encode(['message' => 'FINALIZADO', 'biometria' => $IDbiometria]) . "\n\n";
                        ob_flush();
                        flush();

                    } elseif (strpos($data, 'FIM') !== false){

                        break;

                    } else {

                        echo "data: " . json_encode(['message' => $data]) . "\n\n";
                        ob_flush();
                        flush();
                        
                    }
                
                }

                usleep(100000); // Pausa de 0.1 segundos
            }
        
        } else {
            echo "data: " . json_encode(['message' => 'Conexão perdida, operacão finalizada!']) . "\n\n";
            ob_flush();
            flush();
        }
    
       fclose($handle);
    }
}
