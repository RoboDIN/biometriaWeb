function confirmarExclusao(event, email) {
  event.preventDefault(); // Impede o envio imediato do formulário

  Swal.fire({
    title: 'Tem certeza?',
    text: "Essa ação excluirá o usuário definitivamente!",
    icon: 'warning',
    showCancelButton: true,
    confirmButtonColor: '#3085d6', // Azul
    cancelButtonColor: '#d33',      // Vermelho
    confirmButtonText: 'Sim, excluir!',
    cancelButtonText: 'Cancelar'
  }).then((result) => {
    if (result.isConfirmed) {
      document.getElementById('formExcluir-' + email).submit();
    }
  });

  return false; // Sempre retorna false para não submeter ainda
}


document.addEventListener('DOMContentLoaded', function() { 
  confirmarExclusao();
});
