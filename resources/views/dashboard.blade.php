@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
<div class="container-fluid">

    {{-- Cabeçalho --}}
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold">Dashboard</h1>
        <span class="text-gray-600 text-sm">Hoje é {{ $dataAtual }}</span>
    </div>

    {{-- Cards de estatísticas --}}
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">

        <div class="bg-white rounded-xl shadow p-5 border-l-4 border-blue-500">
            <div class="flex items-center">
                <div class="p-3 rounded-full bg-blue-100 text-blue-600 mr-4">
                    <i class="ri-group-line text-2xl"></i>
                </div>
                <div>
                    <p class="text-sm text-gray-500">Total de Usuários</p>
                    <p class="text-2xl font-bold">{{ $usuarios }}</p>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow p-5 border-l-4 border-green-500">
            <div class="flex items-center">
                <div class="p-3 rounded-full bg-green-100 text-green-600 mr-4">
                    <i class="ri-time-line text-2xl"></i>
                </div>
                <div>
                    <p class="text-sm text-gray-500">Marcações Hoje</p>
                    <p class="text-2xl font-bold">{{ $marcacoesHoje }}</p>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow p-5 border-l-4 border-yellow-500">
            <div class="flex items-center">
                <div class="p-3 rounded-full bg-yellow-100 text-yellow-600 mr-4">
                    <i class="ri-checkbox-circle-line text-2xl"></i>
                </div>
                <div>
                    <p class="text-sm text-gray-500">Abonos no Mês</p>
                    <p class="text-2xl font-bold">{{ $abonosMes }}</p>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow p-5 border-l-4 border-red-500">
            <div class="flex items-center">
                <div class="p-3 rounded-full bg-red-100 text-red-600 mr-4">
                    <i class="ri-suitcase-line text-2xl"></i>
                </div>
                <div>
                    <p class="text-sm text-gray-500">Em Férias Hoje</p>
                    <p class="text-2xl font-bold">{{ $feriasHoje }}</p>
                </div>
            </div>
        </div>
    </div>

    {{-- Lista de funcionários --}}
    <div class="bg-white shadow rounded-xl p-6 mt-8">
        <h2 class="text-lg font-semibold mb-4">Funcionários - Presença Hoje</h2>

        <div class="overflow-x-auto">
            <table class="table-auto w-full text-left border-collapse">
                <thead>
                    <tr class="bg-gray-100">
                        <th class="px-4 py-2">Nome</th>
                        <th class="px-4 py-2">Departamento</th>
                        <th class="px-4 py-2">Primeira Entrada</th>
                        <th class="px-4 py-2">Última Saída</th>
                        <th class="px-4 py-2">Status</th>
                    </tr>
                </thead>
                <tbody>
    @php
        $ordenados = $funcionarios->sortBy(function($usuario) {
            return $usuario->marcacoes->isEmpty() ? 1 : 0;
        });
    @endphp

    @foreach($ordenados as $usuario)
        @php
            $entrada = $usuario->marcacoes->where('tipo', 'Entrada')->first();
            $saida   = $usuario->marcacoes->where('tipo', 'Saída')->last();

            if (!$entrada) {
                $status = ['label' => 'Ausente', 'color' => 'red'];
            } elseif ($entrada && !$saida) {
                $status = ['label' => 'Em Jornada', 'color' => 'yellow'];
            } else {
                $status = ['label' => 'Presente', 'color' => 'green'];
            }
        @endphp
        <tr class="border-b">
            <td class="px-4 py-2 font-medium">{{ $usuario->nome }}</td>
            <td class="px-4 py-2">{{ $usuario->departamento ?? '-' }}</td>
            <td class="px-4 py-2">{{ $entrada?->data_hora?->format('H:i') ?? '-' }}</td>
            <td class="px-4 py-2">{{ $saida?->data_hora?->format('H:i') ?? '-' }}</td>
            <td class="px-4 py-2">
                <span class="px-3 py-1 text-xs font-semibold rounded-full 
                    {{ $status['color'] === 'green' ? 'bg-green-100 text-green-800' : '' }}
                    {{ $status['color'] === 'yellow' ? 'bg-yellow-100 text-yellow-800' : '' }}
                    {{ $status['color'] === 'red' ? 'bg-red-100 text-red-800' : '' }}">
                    {{ $status['label'] }}
                </span>
            </td>
        </tr>
    @endforeach
</tbody>

            </table>
        </div>
    </div>

</div>
@endsection
