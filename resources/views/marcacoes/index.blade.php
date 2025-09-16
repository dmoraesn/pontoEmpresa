@extends('layouts.app')

@section('title', 'Marcações de ' . $usuario->nome)

@push('styles')
    <style>
        .flatpickr-confirm {
            background-color: #2563eb;
            color: #fff;
            border: none;
            border-radius: 6px;
            padding: 6px 12px;
            font-size: 0.875rem;
            font-weight: 500;
            cursor: pointer;
            transition: background-color 0.2s ease;
        }
        .flatpickr-confirm:hover {
            background-color: #1e40af;
        }
    </style>
@endpush

@section('content')
    <div class="max-w-5xl mx-auto">
        {{-- Título --}}
        <h1 class="text-2xl font-bold text-gray-800 mb-6">
            Marcações de {{ $usuario->nome }}
        </h1>

        {{-- Formulário de nova marcação --}}
        <div class="bg-white p-6 rounded-lg shadow-md mb-8">
            <h2 class="text-lg font-semibold text-gray-700 mb-4">Adicionar Marcação</h2>

            <form action="{{ route('usuarios.ponto.store', $usuario->id) }}" method="POST" class="space-y-4">
                @csrf

                {{-- Tipo --}}
                <div>
                    <label for="tipo" class="block text-sm font-medium text-gray-700">Tipo</label>
                    <select id="tipo" name="tipo" required
                        class="mt-1 block w-full border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                        <option value="entrada">Entrada</option>
                        <option value="saida">Saída</option>
                    </select>
                </div>

                {{-- Data e Hora --}}
                <div>
                    <label for="data_hora" class="block text-sm font-medium text-gray-700">Data e Hora</label>
                    <input type="text" id="data_hora" name="data_hora" required
                        placeholder="Selecione a data e hora"
                        class="mt-1 block w-full border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                </div>

                {{-- Botão --}}
                <button type="submit"
                    class="bg-blue-600 text-white px-5 py-2 rounded-lg shadow hover:bg-blue-700 transition">
                    Salvar
                </button>
            </form>
        </div>

        {{-- Lista de Marcações --}}
        <div class="bg-white p-6 rounded-lg shadow-md">
            <h2 class="text-lg font-semibold text-gray-700 mb-4">Marcações Registradas</h2>

            @forelse($marcacoesPorDia as $dia => $lista)
                {{-- Cabeçalho da data --}}
                <div class="bg-gray-100 px-4 py-2 rounded-md mb-2 font-semibold text-gray-800">
                    {{ formatarData($dia) }}
                </div>

                <div class="overflow-x-auto mb-6">
                    <table class="min-w-full divide-y divide-gray-200 text-sm">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-4 py-2 text-left font-medium text-gray-600">Hora</th>
                                <th class="px-4 py-2 text-left font-medium text-gray-600">Tipo</th>
                                <th class="px-4 py-2 text-left font-medium text-gray-600">Origem</th>
                                <th class="px-4 py-2 text-left font-medium text-gray-600">Ações</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200">
                            @foreach($lista as $marcacao)
                                <tr class="hover:bg-gray-50">
                                    {{-- Hora --}}
                                    <td class="px-4 py-2 font-mono">
                                        {{ formatarHora($marcacao->data_hora) }}
                                    </td>

                                    {{-- Tipo --}}
                                    <td class="px-4 py-2">
                                        <span class="px-2 py-1 rounded-full text-xs font-semibold
                                            @if($marcacao->tipo === 'entrada') bg-green-100 text-green-700
                                            @elseif($marcacao->tipo === 'saida') bg-red-100 text-red-700
                                            @else bg-gray-100 text-gray-700 @endif">
                                            {{ ucfirst($marcacao->tipo) }}
                                        </span>
                                    </td>

                                    {{-- Origem --}}
                                    <td class="px-4 py-2">
                                        {{ $marcacao->origem ?? '--' }}
                                    </td>

                                    {{-- Ações --}}
                                    <td class="px-4 py-2 flex items-center gap-2">
                                        {{-- Editar --}}
                                        <a href="{{ route('usuarios.ponto.edit', [$usuario->id, $marcacao->id]) }}"
                                           class="text-blue-600 hover:text-blue-800 text-sm font-medium">
                                           Editar
                                        </a>

                                        {{-- Excluir --}}
                                        <form action="{{ route('usuarios.ponto.destroy', [$usuario->id, $marcacao->id]) }}"
                                              method="POST"
                                              onsubmit="return confirm('Tem certeza que deseja excluir esta marcação?')"
                                              class="inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                    class="text-red-600 hover:text-red-800 text-sm font-medium">
                                                Excluir
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @empty
                <p class="text-gray-500 text-center py-6">
                    Nenhuma marcação encontrada para este período.
                </p>
            @endforelse
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        flatpickr("#data_hora", {
            enableTime: true,
            dateFormat: "d/m/Y H:i",
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
