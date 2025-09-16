@extends('layouts.app')

@section('title', 'Usuários')

@section('content')
<div class="w-full bg-white rounded-xl shadow-md p-6">
    <div class="flex flex-col sm:flex-row justify-between items-start mb-6 border-b pb-4">
        <div>
            <h1 class="text-2xl font-bold text-gray-800">Usuários</h1>
            <p class="text-gray-500">Listagem de Funcionários</p>
        </div>
        <div class="mt-4 sm:mt-0">
            <a href="{{ route('usuarios.create') }}"
               class="bg-blue-600 text-white px-5 py-2.5 rounded-full font-medium text-sm hover:bg-blue-700 transition shadow">
                <i class="ri-user-add-line mr-1"></i> Novo Usuário
            </a>
        </div>
    </div>

    @if(session('success'))
        <div class="mb-4 p-4 rounded-lg bg-green-100 text-green-800 font-medium">
            {{ session('success') }}
        </div>
    @endif

    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200 text-sm">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left font-semibold text-gray-600">Nome</th>
                    <th class="px-6 py-3 text-left font-semibold text-gray-600">Email</th>
                    <th class="px-6 py-3 text-left font-semibold text-gray-600">CPF</th>
                    <th class="px-6 py-3 text-left font-semibold text-gray-600">Cargo</th>
                    <th class="px-6 py-3 text-center font-semibold text-gray-600">Ações</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200">
                @forelse($usuarios as $u)
                    <tr class="hover:bg-gray-50 transition">
                        <td class="px-6 py-3 font-medium text-gray-800">{{ $u->nome }}</td>
                        <td class="px-6 py-3 text-gray-600">{{ $u->email ?? '-' }}</td>
                        <td class="px-6 py-3 text-gray-600">{{ $u->cpf ?? '-' }}</td>
                        <td class="px-6 py-3 text-gray-600">{{ $u->cargo ?? '-' }}</td>
                        <td class="px-6 py-3 text-center">
                            {{-- INÍCIO DA SEÇÃO DE AÇÕES ATUALIZADA --}}
                            <div class="flex justify-center items-center gap-2">

                                <a href="{{ route('usuarios.ponto.index', $u->id) }}" class="group p-2 rounded-full hover:bg-blue-100 transition-colors duration-200" title="Ver Ponto">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5 text-gray-500 group-hover:text-blue-600">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                </a>

                                <a href="{{ route('usuarios.abonos.index', $u->id) }}" class="group p-2 rounded-full hover:bg-blue-100 transition-colors duration-200" title="Ver Abonos">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5 text-gray-500 group-hover:text-blue-600">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                </a>

                                <a href="{{ route('usuarios.espelho', $u->id) }}" class="group p-2 rounded-full hover:bg-blue-100 transition-colors duration-200" title="Ver Espelho de Ponto">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5 text-gray-500 group-hover:text-blue-600">
                                      <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 012.25-2.25h13.5A2.25 2.25 0 0121 7.5v11.25m-18 0A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75m-18 0h18M-4.5 12h22.5" />
                                    </svg>
                                </a>

                                <a href="{{ route('usuarios.show', $u->id) }}" class="group p-2 rounded-full hover:bg-blue-100 transition-colors duration-200" title="Ver Detalhes do Usuário">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5 text-gray-500 group-hover:text-blue-600">
                                      <path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                      <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                    </svg>
                                </a>

                            </div>
                            {{-- FIM DA SEÇÃO DE AÇÕES --}}
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="px-6 py-4 text-center text-gray-500">
                            Nenhum usuário cadastrado.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection