@extends('layouts.funcionario')

@section('title', 'Histórico de Marcações')

@section('content')
    <h2 class="text-3xl font-extrabold text-indigo-800 mb-6 flex items-center justify-center space-x-2">
        <span class="material-symbols-outlined text-4xl">history</span>
        <span>Histórico de Marcações</span>
    </h2>

    @if ($marcacoes->isEmpty())
        <div class="p-6 bg-gray-50 rounded-xl shadow-inner border border-gray-200">
            <p class="text-center text-gray-600 font-medium">Nenhuma marcação encontrada neste histórico.</p>
        </div>
    @else
        <div class="overflow-x-auto rounded-xl shadow-lg border border-indigo-200">
            <table class="min-w-full">
                <thead class="bg-indigo-600 text-white sticky top-0">
                    <tr>
                        <th class="px-4 py-3 text-left">Data</th>
                        <th class="px-4 py-3 text-left">Hora</th>
                        <th class="px-4 py-3 text-left">Tipo</th>
                        <th class="px-4 py-3 text-left">Origem</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($marcacoes as $m)
                        @php
                            $tipoCor = $m->tipo === 'Entrada' ? 'text-green-700 bg-green-50' : 'text-red-700 bg-red-50';
                            $origemIcone = $m->origem === 'web_qr' ? 'qr_code_2' : 'edit';
                        @endphp
                        <tr class="border-b border-gray-100 hover:bg-gray-50">
                            <td class="px-4 py-3 text-gray-700">{{ \Carbon\Carbon::parse($m->data_hora)->format('d/m/Y') }}</td>
                            <td class="px-4 py-3 font-mono text-gray-800">{{ \Carbon\Carbon::parse($m->data_hora)->format('H:i') }}</td>
                            <td class="px-4 py-3">
                                <span class="text-xs font-bold px-3 py-1 rounded-full {{ $tipoCor }}">
                                    {{ $m->tipo }}
                                </span>
                            </td>
                            <td class="px-4 py-3 text-sm text-gray-500">
                                <span class="material-symbols-outlined text-base align-middle" title="{{ $m->origem }}">
                                    {{ $origemIcone }}
                                </span>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endif

    {{-- Paginação (Se for Blade do Laravel, usa o método links()) --}}
    @if ($marcacoes->hasPages())
        <div class="mt-6">
            {{ $marcacoes->links() }}
        </div>
    @endif

    <div class="mt-8 flex justify-center">
        <a href="{{ route('funcionario.ponto') }}"
           class="inline-flex items-center space-x-2 px-6 py-3 bg-indigo-600 hover:bg-indigo-700 text-white font-bold rounded-full shadow-lg transition duration-150 transform hover:-translate-y-0.5">
            <span class="material-symbols-outlined">chevron_left</span>
            <span>Voltar ao Ponto</span>
        </a>
    </div>
@endsection
