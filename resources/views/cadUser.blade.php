@extends('layouts.base_app') 

@section('title', 'Cadastro de Usuário') 
@section('css') {{ asset('css/cadUser.css') }} @endsection

@section('container') 
  <h1>Cadastro de Usuário</h1>

  @if (session('success'))
    <p style="color: green;">{{ session('success') }}</p>
  @endif

  <form action="{{ route('user.store') }}" method="POST" enctype="multipart/form-data">
    @csrf
    <div class="item">
      <div class="div">
        <label for="name">Nome:</label>
        <input type="text" id="name" name="name" value="{{ old('name') }}" required>
        @error('name')<p style="color: red;">{{ $message }}</p>@enderror
      </div>
      <div class="div">
        <label for="entry_date">Data de Entrada:</label>
        <input type="date" id="entry_date" name="entry_date" value="{{ old('entry_date') }}" readonly>
        @error('entry_date')<p style="color: red;">{{ $message }}</p>@enderror
      </div>
      <div class="div">
        <label for="genre">Sexo:</label>
        <select id="genre" name="genre">
          <option value="">Selecione</option>
          <option value="masculino" {{ old('genre') == 'masculino' ? 'selected' : '' }}>Masculino</option>
          <option value="feminino" {{ old('genre') == 'feminino' ? 'selected' : '' }}>Feminino</option>
          <option value="outro" {{ old('genre') == 'outro' ? 'selected' : '' }}>Outro</option>
        </select>
        @error('genre')<p style="color: red;">{{ $message }}</p>@enderror
      </div>
    </div>
    <div class="item">
      <div class="div">
        <label for="email">E-mail institucional:</label>
        <input type="email" id="email" name="email" value="{{ old('email') }}" required>
        @error('email')<p style="color: red;">{{ $message }}</p>@enderror
      </div>
      <div class="div">
        <label for="advisor">Nome do Orientador:</label>
        <input type="text" id="advisor" name="advisor" value="{{ old('advisor') }}">
        @error('advisor')<p style="color: red;">{{ $message }}</p>@enderror
      </div>
    </div>
    <div class="item">
      <div class="div">
        <input type="checkbox" id="is_admin" name="is_admin" value="1" {{ old('is_admin') == '1' ? 'checked' : '' }}> 
        <label for="admin_yes">Administrador</label> 
        @error('is_dmin')<p style="color: red;">{{ $message }}</p>@enderror
      </div>
      <div id="div-senha" class="hidden">
        <div class="box">
          <label for="password">Senha:</label>
          <input type="password" id="password" name="password" required>
          @error('password')<p style="color: red;">{{ $message }}</p>@enderror
        </div>
        <div class="box">
          <label for="password_confirmation">Confirmar Senha:</label>
          <input type="password" id="password_confirmation" name="password_confirmation" required>
        </div>
      </div>
    </div>
    <button type="submit">Cadastrar</button>
  </form>

  <div class="container-bio">
    <div class="div">
      <div class="box-digital"></div>
      <form id="form-executar-script">
        <button type="submit">Cadastrar Digital</button>
      </form>
    </div>
    <div class="div">
      <header>Mensagens</header>
      <div id="messages">
      </div>
    </div>
  </div>
@endsection

@section('script') {{ asset('js/app.js') }}@endsection

