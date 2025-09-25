{{-- resources/views/layouts/funcionario.blade.php (FINALIZADO E UNIFICADO) --}}
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Ponto Empresa - Funcionário')</title>
    <script src="https://cdn.tailwindcss.com"></script>

    {{-- Material Symbols (Ícones do Google) --}}
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" rel="stylesheet" />

    @stack('styles')
</head>
<body class="bg-indigo-50 flex flex-col min-h-screen">

    {{-- Cabeçalho Estilizado (Topo do App) --}}
    <header class="bg-white px-6 py-4 shadow-lg sticky top-0 z-10">
        <div class="max-w-md mx-auto flex justify-between items-center">
            <h1 class="text-xl font-extrabold text-indigo-700 flex items-center space-x-2">
                <span class="material-symbols-outlined text-2xl">fingerprint</span>
                <span>Ponto Digital</span>
            </h1>
            <div class="flex items-center space-x-2">
                {{-- Nome do usuário com ícone (Auth::user() deve ser usado se o layout for para usuários logados) --}}
                <span class="material-symbols-outlined text-indigo-500">account_circle</span>
                <span class="text-sm font-medium text-gray-700">@if(Auth::check()){{ Auth::user()->nome ?? Auth::user()->name }}@else Funcionário @endif</span>
            </div>
        </div>
    </header>

    {{-- Conteúdo principal do App --}}
    <main class="flex-1 flex justify-center p-4">
        {{-- O max-w-md é mantido aqui para manter o visual de "tela de celular" --}}
        <div class="w-full max-w-md bg-white rounded-2xl shadow-2xl p-6 text-center">
            @yield('content')
        </div>
    </main>

    {{-- Rodapé/Navegação --}}
    <footer class="bg-white border-t border-gray-200 text-center py-3 text-sm text-gray-500 shadow-xl">
        <div class="max-w-md mx-auto flex justify-center items-center">
            &copy; {{ date('Y') }} Ponto Digital

            {{-- Botão de Sair/Logout --}}
            <a href="{{ route('logout') }}"
               onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
               class="text-red-500 hover:text-red-700 ml-6 font-medium flex items-center space-x-1 transition duration-150">
                <span class="material-symbols-outlined text-base">logout</span>
                <span>Sair</span>
            </a>
            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="hidden">
                @csrf
            </form>
        </div>
    </footer>

    @stack('scripts')
</body>
</html>
