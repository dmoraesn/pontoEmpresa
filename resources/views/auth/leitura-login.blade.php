<!-- resources/views/auth/leitura-login.blade.php -->

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Login Leitura QR</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <style>
        body { font-family: sans-serif; padding: 2rem; background: #f7f7f7; }
        .card { max-width: 400px; margin: auto; padding: 2rem; background: white; border-radius: 8px; box-shadow: 0 0 15px #ddd; }
        input, button { width: 100%; padding: 0.75rem; margin-top: 1rem; }
    </style>
</head>
<body>
    <div class="card">
        <h2>Login para Leitura</h2>
        <form action="{{ route('leitura.auth') }}" method="POST">
            @csrf
            <label>CPF ou Login</label>
            <input type="text" name="cpf" value="{{ old('cpf') }}" required>

            <label>Senha</label>
            <input type="password" name="senha" required>

            @error('cpf')
                <p style="color:red;">{{ $message }}</p>
            @enderror

            <button type="submit">Entrar</button>
        </form>
    </div>
</body>
</html>
