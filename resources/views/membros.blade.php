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
    
    <link rel="stylesheet" href="{{ asset('css/membros.css') }}">
    <link rel="stylesheet" href=@yield('css')>

    <title> @yield('title') </title> 
  
  </head> 
  <body> 
    <main> 
      <div class="menu-bar">
        <div class="div-1">
          <a href="/"><i class="fa-solid fa-house"></i>Página Inicial</a>
          <a href="{{ route('historico') }}"><i class="fa-solid fa-list"></i></i>Histórico</a>
          <a href="{{ route('membros.index') }}"><i class="fa-regular fa-clipboard"></i>Membros</a>
        </div>
        <div class="div-2">
          <form action="{{ route('logout') }}" method="POST" style="display: inline;">
            @csrf
            <button type="submit" style="background: none; border: none;">
              <i class="fa-solid fa-right-from-bracket"></i> Sair
            </button>
          </form>
        </div>
      </div>
      @yield('main')
      <div class="pesquisa">
        <input type="text" class="campo-pesquisa" placeholder="Pesquisar">
        <button class="botao-pesquisa">
        🔍
        </button>
      </div>


      <div class="fundo_verde">

        <ul class="nomes">
          <li>Fulano <a href="p"><i class="fa-regular fa-pen-to-square"></i></a><a href="#"><i class="fa-solid fa-trash-can"></i></a></li>
          <li>Ciclano<a href="p"><i class="fa-regular fa-pen-to-square"></i></a><a href="#"><i class="fa-solid fa-trash-can"></i></a></li>
          <li>Beltrano<a href="p"><i class="fa-regular fa-pen-to-square"></i></a><a href="#"><i class="fa-solid fa-trash-can"></i></a></li>
          <li>João<a href="p"><i class="fa-regular fa-pen-to-square"></i></a><a href="#"><i class="fa-solid fa-trash-can"></i></a></li>
          <li>Eduarda<a href="p"><i class="fa-regular fa-pen-to-square"></i></a><a href="#"><i class="fa-solid fa-trash-can"></i></a></li>
          <li>Lucas<a href="p"><i class="fa-regular fa-pen-to-square"></i></a><a href="#"><i class="fa-solid fa-trash-can"></i></a></li>
          <li>Rebeca<a href="p"><i class="fa-regular fa-pen-to-square"></i></a><a href="#"><i class="fa-solid fa-trash-can"></i></a></li>
          <li>Sofia<a href="p"><i class="fa-regular fa-pen-to-square"></i></a><a href="#"><i class="fa-solid fa-trash-can"></i></a></li>
          <li>Julia<a href="p"><i class="fa-regular fa-pen-to-square"></i></a><a href="#"><i class="fa-solid fa-trash-can"></i></a></li>
        </ul>
      </div>
      <div class="cadastrar">
        <a href="{{ route('user.cadUser') }}">
          <h1> Cadastrar +</h1>
        </a>
      </div>

    </main> 
    <footer> <!-- Conteúdo do rodapé --> </footer> 
    <script src=@yield('script')></script> 
  </body> 
</html>