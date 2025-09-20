@extends('layouts.app')

@section('title', 'Detalhes do Afastamento')

@section('content')
<div class="max-w-3xl mx-auto">
    {{-- Cabeçalho da página --}}
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold text-gray-800">
            <i class="ri-user-unfollow-line text-blue-500 mr-2"></i>
            Detalhes do Afastamento
        </h1>
        <a href="{{ route('afastamentos.index') }}"
           class="bg-gray-200 text-gray-800 px-4 py-2 rounded-lg shadow hover:bg-gray-300 transition">
            Voltar
        </a>
    </div>

    {{-- Card com detalhes --}}
    <div class="bg-white shadow rounded-lg p-6 space-y-4">
        <div>
            <h2 class="text-sm font-semibold text-gray-500">Funcionário</h2>
            <p class="text-gray-800">{{ $afastamento->usuario->nome ?? '-' }}</p>
        </div>

        <div>
            <h2 class="text-sm font-semibold text-gray-500">Tipo</h2>
            <p class="text-gray-800">{{ $afastamento->tipo }}</p>
        </div>

        <div>
            <h2 class="text-sm font-semibold text-gray-500">Data de Início</h2>
            <p class="text-gray-800">
                {{ \Carbon\Carbon::parse($afastamento->data_inicio)->format('d/m/Y') }}
            </p>
        </div>

        <div>
            <h2 class="text-sm font-semibold text-gray-500">Data de Fim</h2>
            <p class="text-gray-800">
                {{ $afastamento->data_fim ? \Carbon\Carbon::parse($afastamento->data_fim)->format('d/m/Y') : '-' }}
            </p>
        </div>

        <div>
            <h2 class="text-sm font-semibold text-gray-500">Observação</h2>
            <p class="text-gray-800">{{ $afastamento->observacao ?? '-' }}</p>
        </div>
    </div>

    {{-- Ações --}}
    <div class="flex justify-end space-x-2 mt-6">
        <a href="{{ route('afastamentos.edit', $afastamento) }}"
           class="px-4 py-2 bg-blue-600 text-white rounded-lg shadow hover:bg-blue-700">
            Editar
        </a>
        <form action="{{ route('afastamentos.destroy', $afastamento) }}" method="POST" class="inline">
            @csrf
            @method('DELETE')
            <button type="submit"
                    onclick="return confirm('Tem certeza que deseja excluir este afastamento?')"
                    class="px-4 py-2 bg-red-600 text-white rounded-lg shadow hover:bg-red-700">
                Excluir
            </button>
        </form>
    </div>
</div>
@endsection
