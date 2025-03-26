// Apresenta data atual do cadastro no campo dataEntrada no formúlario de cadastro de usuário
document.addEventListener('DOMContentLoaded', function() { 
  var dataEntrada = document.getElementById('entry_date'); 
  
  if (!dataEntrada.value) { 
    var hoje = new Date(); 
    var dia = String(hoje.getDate()).padStart(2, '0'); 
    var mes = String(hoje.getMonth() + 1).padStart(2, '0'); 
    var ano = hoje.getFullYear(); 
    
    dataEntrada.value = ano + '-' + mes + '-' + dia;
  }
});

// Habilita o campo senha e confirma senha se o checkbox 'administrador' for pressionado 
document.addEventListener('DOMContentLoaded', function() {
  var adminCheckbox = document.getElementById('is_admin');
  var adminFields = document.getElementById('div-senha');
  var passwordInput = document.getElementById('password');
  var passwordConfirmInput = document.getElementById('password_confirmation');

  function toggleAdminFields() { 
    if (adminCheckbox.checked) { 
      adminFields.classList.remove('hidden'); 
      adminFields.classList.add('flex-container'); 

      passwordInput.setAttribute('required', 'required');
      passwordConfirmInput.setAttribute('required', 'required');
    } else { 
      adminFields.classList.remove('flex-container'); 
      adminFields.classList.add('hidden');

      passwordInput.removeAttribute('required');
      passwordConfirmInput.removeAttribute('required');
    } 
  } 
  
  toggleAdminFields();                                          // Verifica o estado inicial do checkbox
  adminCheckbox.addEventListener('change', toggleAdminFields);  // Adiciona um evento de alteração ao checkbox
});


// Habilita leitura da porta serial
document.addEventListener("DOMContentLoaded", function() {
  const form = document.getElementById('form-executar-script');
  const messagesDiv = document.getElementById('messages');

  let eventSource;

  // Lida com o evento de submit do formulário
  form.addEventListener('submit', function(e) {
    e.preventDefault(); 

    if(eventSource){
      return;
    }

    // Exibe uma mensagem informando que a execução começou
    messagesDiv.innerHTML = '<p>Operação de cadastro inicializada</p>';

    // Inicia a leitura da serial após o formulário ser enviado
    eventSource = new EventSource('/executar-script');

    const timeout = setTimeout(function() {
      const p = document.createElement('p');
      p.textContent = "Tempo de execução excedido, tentando novamente.";
      p.className = 'bg-red-100 text-red-700 p-2 rounded';

      messagesDiv.appendChild(p);
      messagesDiv.scrollTop = messagesDiv.scrollHeight;

      eventSource.close();  // Fecha o EventSource após o timeout
      eventSource = null; 
    }, 30000);
    
    eventSource.onmessage = function(event) {
      const data = JSON.parse(event.data);
      const message = data.message;
      const biometria = data.biometria;

      if (message) {

        if (message === 'FINALIZADO') {
          
          clearTimeout(timeout);

          document.getElementById('biometry').value = biometria;
          alert('Biometria capturada com sucesso!');
          eventSource.close();
          eventSource = null;
          

        } else {

          const p = document.createElement('p');
          p.textContent = message;
          p.className = 'bg-blue-100 text-blue-700 p-2 rounded';

          messagesDiv.appendChild(p);
          messagesDiv.scrollTop = messagesDiv.scrollHeight;

        }
      }
    };

    eventSource.onerror = function() {
      const p = document.createElement('p');
      p.textContent = "Erro na conexão com a porta serial.";
      p.className = 'bg-blue-100 text-blue-700 p-2 rounded';

      messagesDiv.appendChild(p);
      messagesDiv.scrollTop = messagesDiv.scrollHeight;
      
      eventSource.close();
      eventSource = null;
      clearTimeout(timeout);
    };

  });
});

document.addEventListener("DOMContentLoaded", function() {

  const messagesDiv = document.getElementById('messagesHome');
  let eventSource;
  let timeout;

  // Inicia a leitura da serial após o formulário ser enviado
  function startSerialConnection() {

    if(eventSource){
      return;
    }

    eventSource = new EventSource('/read-arduino');

    timeout = setTimeout(function() {
      const p = document.createElement('p');
      p.textContent = "Tempo de execução excedido, tentando novamente.";
      p.className = 'bg-red-100 text-red-700 p-2 rounded';

      messagesDiv.appendChild(p);
      messagesDiv.scrollTop = messagesDiv.scrollHeight;

      eventSource.close();  // Fecha o EventSource após o timeout
      eventSource = null; 

    }, 3000);
    
    eventSource.onmessage = function(event) {
      const message = data.message;

      if (message) {
        const p = document.createElement('p');
        p.textContent = message;
        p.className = 'bg-blue-100 text-blue-700 p-2 rounded';

        messagesDiv.appendChild(p);
        messagesDiv.scrollTop = messagesDiv.scrollHeight;

        if (message === "INICIO") {
          sendRequest();
        }

        clearTimeout(timeout); 
      }
    };

    eventSource.onerror = function() {
      const p = document.createElement('p');
      p.textContent = "Erro na conexão com a porta serial.";
      p.className = 'bg-blue-100 text-blue-700 p-2 rounded';

      messagesDiv.appendChild(p);
      messagesDiv.scrollTop = messagesDiv.scrollHeight;

      // Fechar a conexão atual e tentar reconectar após 5 segundos
      eventSource.close();
      eventSource = null;

      clearTimeout(timeout);

      setTimeout(startSerialConnection, 5000); // Tentativa de reconexão após 5 segundos
    };
  }

  function sendRequest() {
    const xhr = new XMLHttpRequest();
  }

  startSerialConnection();

});
