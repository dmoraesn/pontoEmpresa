@extends('layouts.public')

@section('title', 'Login')

@section('content')
<div class="w-full max-w-md bg-white rounded-lg shadow-md p-8">

    {{-- Logo ou imagem padrão --}}
    <div class="flex justify-center mb-6">
        <img src="{{ asset('images/logo.png') }}"
             onerror="this.onerror=null;this.src='https://cdn-icons-png.flaticon.com/512/5087/5087579.png';"
             alt="Logo"
             class="h-16">
    </div>

    <h2 class="text-2xl font-semibold text-gray-800 text-center mb-2">
        Acesse sua conta
    </h2>
    <p class="text-sm text-gray-500 text-center mb-6">
        Insira suas credenciais para continuar
    </p>

    {{-- Formulário --}}
    <form method="POST" action="{{ route('login.auth') }}">
        @csrf

        {{-- E-mail --}}
        <div class="mb-5">
            <label for="email" class="block text-sm font-medium text-gray-600 mb-1">E-mail</label>
            <input type="email"
                   id="email"
                   name="email"
                   value="{{ old('email') }}"
                   class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500 focus:outline-none"
                   placeholder="Seu e-mail"
                   required
                   autofocus
                   aria-invalid="{{ $errors->has('email') ? 'true' : 'false' }}">
        </div>

        {{-- Senha --}}
        <div class="mb-5">
            <label for="password" class="block text-sm font-medium text-gray-600 mb-1">Senha</label>
            <input type="password"
                   id="password"
                   name="password"
                   class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500 focus:outline-none"
                   placeholder="Sua senha"
                   required
                   aria-invalid="{{ $errors->has('password') ? 'true' : 'false' }}">
        </div>

        {{-- Erros --}}
        @if($errors->any())
            <div class="text-red-500 text-sm mb-4">
                {{ $errors->first() }}
            </div>
        @endif

        {{-- Botão --}}
        <button type="submit"
                class="w-full bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 rounded-md shadow-md transition">
            Entrar
        </button>
    </form>

    {{-- Link extra --}}
    <div class="text-center mt-4">
        <a href="#" class="text-sm text-blue-600 hover:underline">Esqueceu sua senha?</a>
    </div>
</div>
@endsection
