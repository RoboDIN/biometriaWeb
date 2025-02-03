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
  var adminCheckbox = document.getElementById('admin');
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

document.addEventListener('DOMContentLoaded', function() {
  document.getElementById('start-serial').addEventListener('click', function() {
    fetch('/register/serial').then(response => {
      if (response.ok) {
        console.log("Comunicação serial iniciada.");
      }
    });
  });

  function fetchMessages() {
    fetch('/register/messages').then(response => response.json()).then(messages => {
      const messagesContainer = document.getElementById('serial-messages');
      const messagesInput = document.getElementById('serial-messages-input');
      messagesContainer.innerHTML = '';
      messagesInput.value = ''
      messages.forEach(message => {
        const p = document.createElement('p');
        p.textContent = message;
        messagesContainer.appendChild(p);
        messagesInput.value += message + '\n';
      });
    });
  }

  setInterval(fetchMessages, 2000); // Atualiza as mensagens a cada 2 segundos
});

