@extends('layouts.base_app')

@section('title', 'Histórico')
@section('css', asset('css/historico.css'))

@section('container')
  <h1>Histórico de Acesso</h1>
  <div class="box">
    <table class="users">
      <tbody>
        @foreach($acessos as $acesso)
          <tr class="users_dados">
            <td colspan="3"> 
              <div class="users_infos">
                <span>{{ $acesso->user->name }}</span>
                <span>{{ $acesso->data }}</span>
                <span>{{ $acesso->hora }}</span>
              </div>
            </td>
          </tr>
        @endforeach
      </tbody>
    </table>
  </div>
@endsection

