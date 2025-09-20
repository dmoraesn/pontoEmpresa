@extends('layouts.app')

@section('title', 'Afastamentos')

@section('content')
<div class="max-w-7xl mx-auto">
    {{-- Cabeçalho da página --}}
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold text-gray-800">
            <i class="ri-user-unfollow-line text-blue-500 mr-2"></i>
            Afastamentos
        </h1>
        <a href="{{ route('afastamentos.create') }}"
           class="bg-blue-600 text-white px-4 py-2 rounded-lg shadow hover:bg-blue-700 transition">
            <i class="ri-add-line mr-1"></i> Novo Afastamento
        </a>
    </div>

    {{-- Mensagem de sucesso --}}
    @if(session('success'))
        <div class="mb-4 p-3 bg-green-100 border border-green-300 text-green-800 rounded-lg">
            {{ session('success') }}
        </div>
    @endif

    {{-- Tabela de afastamentos --}}
    <div class="bg-white shadow rounded-lg overflow-hidden">
        <table class="w-full text-left border-collapse">
            <thead class="bg-gray-100">
                <tr>
                    <th class="px-4 py-2 text-sm font-semibold text-gray-700">Funcionário</th>
                    <th class="px-4 py-2 text-sm font-semibold text-gray-700">Tipo</th>
                    <th class="px-4 py-2 text-sm font-semibold text-gray-700">Data Início</th>
                    <th class="px-4 py-2 text-sm font-semibold text-gray-700">Data Fim</th>
                    <th class="px-4 py-2 text-sm font-semibold text-gray-700">Observação</th>
                    <th class="px-4 py-2 text-sm font-semibold text-gray-700 text-center">Ações</th>
                </tr>
            </thead>
            <tbody>
                @forelse($afastamentos as $afastamento)
                    <tr class="border-t hover:bg-gray-50">
                        <td class="px-4 py-2">{{ $afastamento->usuario->nome ?? '-' }}</td>
                        <td class="px-4 py-2">{{ $afastamento->tipo }}</td>
                        <td class="px-4 py-2">{{ \Carbon\Carbon::parse($afastamento->data_inicio)->format('d/m/Y') }}</td>
                        <td class="px-4 py-2">
                            {{ $afastamento->data_fim ? \Carbon\Carbon::parse($afastamento->data_fim)->format('d/m/Y') : '-' }}
                        </td>
                        <td class="px-4 py-2">{{ $afastamento->observacao ?? '-' }}</td>
                        <td class="px-4 py-2 text-center space-x-2">
                            <a href="{{ route('afastamentos.edit', $afastamento) }}"
                               class="text-blue-600 hover:underline">
                                Editar
                            </a>
                            <form action="{{ route('afastamentos.destroy', $afastamento) }}" method="POST" class="inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-600 hover:underline"
                                        onclick="return confirm('Tem certeza que deseja excluir este afastamento?')">
                                    Excluir
                                </button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="px-4 py-4 text-center text-gray-500">
                            Nenhum afastamento registrado.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{-- Paginação --}}
    <div class="mt-4">
        {{ $afastamentos->links() }}
    </div>
</div>
@endsection
