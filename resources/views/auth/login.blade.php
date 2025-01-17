<!DOCTYPE html>

<html lang="pt-br">
  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    {{-- Fonts Google  --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:ital,opsz,wght@0,14..32,100..900;1,14..32,100..900&display=swap" rel="stylesheet">

    {{-- Ícones --}}
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">

    {{-- CSS --}}
    <link rel="stylesheet" href="{{ asset('css/login.css') }}">

    <title>Login</title>
  </head>
  <body>
    <header>
        <img src="{{ asset('images/logo-uem.png') }}" alt="Logo da UEM">
        <img src="{{ asset('images/logo-din.png') }}" alt="Logo da DIN">
    </header>
    <main>
        <div class="login-container">
            <h1>Login</h1>
            <form action="{{ url('/login') }}" method="POST">
                @csrf
                <div class="form-group">
                    <label for="email">Registro Acadêmico (RA):</label>
                    <input type="email" name="email" id="email" required>
                    @error('email')
                        <div class="error">{{ $message }}</div>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="password">Senha: </label>
                    <input type="password" name="password" id="password" required>
                    @error('password')
                        <div class="error">{{ $message }}</div>
                    @enderror
                </div>
                <div class="form-group">
                    <button type="submit">Entrar</button>
                </div>
            </form>
        </div>
    </main>
    
  </body>
</html>