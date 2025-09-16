{{-- resources/views/auth/login.blade.php --}}
@extends('layouts.public')

@section('content')
<div class="max-w-md mx-auto mt-10 p-6 bg-white rounded shadow">
    <h2 class="text-xl font-bold mb-4">Login Leitura</h2>

    <form method="POST" action="{{ route('leitura.auth') }}">
        @csrf

        <div class="mb-4">
            <label class="block mb-1">Usuário</label>
            <input type="text" name="usuario" class="w-full border px-3 py-2 rounded" required>
        </div>

        <div class="mb-4">
            <label class="block mb-1">Senha</label>
            <input type="password" name="senha" class="w-full border px-3 py-2 rounded" required>
        </div>

        @if($errors->any())
            <div class="text-red-500 mb-4">{{ $errors->first() }}</div>
        @endif

        <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">Entrar</button>
    </form>
</div>
@endsection
