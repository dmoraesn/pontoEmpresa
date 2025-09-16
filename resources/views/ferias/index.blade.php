@extends('layouts.app')

@section('title', 'Férias')

@section('content')
<div class="container">
  <h1 class="mb-4">Férias de {{ $usuario->nome }}</h1>

  @if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
  @endif

  <!-- Formulário para cadastrar férias -->
  <form action="{{ route('usuarios.ferias.store', $usuario->id) }}" method="POST" class="mb-4">
    @csrf
    <div class="row g-3">
      <div class="col-md-3">
        <label class="form-label">Data Início</label>
        <input type="date" name="data_inicio" class="form-control" required>
      </div>
      <div class="col-md-3">
        <label class="form-label">Data Fim</label>
        <input type="date" name="data_fim" class="form-control" required>
      </div>
      <div class="col-md-4">
        <label class="form-label">Observação</label>
        <input type="text" name="observacao" class="form-control">
      </div>
      <div class="col-md-2 d-flex align-items-end">
        <button type="submit" class="btn btn-primary w-100">Cadastrar</button>
      </div>
    </div>
  </form>

  <!-- Lista de férias -->
  <table class="table table-hover">
    <thead>
      <tr>
        <th>Início</th>
        <th>Fim</th>
        <th>Observação</th>
        <th>Ações</th>
      </tr>
    </thead>
    <tbody>
      @forelse($ferias as $f)
        <tr>
          <td>{{ \Carbon\Carbon::parse($f->data_inicio)->format('d/m/Y') }}</td>
          <td>{{ \Carbon\Carbon::parse($f->data_fim)->format('d/m/Y') }}</td>
          <td>{{ $f->observacao }}</td>
          <td>
            <form action="{{ route('usuarios.ferias.destroy', [$usuario->id, $f->id]) }}" method="POST" onsubmit="return confirm('Deseja realmente excluir?')">
              @csrf
              @method('DELETE')
              <button class="btn btn-sm btn-danger">Excluir</button>
            </form>
          </td>
        </tr>
      @empty
        <tr>
          <td colspan="4" class="text-center text-muted">Nenhum registro de férias</td>
        </tr>
      @endforelse
    </tbody>
  </table>
</div>
@endsection
