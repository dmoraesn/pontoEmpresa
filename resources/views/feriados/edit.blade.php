@extends('layouts.app')

@section('title', 'Editar Feriado')

@section('content')
<div class="container-fluid">

    <h1 class="text-2xl font-bold mb-6">Editar Feriado</h1>

    {{-- Alertas --}}
    @if($errors->any())
        <div class="bg-red-100 text-red-800 px-4 py-3 rounded mb-4">
            <ul class="mb-0 list-disc list-inside">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    {{-- Formulário de edição --}}
    <div class="bg-white shadow rounded-xl p-6">
        <form method="POST" action="{{ route('feriados.update', $feriado->id) }}" class="grid grid-cols-1 md:grid-cols-3 gap-4">
            @csrf
            @method('PUT')

            <div>
                <label class="block text-sm font-medium text-gray-700">Data</label>
                <input type="date" name="data" 
                       value="{{ old('data', $feriado->data) }}" 
                       class="w-full border rounded px-3 py-2" required>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700">Descrição</label>
                <input type="text" name="descricao" 
                       value="{{ old('descricao', $feriado->descricao) }}" 
                       class="w-full border rounded px-3 py-2" required>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700">Tipo</label>
                <select name="tipo" class="w-full border rounded px-3 py-2">
                    <option value="nacional" {{ $feriado->tipo == 'nacional' ? 'selected' : '' }}>Nacional</option>
                    <option value="estadual" {{ $feriado->tipo == 'estadual' ? 'selected' : '' }}>Estadual</option>
                    <option value="municipal" {{ $feriado->tipo == 'municipal' ? 'selected' : '' }}>Municipal</option>
                    <option value="empresa" {{ $feriado->tipo == 'empresa' ? 'selected' : '' }}>Empresa</option>
                </select>
            </div>

            <div class="col-span-full flex space-x-2 mt-4">
                <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
                    Atualizar
                </button>
                <a href="{{ route('feriados.index') }}" 
                   class="bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-600">
                    Cancelar
                </a>
            </div>
        </form>
    </div>

</div>
@endsection
