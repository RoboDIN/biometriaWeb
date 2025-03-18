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

  function toggleAdminFields() { 
    if (adminCheckbox.checked) { 
      adminFields.classList.remove('hidden'); 
      adminFields.classList.add('flex-container'); 
    } else { 
      adminFields.classList.remove('flex-container'); 
      adminFields.classList.add('hidden'); 
    } 
  } 
  
  toggleAdminFields();                                          // Verifica o estado inicial do checkbox
  adminCheckbox.addEventListener('change', toggleAdminFields);  // Adiciona um evento de alteração ao checkbox
});


// Habilita leitura da porta serial
document.addEventListener("DOMContentLoaded", function() {
  const form = document.getElementById('form-executar-script');
  const messagesDiv = document.getElementById('messages');

  // Lida com o evento de submit do formulário
  form.addEventListener('submit', function(e) {
    e.preventDefault(); 

    // Exibe uma mensagem informando que a execução começou
    messagesDiv.innerHTML = '<p>Iniciando a execução...</p>';

    // Inicia a leitura da serial após o formulário ser enviado
    const eventSource = new EventSource('/executar-script');
    
    eventSource.onmessage = function(event) {
      const data = JSON.parse(event.data);
      const message = data.message;
      const biometria = data.biometria;

      if (message) {

        if (message === 'FINALIZADO') {
          
          document.getElementById('biometry').value = biometria;
          alert('Biometria capturada com sucesso!');
          eventSource.close();
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
      console.error("Erro na conexão com a porta serial.");
      eventSource.close();
    };
  });
});