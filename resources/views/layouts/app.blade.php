<!DOCTYPE html>
<html lang="pt-BR" class="h-full">
<head>
    @livewireStyles
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Ponto Empresa') - Ponto Empresa</title>

    {{-- Tailwind CSS via CDN --}}
    <script src="https://cdn.tailwindcss.com"></script>

    {{-- Ícones Remixicon --}}
    <link href="https://cdn.jsdelivr.net/npm/remixicon@4.2.0/fonts/remixicon.css" rel="stylesheet"/>

    {{-- Fonte Inter --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    {{-- Flatpickr + Plugin ConfirmDate + Localização --}}
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <link rel="stylesheet" href="https://npmcdn.com/flatpickr/dist/plugins/confirmDate/confirmDate.css">

    <style>
        body {
            font-family: 'Inter', sans-serif;
            background-color: #f1f5f9; /* slate-100 */
        }
    </style>

    {{-- Estilos extras (via @push) --}}
    @stack('styles')
</head>
<body class="antialiased h-full">

<div class="flex h-screen bg-gray-100">
    {{-- Sidebar --}}
    <aside class="w-64 bg-gray-800 text-gray-300 p-4 flex flex-col">
        <div class="text-white text-2xl font-bold border-b border-gray-700 pb-4 mb-4 flex items-center">
            <i class="ri-time-line text-blue-400 mr-2"></i>
            <span>Ponto Empresa</span>
        </div>

        <nav class="flex-grow space-y-2">
            <x-sidebar-link route="dashboard" icon="ri-dashboard-line" label="Dashboard" />
            <x-sidebar-link route="usuarios.index" icon="ri-group-line" label="Usuários" />
            <x-sidebar-link route="horarios.index" icon="ri-time-history-line" label="Horários" />
            <x-sidebar-link route="feriados.index" icon="ri-calendar-event-line" label="Feriados" />
            <x-sidebar-link route="afastamentos.index" icon="ri-user-unfollow-line" label="Afastamentos" />
        </nav>
    </aside>

    {{-- Conteúdo principal --}}
    <div class="flex-1 flex flex-col overflow-hidden">
        {{-- Cabeçalho --}}
        <header class="bg-white shadow-sm p-4 flex justify-end items-center">
            <span class="text-gray-700 font-semibold mr-3">Administrador</span>
            <i class="ri-user-3-line text-2xl text-gray-600"></i>
        </header>

        {{-- Conteúdo dinâmico --}}
        <main class="flex-1 overflow-x-hidden overflow-y-auto p-6">
            {{-- Mensagens Flash --}}
            @if(session('error'))
                <div class="mb-4 p-3 rounded bg-red-100 border border-red-400 text-red-700">
                    <i class="ri-error-warning-line mr-1"></i>
                    {{ session('error') }}
                </div>
            @endif

            @if(session('success'))
                <div class="mb-4 p-3 rounded bg-green-100 border border-green-400 text-green-700">
                    <i class="ri-checkbox-circle-line mr-1"></i>
                    {{ session('success') }}
                </div>
            @endif

            @yield('content')
        </main>
    </div>
</div>

{{-- Alpine.js --}}
<script src="//unpkg.com/alpinejs" defer></script>

{{-- Flatpickr JS e plugins --}}
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
<script src="https://npmcdn.com/flatpickr/dist/l10n/pt.js"></script>
<script src="https://npmcdn.com/flatpickr/dist/plugins/confirmDate/confirmDate.js"></script>

{{-- Scripts extras (via @push) --}}
@stack('scripts')

@livewireScripts
</body>
</html>
