@extends('layouts.base_app') 

@section('title', 'Membros') 
@section('css') {{ asset('css/membros.css') }} @endsection


@section('container') 

  <div class="search-box">
    <form action="search" action="{{ route('membro.search') }}" method="GET">
      <input type="search" name="name" placeholder="Pesquisar">
      <button type="submit"><i ty class="fa-solid fa-magnifying-glass"></i></button>
    </form>
    <a href="{{ route('user.cadUser') }}">Cadastrar +</a>
  </div>

  <div class="list-box">
    @if(session('erro'))
      <div class="alert alert-danger">
        {{ session('erro') }}
      </div>
    @endif

    @if($users->isEmpty())
      <p>Nenhum usuário encontrado.</p>
    @else
      <ul>
        @foreach($users as $user)
          <li>

            {{ $user->name }}
            <!-- <button type="button">Editar</button> -->
            @if(auth()->user()->is_admin)
                <a href="{{ route('user.edit', ['email' => $user->email]) }}">Editar</a>
            @endif
            
            <form action="{{ route('user.destroy', ['email' => $user->email]) }}" method="POST" style="display:inline;" onsubmit="return confirm('Tem certeza que deseja excluir?');">
              @csrf
              @method('DELETE')
              <button type="submit" class="delete-btn"><i class="fa-solid fa-trash"></i></button>
            </form>
            </div>
          </li>
        @endforeach
      </ul>
    @endif
  </div>

@endsection
