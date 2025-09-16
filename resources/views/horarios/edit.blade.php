@extends('layouts.app')

@section('title', 'Editar Horário')

@section('content')
<div class="container-fluid">

    <h1 class="text-2xl font-bold mb-6">Editar Horário</h1>

    <div class="bg-white shadow rounded-xl p-6">
        <form action="{{ route('horarios.update', $horario->id) }}" method="POST" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
            @csrf
            @method('PUT')

            <div>
                <label class="block text-sm font-medium text-gray-700">Funcionário</label>
                <select name="usuario_id" class="w-full border rounded px-3 py-2">
                    @foreach($usuarios as $usuario)
                        <option value="{{ $usuario->id }}" {{ $horario->usuario_id == $usuario->id ? 'selected' : '' }}>
                            {{ $usuario->nome }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700">Carga Horária (h)</label>
                <input type="number" name="carga_horas" value="{{ $horario->carga_horas }}" class="w-full border rounded px-3 py-2" min="1" required>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700">Hora Entrada</label>
                <input type="time" name="hora_entrada_prevista" value="{{ $horario->hora_entrada_prevista }}" class="w-full border rounded px-3 py-2" required>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700">Hora Saída</label>
                <input type="time" name="hora_saida_prevista" value="{{ $horario->hora_saida_prevista }}" class="w-full border rounded px-3 py-2" required>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700">Intervalo (min)</label>
                <input type="number" name="intervalo_minimo_minutos" value="{{ $horario->intervalo_minimo_minutos }}" class="w-full border rounded px-3 py-2" min="0" required>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700">Vigente Desde</label>
                <input type="date" name="vigente_desde" value="{{ $horario->vigente_desde }}" class="w-full border rounded px-3 py-2" required>
            </div>

            <div class="col-span-full">
                <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
                    Atualizar
                </button>
                <a href="{{ route('horarios.index') }}" class="ml-2 text-gray-600 hover:underline">Cancelar</a>
            </div>
        </form>
    </div>
</div>
@endsection
