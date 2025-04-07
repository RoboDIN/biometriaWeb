@extends('layouts.base_app') 

@section('title', 'Home') 
@section('css') {{ asset('css/home.css') }} @endsection

@section('container') 
  <div id="messagesHome">
  </div>
@endsection

@section('script') {{ asset('js/home.js') }}@endsection
