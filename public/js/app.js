// Apresenta data atual do cadastro no campo dataEntrada no formúlario de cadastro de usuário
document.addEventListener('DOMContentLoaded', function() { 
  var dataEntrada = document.getElementById('dataEntrada'); 
  
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

