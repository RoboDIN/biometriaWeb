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
    <h1> Resultado vai aquiii</h1>
    <ul>
      @foreach($users as $user)
        <li>{{ $user->name }}</li>
      @endforeach
    </ul>
  </div>


@endsection