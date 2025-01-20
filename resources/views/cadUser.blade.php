@extends('layouts.base_app') 

@section('title', 'Cadastro de Usuário') 
@section('css') {{ asset('css/cadUser.css') }} @endsection

@section('main') 

  <div class="container">
    <h1>Cadastro de Usuário</h1>

    @if (session('success'))
      <p style="color: green;">{{ session('success') }}</p>
    @endif

    <form action="{{ route('store') }}" method="POST" enctype="multipart/form-data">
      @csrf
      <div class="item">
        <div class="div">
          <label for="name">Nome:</label>
          <input type="text" id="name" name="name" value="{{ old('name') }}" required>
          @error('name')<p style="color: red;">{{ $message }}</p>@enderror
        </div>
        <div class="div">
          <label for="email">E-mail institucional:</label>
          <input type="email" id="email" name="email" value="{{ old('email') }}" required>
          @error('email')<p style="color: red;">{{ $message }}</p>@enderror
        </div>
      </div>

      <div class="item">
        <div class="div">
          <label for="orientador">Orientador:</label>
          <input type="text" id="orientador" name="orientador" value="{{ old('orientador') }}">
          @error('orientador')<p style="color: red;">{{ $message }}</p>@enderror
        </div>
        <div class="div">
          <label for="dataEntrada">Data de Entrada:</label>
          <input type="date" id="dataEntrada" name="dataEntrada" value="{{ old('dataEntrada') }}" readonly>
          @error('dataEntrada')<p style="color: red;">{{ $message }}</p>@enderror
        </div>
      </div>

      <div class="item">

        <div class="div">
          <label for="biometria">Biometria:</label>
          <input type="file" id="biometria" name="biometria" accept="image/*">
          @error('biometria')<p style="color: red;">{{ $message }}</p>@enderror
        </div>

        <div class="div">

          <label for="sexo">Sexo:</label>
          <select id="sexo" name="sexo">
            <option value="">Selecione</option>
            <option value="masculino" {{ old('sexo') == 'masculino' ? 'selected' : '' }}>Masculino</option>
            <option value="feminino" {{ old('sexo') == 'feminino' ? 'selected' : '' }}>Feminino</option>
            <option value="outro" {{ old('sexo') == 'outro' ? 'selected' : '' }}>Outro</option>
          </select>
          @error('sexo')<p style="color: red;">{{ $message }}</p>@enderror
          
          <h2> Informe-se se o usuário será administrador</h2>

          <div class="div-1">
            <input type="checkbox" id="admin" name="admin" value="1" {{ old('admin') == '1' ? 'checked' : '' }}> 
            <label for="admin_yes">Administrador</label> 
            @error('admin')<p style="color: red;">{{ $message }}</p>@enderror
          </div>
          
          <div id="div-senha" class="hidden">
            <label for="password">Senha:</label>
            <input type="password" id="password" name="password" required>
            @error('password')<p style="color: red;">{{ $message }}</p>@enderror

            <label for="password_confirmation">Confirmar Senha:</label>
            <input type="password" id="password_confirmation" name="password_confirmation" required>
          </div>
        </div>
      </div>
      <button type="submit">Cadastrar</button>
    </form>
  </div>
@endsection

@section('script') {{ asset('js/app.js') }}@endsection

