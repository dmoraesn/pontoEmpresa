@extends('layouts.app')

@section('title', 'Horários')

@section('content')
<div class="container-fluid">

    <h1 class="text-2xl font-bold mb-6">Gerenciar Horários</h1>

    {{-- Mensagens de sucesso --}}
    @if(session('success'))
        <div class="bg-green-100 text-green-800 px-4 py-3 rounded mb-4">
            {{ session('success') }}
        </div>
    @endif

    {{-- Formulário de cadastro --}}
    <div class="bg-white shadow rounded-xl p-6 mb-8">
        <h2 class="text-lg font-semibold mb-4">Novo Horário</h2>
        <form action="{{ route('horarios.store') }}" method="POST" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
            @csrf

            <div>
                <label class="block text-sm font-medium text-gray-700">Funcionário</label>
                <select name="usuario_id" class="w-full border rounded px-3 py-2">
                    <option value="">Selecione...</option>
                    @foreach($usuarios as $usuario)
                        <option value="{{ $usuario->id }}">{{ $usuario->nome }}</option>
                    @endforeach
                </select>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700">Carga Horária (h)</label>
                <input type="number" name="carga_horas" class="w-full border rounded px-3 py-2" min="1" required>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700">Hora Entrada</label>
                <input type="time" name="hora_entrada_prevista" class="w-full border rounded px-3 py-2" required>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700">Hora Saída</label>
                <input type="time" name="hora_saida_prevista" class="w-full border rounded px-3 py-2" required>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700">Intervalo (min)</label>
                <input type="number" name="intervalo_minimo_minutos" class="w-full border rounded px-3 py-2" min="0" required>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700">Vigente Desde</label>
                <input type="date" name="vigente_desde" class="w-full border rounded px-3 py-2" required>
            </div>

            <div class="col-span-full">
                <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
                    Salvar
                </button>
            </div>
        </form>
    </div>

    {{-- Lista de horários --}}
    <div class="bg-white shadow rounded-xl p-6">
        <h2 class="text-lg font-semibold mb-4">Horários Cadastrados</h2>
        <div class="overflow-x-auto">
            <table class="table-auto w-full text-left border-collapse">
                <thead>
                    <tr class="bg-gray-100">
                        <th class="px-4 py-2">Funcionário</th>
                        <th class="px-4 py-2">Carga (h)</th>
                        <th class="px-4 py-2">Entrada</th>
                        <th class="px-4 py-2">Saída</th>
                        <th class="px-4 py-2">Intervalo (min)</th>
                        <th class="px-4 py-2">Vigente Desde</th>
                        <th class="px-4 py-2 text-center">Ações</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($horarios as $horario)
                        <tr class="border-b">
                            <td class="px-4 py-2">{{ $horario->usuario->nome }}</td>
                            <td class="px-4 py-2">{{ $horario->carga_horas }}</td>
                            <td class="px-4 py-2">{{ \Carbon\Carbon::parse($horario->hora_entrada_prevista)->format('H:i') }}</td>
                            <td class="px-4 py-2">{{ \Carbon\Carbon::parse($horario->hora_saida_prevista)->format('H:i') }}</td>
                            <td class="px-4 py-2">{{ $horario->intervalo_minimo_minutos }}</td>
                            <td class="px-4 py-2">{{ \Carbon\Carbon::parse($horario->vigente_desde)->format('d/m/Y') }}</td>
                            <td class="px-4 py-2 flex space-x-2 justify-center">
                                {{-- Botão Editar --}}
                                <a href="{{ route('horarios.edit', $horario->id) }}"
                                   class="bg-yellow-500 text-white px-3 py-1 rounded hover:bg-yellow-600 text-sm">
                                    Editar
                                </a>

                                {{-- Botão Excluir --}}
                                <form action="{{ route('horarios.destroy', $horario->id) }}" method="POST" onsubmit="return confirm('Tem certeza que deseja excluir este horário?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="bg-red-600 text-white px-3 py-1 rounded hover:bg-red-700 text-sm">
                                        Excluir
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="px-4 py-2 text-gray-500 text-center">Nenhum horário cadastrado.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

</div>
@endsection
