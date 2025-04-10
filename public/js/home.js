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
      const dataEntrada = data.dataEntrada;
      const horaEntrada = data.horaEntrada;

      if (message && dataEntrada) {

        const p = document.createElement('p');
        p.className = 'bg-blue-100 text-blue-700 p-2 rounded flex justify-between';

        // Cria o span da esquerda (start)
        const leftSpan = document.createElement('span');
        leftSpan.textContent = message; 
        leftSpan.className = 'text-start';

        // Cria o span da direita (end)
        const rightSpan = document.createElement('span');
        rightSpan.textContent = dataEntrada + ' às ' + horaEntrada;
        rightSpan.className = 'text-end text-sm text-gray-500';

        // Adiciona os dois spans ao <p>
        p.appendChild(leftSpan);
        p.appendChild(rightSpan);

        // Adiciona ao container
        messagesDiv.appendChild(p);
        messagesDiv.scrollTop = messagesDiv.scrollHeight;

      } else if (message) {

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
