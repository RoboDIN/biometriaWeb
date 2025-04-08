@extends('layouts.base_app') 

@section('title', 'Home') 
@section('css') {{ asset('css/home.css') }} @endsection

@section('container') 

  <div class="box">
    <h1> Histórico de acessos</h1>
    <div class="div-main">
      <div id="messagesHome">
      </div>
    </div>
  </div>
  
@endsection

@section('script') {{ asset('js/home.js') }}@endsection
