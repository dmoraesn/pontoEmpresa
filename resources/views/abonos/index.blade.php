@extends('layouts.app')

@section('title', 'Abonos de ' . $usuario->nome)

@section('content')
    <div class="max-w-5xl mx-auto">
        {{-- Título --}}
        <h1 class="text-2xl font-bold text-gray-800 mb-6">
            Abonos de {{ $usuario->nome }}
        </h1>

        {{-- Formulário de novo abono --}}
        <div class="bg-white p-6 rounded-lg shadow-md mb-8">
            <h2 class="text-lg font-semibold text-gray-700 mb-4">Adicionar Novo Abono</h2>

            <form action="{{ route('usuarios.abonos.store', $usuario->id) }}" method="POST" class="space-y-4">
                @csrf

                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                    <div>
                        <label for="data" class="block text-sm font-medium text-gray-700">Data</label>
                        <input type="date" name="data" id="data"
                               class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm"
                               required>
                    </div>

                    <div>
                        <label for="duracao" class="block text-sm font-medium text-gray-700">Duração</label>
                        <input type="time" name="duracao" id="duracao" step="60" value="01:00"
                               class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm"
                               required>
                        <small class="text-gray-500">HH:MM</small>
                    </div>

                    <div>
                        <label for="tipo" class="block text-sm font-medium text-gray-700">Tipo</label>
                        <select name="tipo" id="tipo"
                                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                            <option value="abonado">Abonado (+)</option>
                            <option value="desconto">Desconto (-)</option>
                        </select>
                    </div>

                    <div>
                        <label for="motivo" class="block text-sm font-medium text-gray-700">Motivo (opcional)</label>
                        <input type="text" name="motivo" id="motivo"
                               placeholder="Descrição do abono"
                               class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                    </div>
                </div>

                <div>
                    <button type="submit"
                            class="bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700">
                        Adicionar
                    </button>
                </div>
            </form>
        </div>

        {{-- Lista de Abonos --}}
        <div class="bg-white p-6 rounded-lg shadow-md">
            <h2 class="text-lg font-semibold text-gray-700 mb-4">Histórico de Abonos</h2>

            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200 text-sm">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-4 py-2 text-left font-medium text-gray-600">Data</th>
                            <th class="px-4 py-2 text-left font-medium text-gray-600">Tipo</th>
                            <th class="px-4 py-2 text-left font-medium text-gray-600">Duração</th>
                            <th class="px-4 py-2 text-left font-medium text-gray-600">Motivo</th>
                            <th class="px-4 py-2 text-right font-medium text-gray-600">Ações</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @forelse($abonos as $abono)
                            <tr>
                                <td class="px-4 py-2 text-gray-700">
                                    {{ \Carbon\Carbon::parse($abono->data)->format('d/m/Y') }}
                                </td>
                                <td class="px-4 py-2">
                                    @if($abono->tipo === 'abonado')
                                        <span class="px-2 py-1 text-xs font-semibold bg-green-100 text-green-800 rounded-full">Abonado</span>
                                    @elseif($abono->tipo === 'desconto')
                                        <span class="px-2 py-1 text-xs font-semibold bg-red-100 text-red-800 rounded-full">Desconto</span>
                                    @else
                                        <span class="px-2 py-1 text-xs font-semibold bg-gray-100 text-gray-800 rounded-full">{{ ucfirst($abono->tipo) }}</span>
                                    @endif
                                </td>
                                <td class="px-4 py-2 text-gray-700">
                                    {{ sprintf('%02d:%02d', intdiv($abono->minutos, 60), $abono->minutos % 60) }}
                                </td>
                                <td class="px-4 py-2 text-gray-700">
                                    {{ $abono->motivo ?? '-' }}
                                </td>
                                <td class="px-4 py-2 text-right">
                                    <form action="{{ route('usuarios.abonos.destroy', [$usuario->id, $abono->id]) }}" method="POST"
                                          onsubmit="return confirm('Excluir este abono?')" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-600 hover:underline">Excluir</button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-4 py-2 text-center text-gray-500">Nenhum abono registrado.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
