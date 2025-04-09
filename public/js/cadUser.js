function date() {
  var dataEntrada = document.getElementById('entry_date'); 
  
  if (!dataEntrada.value) { 
    var hoje = new Date(); 
    var dia = String(hoje.getDate()).padStart(2, '0'); 
    var mes = String(hoje.getMonth() + 1).padStart(2, '0'); 
    var ano = hoje.getFullYear(); 
    
    dataEntrada.value = ano + '-' + mes + '-' + dia;
  }
}

function atvCheckbox() {
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
}

function cadastroUsuario() {
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
    if (!eventSource){
      eventSource = new EventSource('/executar-script');
    }
    
    eventSource.onmessage = function(event) {
      const data = JSON.parse(event.data);
      const message = data.message;
      const biometria = data.biometria;

      if (message) {

        if (message === 'FINALIZADO') {
          
          if (biometria) {
            document.getElementById('biometry').value = biometria;
            alert('Biometria capturada com sucesso!');
          } else {
            alert('Captura finalizada, mas sem biometria!');
          }
        
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
    };

  });
}

document.addEventListener('DOMContentLoaded', function() { 
  date();
  atvCheckbox();
  cadastroUsuario();
});

