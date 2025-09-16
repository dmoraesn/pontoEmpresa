@extends('layouts.app')

@section('title', 'Dashboard de Ponto')

@section('content')
<div class="w-full bg-white rounded-xl shadow-md p-6">
    <div class="flex flex-col sm:flex-row justify-between items-center mb-6 border-b pb-4">
        <div>
            <h1 class="text-2xl font-bold text-gray-800">
                Dashboard de Ponto - {{ $dados['usuario']->nome }}
            </h1>
            <p class="text-gray-500">
                Visão Mensal - {{ \Carbon\Carbon::createFromFormat('Y-m', $dados['mes_ano'])->isoFormat('MMMM [de] YYYY') }}
            </p>
        </div>
        
        <div class="mt-4 sm:mt-0 flex items-center gap-2">
            
            <form action="{{ route('usuarios.espelho', $dados['usuario']->id) }}" method="GET" class="flex items-center gap-2">
                <input
                    type="month"
                    name="mes_ano"
                    value="{{ $dados['mes_ano'] }}"
                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5">
                <button type="submit" class="bg-blue-600 text-white px-5 py-2.5 rounded-lg font-medium text-sm hover:bg-blue-700 transition shadow">
                    Filtrar
                </button>
            </form>
            
            <a href="{{ route('usuarios.espelho.pdf', ['usuario' => $dados['usuario']->id, 'mes_ano' => $dados['mes_ano']]) }}"
               target="_blank"
               class="p-2.5 bg-red-600 text-white rounded-lg hover:bg-red-700 transition shadow"
               title="Salvar como PDF">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M3 16.5v2.25A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75V16.5M16.5 12L12 16.5m0 0L7.5 12m4.5 4.5V3" />
                </svg>
            </a>
            </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
        <div class="bg-blue-600 text-white p-4 rounded-lg shadow-lg"><p class="text-sm">Horas Trabalhadas</p><p class="text-2xl font-bold">{{ $dados['totais']['horasTrabalhadas'] }}</p></div>
        <div class="bg-white p-4 rounded-lg shadow-sm border"><p class="text-sm text-gray-500">Total Previsto</p><p class="text-2xl font-bold">{{ $dados['totais']['horasPrevistas'] }}</p></div>
        <div class="bg-white p-4 rounded-lg shadow-sm border"><p class="text-sm text-gray-500">Horas Extras</p><p class="text-2xl font-bold">{{ $dados['totais']['horasExtras'] }}</p></div>
        <div class="bg-white p-4 rounded-lg shadow-sm border"><p class="text-sm text-gray-500">Dias de Falta</p><p class="text-2xl font-bold">{{ $dados['totais']['diasFalta'] }}</p></div>
    </div>

    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200 text-sm">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-4 py-2 text-left font-semibold text-gray-600">Dia</th>
                    <th class="px-4 py-2 text-left font-semibold text-gray-600">Marcações</th>
                    <th class="px-4 py-2 text-center font-semibold text-gray-600">H. Trab.</th>
                    <th class="px-4 py-2 text-center font-semibold text-gray-600">H. Extra</th>
                    <th class="px-4 py-2 text-center font-semibold text-gray-600">Faltas</th>
                    <th class="px-4 py-2 text-center font-semibold text-gray-600">Anotações</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200">
                @forelse ($dados['dias'] as $dia)
                    <tr class="hover:bg-gray-50">
                        <td class="px-4 py-2 font-medium">{{ $dia['data'] }} ({{ $dia['dia_semana'] }})</td>
                        <td class="px-4 py-2">
                            @forelse($dia['pontos'] as $ponto)
                                <span class="bg-gray-200 text-gray-700 px-2 py-1 rounded-full text-xs font-mono">{{ $ponto->data_hora->format('H:i') }}</span>
                            @empty
                                --
                            @endforelse
                        </td>
                        <td class="px-4 py-2 text-center font-mono">{{ formatarMinutos($dia['trabalhado']) }}</td>
                        <td class="px-4 py-2 text-center font-mono text-green-600">{{ formatarMinutos($dia['extra']) }}</td>
                        <td class="px-4 py-2 text-center font-mono text-red-600">{{ formatarMinutos($dia['falta']) }}</td>
                        <td class="px-4 py-2 text-center font-semibold">
                            @if ($dia['status'])
                                <span class="text-sm px-2 py-1 rounded-full 
                                    @if($dia['status'] == 'Falta') bg-red-100 text-red-700 
                                    @elseif($dia['status'] == 'Férias') bg-blue-100 text-blue-700 
                                    @else bg-gray-100 text-gray-700 @endif">
                                    {{ $dia['status'] }}
                                </span>
                            @else
                                --
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="px-6 py-4 text-center text-gray-500">
                            Nenhum dado encontrado para este período.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection