@extends('layouts.base_app') 

@section('title', 'Editar Usuário') 
@section('css') {{ asset('css/cadUser.css') }} @endsection

@section('container') 
  <h1>Editar Usuário</h1>

  @if (session('success'))
    <p style="color: green;">{{ session('success') }}</p>
  @endif

  <!-- O formulário direciona para a rota update com método PUT -->
  <form action="{{ route('user.update', ['email' => $user->email]) }}" method="POST">
    @csrf
    @method('PUT')

    <div class="item">
      <div class="div">
        <label for="name">Nome:</label>
        <input type="text" id="name" name="name" value="{{ old('name', $user->name) }}" required>
        @error('name')<p style="color: red;">{{ $message }}</p>@enderror
      </div>
      <div class="div">
        <label for="entry_date">Data de Entrada:</label>
        <!-- Se deseja permitir alteração dessa data, remova o readonly; senão, deixe como readonly -->
        <input type="date" id="entry_date" name="entry_date" value="{{ old('entry_date', $user->entry_date ? $user->entry_date->format('Y-m-d') : '') }}" readonly>
        @error('entry_date')<p style="color: red;">{{ $message }}</p>@enderror
      </div>
      <div class="div">
        <label for="genre">Sexo:</label>
        <select id="genre" name="genre">
          <option value="">Selecione</option>
          <option value="Masculino" {{ old('genre', $user->genre) == 'Masculino' ? 'selected' : '' }}>Masculino</option>
          <option value="Feminino" {{ old('genre', $user->genre) == 'Feminino' ? 'selected' : '' }}>Feminino</option>
          <option value="Outro" {{ old('genre', $user->genre) == 'Outro' ? 'selected' : '' }}>Outro</option>
        </select>
        @error('genre')<p style="color: red;">{{ $message }}</p>@enderror
      </div>
    </div>

    <div class="item">
      <div class="div">
        <label for="email">E-mail institucional:</label>
        <!-- Se o email for chave primária e não pode ser alterado, torne o campo readonly ou desabilitado -->
        <input type="email" id="email" name="email" value="{{ old('email', $user->email) }}" readonly>
        @error('email')<p style="color: red;">{{ $message }}</p>@enderror
      </div>
      <div class="div">
        <label for="advisor">Nome do Orientador:</label>
        <input type="text" id="advisor" name="advisor" value="{{ old('advisor', $user->advisor) }}">
        @error('advisor')<p style="color: red;">{{ $message }}</p>@enderror
      </div>
    </div>

    <div class="item">
      <div class="div">
        <input type="checkbox" id="is_admin" name="is_admin" value="1" {{ old('is_admin', $user->is_admin) == 1 ? 'checked' : '' }}> 
        <label for="is_admin">Administrador</label> 
        @error('is_admin')<p style="color: red;">{{ $message }}</p>@enderror
      </div>

    </div>

    <button type="submit">Salvar</button>
    <a href="{{ route('membros.index') }}">Cancelar</a>
  </form>
@endsection

@section('script') {{ asset('js/cadUser.js') }}@endsection
