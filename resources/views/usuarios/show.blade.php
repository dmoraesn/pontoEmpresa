@extends('layouts.app')

@section('title', 'Detalhes do Usuário')

@section('content')
<div class="container">
  <h1 class="mb-4">Usuário: {{ $usuario->nome }}</h1>

  <div class="card mb-4">
    <div class="card-body">
      <p><strong>Email:</strong> {{ $usuario->email }}</p>
      <p><strong>CPF:</strong> {{ $usuario->cpf }}</p>
      <p><strong>Cargo:</strong> {{ $usuario->cargo }}</p>
    </div>
  </div>

  <div class="d-flex gap-2">
    <a href="{{ route('usuarios.ponto.index', $usuario->id) }}" class="btn btn-primary">
      <i class="bi bi-clock"></i> Ver Marcações
    </a>
    <a href="{{ route('usuarios.abonos.index', $usuario->id) }}" class="btn btn-warning">
      <i class="bi bi-calendar-x"></i> Ver Abonos
    </a>
    <a href="{{ route('usuarios.espelho', $usuario->id) }}" class="btn btn-info text-white">
      <i class="bi bi-file-earmark-text"></i> Espelho de Ponto
    </a>
  </div>
</div>
@endsection
