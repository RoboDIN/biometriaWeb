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
          <span class= "username">{{ $user->name }}</span>
            <div class= "botoes">
            <button type="button" class="btn-edit"><i class="fa-regular fa-pen-to-square"></i></button>
            <button type="button" class="btn-delete"><i class="fa-solid fa-trash"></i></button>
            </div>
          </li>
        @endforeach
      </ul>
    @endif
  </div>

@endsection
