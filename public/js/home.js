function readBiometria() {
  const messagesDiv = document.getElementById('messagesHome');
  let eventSource = null;

  // Inicia a leitura da serial após o formulário ser enviado
  function startSerialConnection() {

    if(eventSource){
      return;
    }

    eventSource = new EventSource('/read-arduino');

    eventSource.onmessage = function(event) {
      const data = JSON.parse(event.data);
      const message = data.message;

      if (message) {

        const p = document.createElement('p');
        p.textContent = message;
        p.className = 'bg-blue-100 text-blue-700 p-2 rounded';
        messagesDiv.appendChild(p);
        messagesDiv.scrollTop = messagesDiv.scrollHeight;

      }
    };

    eventSource.onerror = function() {
      const p = document.createElement('p');
      p.textContent = "Conexão encerrada com o Arduino.";
      p.className = 'bg-blue-100 text-blue-700 p-2 rounded';

      messagesDiv.appendChild(p);
      messagesDiv.scrollTop = messagesDiv.scrollHeight;

      // Fechar a conexão atual e tentar reconectar após 5 segundos
      eventSource.close();
      eventSource = null;
    };
  }

  startSerialConnection();
}

document.addEventListener('DOMContentLoaded', function() { 
  readBiometria();
});
