@extends('layouts.base_app')
@section('title', 'Histórico')
@section('css', asset('css/historico.css'))
@section('container')
  <h1>Histórico de Acesso</h1>
  <div class="box">
    <table>
      <thead>
        <tr>
          <th>Usuário</th>
          <th>Data</th>
          <th>Hora</th>
        </tr>
      </thead>
      <tbody>
        @foreach($acessos as $acesso)
          <tr>
            <td>{{ $acesso->user->name }}</td> <!-- Nome do usuário -->
            <td>{{ $acesso->data }}</td> <!-- Data do acesso -->
            <td>{{ $acesso->hora }}</td> <!-- Hora do acesso -->
          </tr>
        @endforeach
      </tbody>
    </table>
  </div>
@endsection

