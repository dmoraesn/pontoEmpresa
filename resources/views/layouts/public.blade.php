<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Sistema de Ponto')</title>

    {{-- Estilos (Tailwind via Vite) --}}
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    {{-- Fallback caso Tailwind não carregue --}}
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
</head>
<body class="bg-gray-100 min-h-screen flex flex-col">

    {{-- Cabeçalho (aparece só para usuários logados) --}}
    @auth
        <header class="bg-white shadow">
            <div class="max-w-7xl mx-auto px-4 py-4 flex items-center justify-between">
                <div class="flex items-center space-x-3">
                    <img src="{{ asset('images/logo.png') }}" alt="Logo da Empresa" class="h-10">
                    <span class="text-xl font-bold text-gray-700">Sistema de Ponto</span>
                </div>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="text-sm text-red-600 hover:underline">Sair</button>
                </form>
            </div>
        </header>
    @endauth

    {{-- Conteúdo principal --}}
    <main class="flex-1 flex items-center justify-center p-6">
        @yield('content')
    </main>

    {{-- Rodapé --}}
    <footer class="bg-gray-200 text-center py-4 text-sm text-gray-600">
        &copy; {{ date('Y') }} - Sistema de Ponto. Todos os direitos reservados.
    </footer>

</body>
</html>
