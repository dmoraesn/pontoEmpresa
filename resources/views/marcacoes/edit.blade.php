@extends('layouts.app')

@section('title', 'Editar Marcação')

@push('styles')
    <style>
        .flatpickr-confirm {
            background-color: #2563eb; /* azul */
            color: white;
            border: none;
            border-radius: 4px;
            padding: 4px 10px;
            font-size: 0.875rem;
            font-weight: 500;
            cursor: pointer;
        }
        .flatpickr-confirm:hover {
            background-color: #1e40af;
        }
    </style>
@endpush

@section('content')
    <div class="max-w-lg mx-auto">
        {{-- Título --}}
        <h1 class="text-2xl font-bold text-gray-800 mb-6">
            Editar Marcação
        </h1>

        {{-- Formulário de edição --}}
        <div class="bg-white p-6 rounded-lg shadow-md">
            <form action="{{ route('usuarios.ponto.update', [$usuario->id, $marcacao->id]) }}" method="POST" class="space-y-4">
                @csrf
                @method('PUT')

                <div>
                    <label for="tipo" class="block text-sm font-medium text-gray-700">Tipo</label>
                    <select name="tipo" id="tipo" required
                            class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                        <option value="entrada" {{ $marcacao->tipo === 'entrada' ? 'selected' : '' }}>Entrada</option>
                        <option value="saida" {{ $marcacao->tipo === 'saida' ? 'selected' : '' }}>Saída</option>
                    </select>
                </div>

                <div>
                    <label for="data_hora" class="block text-sm font-medium text-gray-700">Data e Hora</label>
                    <input type="text" name="data_hora" id="data_hora"
                           value="{{ $marcacao->data_hora->timezone('America/Sao_Paulo')->format('d/m/Y H:i') }}"
                           class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm"
                           required>
                </div>

                <div class="flex justify-between">
                    <a href="{{ route('usuarios.ponto.index', $usuario->id) }}"
                       class="px-4 py-2 bg-gray-300 rounded-md text-gray-800 hover:bg-gray-400">
                        Cancelar
                    </a>

                    <button type="submit"
                            class="bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700">
                        Atualizar
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        flatpickr("#data_hora", {
            enableTime: true,
            dateFormat: "d/m/Y H:i", // <-- DD/MM/YYYY
            locale: "pt",
            time_24hr: true,
            plugins: [
                new confirmDatePlugin({
                    confirmText: "OK",
                    showAlways: false,
                    theme: "light"
                })
            ]
        });
    </script>
@endpush
