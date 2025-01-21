<!DOCTYPE html> 

<html lang="pt-br"> 
  <head> 

    <meta charset="UTF-8"> 
    <meta name="viewport" content="width=device-width, initial-scale=1.0"> 

    {{-- Fonts Google  --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:ital,opsz,wght@0,14..32,100..900;1,14..32,100..900&display=swap" rel="stylesheet">

    {{-- Ícones --}}
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <link rel="stylesheet" href=@yield('css')>

    <title> @yield('title') </title> 
  
  </head> 
  <body> 
    <main> 
      <div class="menu-bar">
        <div class="div-1">
          <a href="home"><i class="fa-solid fa-house"></i>Página Inicial</a>
          <a href="#"><i class="fa-solid fa-list"></i></i>Histórico</a>
          <a href="#"><i class="fa-regular fa-clipboard"></i>Listagem</a>
          <a href="/register"><i class="fa-regular fa-clipboard"></i>Cadastrar usuário</a>
        </div>
        <div class="div-2">
          <a href="logout"><i class="fa-solid fa-right-from-bracket"></i>Sair</a>  
        </div>
      </div>
      @yield('main') 
    </main> 
    <footer> <!-- Conteúdo do rodapé --> </footer> 
    <script src=@yield('script')></script> 
  </body> 
</html>