<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Histórico de Marcações')</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 flex flex-col min-h-screen">

    {{-- Cabeçalho clean, sem botão de sair --}}
    <header class="bg-gradient-to-r from-indigo-500 to-purple-600 text-white px-6 py-4 shadow-md">
        <div class="max-w-4xl mx-auto flex justify-between items-center">
            <h1 class="text-lg font-bold">@yield('title', 'Histórico de Marcações')</h1>
        </div>
    </header>

    {{-- Conteúdo central --}}
    <main class="flex-1 flex items-start justify-center p-6">
        <div class="w-full max-w-3xl bg-white rounded-xl shadow-xl p-6">
            @yield('content')
        </div>
    </main>

    {{-- Rodapé discreto com logout --}}
    <footer class="bg-gray-200 text-center py-3 text-sm text-gray-600">
        &copy; {{ date('Y') }} Ponto Empresa
        <form action="{{ route('logout') }}" method="POST" class="inline-block ml-4">
            @csrf
            <button type="submit" class="text-gray-500 hover:text-red-600 text-xs underline">
                Sair
            </button>
        </form>
    </footer>
</body>
</html>
