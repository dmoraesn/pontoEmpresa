@extends('layouts.app')

@section('title', 'Feriados')

@section('content')
<div class="container-fluid">

    <h1 class="text-2xl font-bold mb-6">Gerenciar Feriados</h1>

    {{-- Alertas --}}
    @if(session('success'))
        <div class="bg-green-100 text-green-800 px-4 py-3 rounded mb-4">
            {{ session('success') }}
        </div>
    @endif

    @if($errors->any())
        <div class="bg-red-100 text-red-800 px-4 py-3 rounded mb-4">
            <ul class="mb-0 list-disc list-inside">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    {{-- Formulário --}}
    <div class="bg-white shadow rounded-xl p-6 mb-8">
        <h2 class="text-lg font-semibold mb-4">Cadastrar Feriado</h2>
        <form method="POST" action="{{ route('feriados.store') }}" class="grid grid-cols-1 md:grid-cols-3 gap-4">
            @csrf

            <div>
                <label class="block text-sm font-medium text-gray-700">Data</label>
                <input type="date" name="data" class="w-full border rounded px-3 py-2" required>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700">Descrição</label>
                <input type="text" name="descricao" class="w-full border rounded px-3 py-2" required>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700">Tipo</label>
                <select name="tipo" class="w-full border rounded px-3 py-2">
                    <option value="nacional">Nacional</option>
                    <option value="estadual">Estadual</option>
                    <option value="municipal">Municipal</option>
                    <option value="empresa">Empresa</option>
                </select>
            </div>

            <div class="col-span-full">
                <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
                    Salvar
                </button>
            </div>
        </form>
    </div>

    {{-- Tabela --}}
    <div class="bg-white shadow rounded-xl p-6">
        <h2 class="text-lg font-semibold mb-4">Feriados Cadastrados</h2>
        <div class="overflow-x-auto">
            <table class="table-auto w-full text-left border-collapse">
                <thead>
                    <tr class="bg-gray-100">
                        <th class="px-4 py-2">Data</th>
                        <th class="px-4 py-2">Descrição</th>
                        <th class="px-4 py-2">Tipo</th>
                        <th class="px-4 py-2">Ações</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($feriados as $feriado)
                        <tr class="border-b">
                            <td class="px-4 py-2">{{ \Carbon\Carbon::parse($feriado->data)->format('d/m/Y') }}</td>
                            <td class="px-4 py-2">{{ $feriado->descricao }}</td>
                            <td class="px-4 py-2 capitalize">{{ $feriado->tipo }}</td>
                            <td class="px-4 py-2 space-x-2">
                                <a href="{{ route('feriados.edit', $feriado->id) }}" 
                                   class="bg-yellow-500 text-white px-3 py-1 rounded hover:bg-yellow-600">
                                    Editar
                                </a>
                                <form action="{{ route('feriados.destroy', $feriado->id) }}" method="POST" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" 
                                            class="bg-red-600 text-white px-3 py-1 rounded hover:bg-red-700"
                                            onclick="return confirm('Tem certeza que deseja excluir este feriado?')">
                                        Excluir
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="px-4 py-2 text-gray-500 text-center">Nenhum feriado cadastrado.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

</div>
@endsection
