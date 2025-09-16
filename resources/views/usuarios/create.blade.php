@extends('layouts.app')

@section('title', 'Novo Usuário')

@section('content')
<h1>Novo Usuário</h1>

<form method="POST" action="{{ route('usuarios.store') }}">
  @csrf
  <div class="mb-3">
    <label class="form-label">Nome</label>
    <input type="text" name="nome" class="form-control" required>
  </div>
  <div class="mb-3">
    <label class="form-label">E-mail</label>
    <input type="email" name="email" class="form-control">
  </div>
  <div class="mb-3">
    <label class="form-label">CPF</label>
    <input type="text" name="cpf" class="form-control">
  </div>
  <div class="mb-3">
    <label class="form-label">Cargo</label>
    <input type="text" name="cargo" class="form-control">
  </div>
  <button type="submit" class="btn btn-success">Salvar</button>
  <a href="{{ route('usuarios.index') }}" class="btn btn-secondary">Cancelar</a>
</form>
@endsection
