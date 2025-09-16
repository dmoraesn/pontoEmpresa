@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
<div class="container-fluid">

    {{-- Cabeçalho --}}
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 mb-0 fw-bold">Dashboard de Ponto</h1>
            <small class="text-muted">Gestão de Jornada de Trabalho</small>
        </div>
        <div class="text-end">
            <div class="fw-semibold text-muted">{{ now()->translatedFormat('l, d \\d\\e F \\d\\e Y') }}</div>
            <div class="fs-4 fw-bold">{{ now()->format('H:i:s') }}</div>
        </div>
    </div>

    {{-- Cards --}}
    <div class="row g-3 mb-4">
        <div class="col-md-3">
            <div class="card text-white bg-primary shadow-sm">
                <div class="card-body d-flex justify-content-between align-items-center">
                    <div>
                        <p class="mb-1 small">Total de Funcionários</p>
                        <h3 class="fw-bold">{{ $totalFuncionarios }}</h3>
                    </div>
                    <i class="bi bi-people fs-1 opacity-75"></i>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card text-white bg-success shadow-sm">
                <div class="card-body d-flex justify-content-between align-items-center">
                    <div>
                        <p class="mb-1 small">Presentes Hoje</p>
                        <h3 class="fw-bold">{{ $presentes }}</h3>
                    </div>
                    <i class="bi bi-check-circle fs-1 opacity-75"></i>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card text-white bg-warning shadow-sm">
                <div class="card-body d-flex justify-content-between align-items-center">
                    <div>
                        <p class="mb-1 small">Com Atrasos</p>
                        <h3 class="fw-bold">{{ $atrasos }}</h3>
                    </div>
                    <i class="bi bi-alarm fs-1 opacity-75"></i>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card text-white bg-danger shadow-sm">
                <div class="card-body d-flex justify-content-between align-items-center">
                    <div>
                        <p class="mb-1 small">Ausentes</p>
                        <h3 class="fw-bold">{{ $ausentes }}</h3>
                    </div>
                    <i class="bi bi-x-circle fs-1 opacity-75"></i>
                </div>
            </div>
        </div>
    </div>

    {{-- Tabela de registros --}}
    <div class="card shadow-sm">
        <div class="card-header fw-bold">Registros de Hoje</div>
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th>Funcionário</th>
                        <th>Entrada</th>
                        <th>Saída</th>
                        <th>Status</th>
                        <th class="text-end">Ações</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($dados as $d)
                    <tr>
                        <td>{{ $d['nome'] }} ({{ $d['id'] }})</td>
                        <td>{{ $d['entrada'] }}</td>
                        <td>{{ $d['saida'] }}</td>
                        <td>
                            @if($d['status'] === 'Presente')
                                <span class="badge bg-success">Presente</span>
                            @elseif($d['status'] === 'Inativo')
                                <span class="badge bg-secondary">Inativo</span>
                            @elseif($d['status'] === 'Ausente')
                                <span class="badge bg-danger">Ausente</span>
                            @elseif($d['status'] === 'Atrasado')
                                <span class="badge bg-warning text-dark">Atrasado</span>
                            @endif
                        </td>
                        <td class="text-end">
                            <button class="btn btn-sm btn-info text-white" onclick="editarMarcacao('{{ $d['id'] }}', '{{ $d['entrada'] !== '--:--' ? now()->format('Y-m-d') . 'T' . $d['entrada'] : '' }}', '{{ $d['saida'] !== '--:--' ? now()->format('Y-m-d') . 'T' . $d['saida'] : '' }}')">
                                <i class="bi bi-pencil-square"></i> Editar
                            </button>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="text-center text-muted py-3">Nenhum registro encontrado para hoje.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<div id="modal-edicao" style="display: none; position: fixed; top: 20%; left: 40%; background: white; padding: 20px; border-radius: 8px; box-shadow: 0 2px 10px rgba(0,0,0,0.2); z-index: 999;">
    <form id="form-edicao">
        @csrf
        <input type="hidden" name="usuario_id" id="usuario_id">

        <label for="entrada">Entrada:</label>
        <input type="datetime-local" name="entrada" id="entrada" class="form-control">

        <label for="saida" class="mt-2">Saída:</label>
        <input type="datetime-local" name="saida" id="saida" class="form-control">

        <div class="mt-3">
            <button type="submit" class="btn btn-primary">Salvar</button>
            <button type="button" class="btn btn-secondary" onclick="fecharModal()">Cancelar</button>
        </div>
    </form>
</div>
@endsection

@push('scripts')
<script>
    function editarMarcacao(usuarioId, entrada = '', saida = '') {
        document.getElementById('usuario_id').value = usuarioId;
        document.getElementById('entrada').value = entrada;
        document.getElementById('saida').value = saida;
        document.getElementById('modal-edicao').style.display = 'block';
    }

    function fecharModal() {
        document.getElementById('modal-edicao').style.display = 'none';
    }

    document.getElementById('form-edicao').addEventListener('submit', function (e) {
        e.preventDefault();

        fetch("{{ route('dashboard.update-marcacao') }}", {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({
                usuario_id: document.getElementById('usuario_id').value,
                entrada: document.getElementById('entrada').value,
                saida: document.getElementById('saida').value,
            })
        })
        .then(res => res.json())
        .then(data => {
            if (data.success) {
                alert("Marcações atualizadas com sucesso!");
                location.reload();
            } else {
                alert("Erro ao salvar: " + data.error);
            }
        })
        .catch(err => {
            alert("Erro ao salvar!");
            console.error(err);
        });
    });
</script>
@endpush