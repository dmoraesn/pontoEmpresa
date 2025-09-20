@extends('layouts.app')

@section('title', 'Editar Afastamento')

@section('content')
<div class="max-w-3xl mx-auto">
    {{-- Cabeçalho da página --}}
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold text-gray-800">
            <i class="ri-user-unfollow-line text-blue-500 mr-2"></i>
            Editar Afastamento
        </h1>
        <a href="{{ route('afastamentos.index') }}"
           class="bg-gray-200 text-gray-800 px-4 py-2 rounded-lg shadow hover:bg-gray-300 transition">
            Voltar
        </a>
    </div>

    {{-- Formulário --}}
    <div class="bg-white shadow rounded-lg p-6">
        <form action="{{ route('afastamentos.update', $afastamento) }}" method="POST">
            @csrf
            @method('PUT')

            {{-- Usuário --}}
            <div class="mb-4">
                <label for="usuario_id" class="block text-sm font-medium text-gray-700">Funcionário</label>
                <select name="usuario_id" id="usuario_id"
                        class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                    @foreach($usuarios as $usuario)
                        <option value="{{ $usuario->id }}"
                                {{ old('usuario_id', $afastamento->usuario_id) == $usuario->id ? 'selected' : '' }}>
                            {{ $usuario->nome }}
                        </option>
                    @endforeach
                </select>
                @error('usuario_id')
                    <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- Tipo --}}
            <div class="mb-4">
                <label for="tipo" class="block text-sm font-medium text-gray-700">Tipo de Afastamento</label>
                <input type="text" name="tipo" id="tipo" value="{{ old('tipo', $afastamento->tipo) }}"
                       class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                @error('tipo')
                    <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- Data Início --}}
            <div class="mb-4">
                <label for="data_inicio" class="block text-sm font-medium text-gray-700">Data de Início</label>
                <input type="date" name="data_inicio" id="data_inicio"
                       value="{{ old('data_inicio', $afastamento->data_inicio) }}"
                       class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                @error('data_inicio')
                    <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- Data Fim --}}
            <div class="mb-4">
                <label for="data_fim" class="block text-sm font-medium text-gray-700">Data de Fim (opcional)</label>
                <input type="date" name="data_fim" id="data_fim"
                       value="{{ old('data_fim', $afastamento->data_fim) }}"
                       class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                @error('data_fim')
                    <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- Observação --}}
            <div class="mb-6">
                <label for="observacao" class="block text-sm font-medium text-gray-700">Observação</label>
                <textarea name="observacao" id="observacao" rows="3"
                          class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">{{ old('observacao', $afastamento->observacao) }}</textarea>
                @error('observacao')
                    <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- Botões --}}
            <div class="flex justify-end space-x-2">
                <a href="{{ route('afastamentos.index') }}"
                   class="px-4 py-2 bg-gray-200 text-gray-800 rounded-lg shadow hover:bg-gray-300">
                    Cancelar
                </a>
                <button type="submit"
                        class="px-4 py-2 bg-blue-600 text-white rounded-lg shadow hover:bg-blue-700">
                    Atualizar
                </button>
            </div>
        </form>
    </div>
</div>
@endsection