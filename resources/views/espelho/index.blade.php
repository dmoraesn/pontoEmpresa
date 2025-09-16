@extends('layouts.app')

@section('title', 'Espelho de Ponto')

@section('content')
<div class="container my-4">

    <div class="text-center mb-5">
        <h1 class="fw-bold">Dashboard de Ponto</h1>
        <p class="text-muted">Visão Geral Mensal</p>
        <hr class="w-25 mx-auto border-primary">
    </div>

    <div class="row g-3 mb-4">
        <div class="col-md-3">
            <div class="border rounded p-3 bg-light">
                <strong>Funcionário</strong>
                <p class="mb-1">{{ $usuario->nome }}</p>
                <small class="text-muted">Matrícula: {{ $usuario->id }}</small>
            </div>
        </div>
        <div class="col-md-3">
            <div class="border rounded p-3 bg-light">
                <strong>Empresa</strong>
                <p class="mb-1">MUNICÍPIO DE SÃO G. DO AMARANTE</p>
                <small class="text-muted">Cargo: {{ $usuario->cargo }}</small>
            </div>
        </div>
        <div class="col-md-3">
            <div class="border rounded p-3 bg-light">
                <strong>PIS</strong>
                <p class="mb-1">{{ $usuario->pis ?? '---' }}</p>
                <small class="text-muted">Admissão: {{ \Carbon\Carbon::parse($usuario->criado_em)->format('d/m/Y') }}</small>
            </div>
        </div>
        <div class="col-md-3">
            <div class="border rounded p-3 bg-light">
                <strong>Horário</strong>
                <ul class="list-unstyled mb-0 small text-muted">
                    <li>Seg-Sex: 08:00 - 14:00</li>
                    <li>Sáb: 08:00 - 14:00</li>
                    <li>Dom/Feriado: --</li>
                </ul>
            </div>
        </div>
    </div>

    <div class="row g-3 mb-4">
        <div class="col-md-3">
            <div class="card text-white bg-primary shadow-sm">
                <div class="card-body">
                    <p class="small mb-1">Horas Trabalhadas</p>
                    <h3 class="fw-bold">{{ $resumo['horas_trabalhadas'] ?? '00:00' }}</h3>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card border shadow-sm">
                <div class="card-body">
                    <p class="small text-muted mb-1">Total a Trabalhar</p>
                    <h3 class="fw-bold">{{ $resumo['total_trabalhar'] ?? '00:00' }}</h3>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card border shadow-sm">
                <div class="card-body">
                    <p class="small text-muted mb-1">Horas Extras</p>
                    <h3 class="fw-bold">{{ $resumo['extras'] ?? '00:00' }}</h3>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card border shadow-sm">
                <div class="card-body">
                    <p class="small text-muted mb-1">Dias de Falta</p>
                    <h3 class="fw-bold">{{ $resumo['faltas'] ?? 0 }}</h3>
                </div>
            </div>
        </div>
    </div>

    <h5 class="fw-bold mb-3">Detalhes Diários</h5>
    <div class="table-responsive mb-4">
        <table class="table table-bordered table-sm align-middle">
            <thead class="table-light">
                <tr>
                    <th>Data</th>
                    <th>Pontos</th>
                    <th>HN</th>
                    <th>EN</th>
                    <th>HT</th>
                    <th>EX</th>
                    <th>FA</th>
                    <th>Anotações</th>
                </tr>
            </thead>
            <tbody>
                @forelse($detalhes as $d)
                    <tr>
                        <td>{{ $d['data'] }}</td>
                        <td>{{ $d['entrada'] }} - {{ $d['saida'] }}</td>
                        <td>00:00</td>
                        <td>00:00</td>
                        <td>{{ $d['ht'] }}</td>
                        <td>{{ $d['ex'] }}</td>
                        <td>{{ $d['fa'] }}</td>
                        <td class="text-muted fst-italic">--</td>
                    </tr>
                @empty
                    <tr><td colspan="8" class="text-center">Nenhuma marcação</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="row g-4 mb-5">
        <div class="col-md-6">
            <div class="border rounded p-3 bg-light">
                <h6 class="fw-bold mb-3">Resumo e Totais</h6>
                <ul class="list-unstyled small">
                    <li class="d-flex justify-content-between"><span>Horas Noturnas:</span><strong>00:00</strong></li>
                    <li class="d-flex justify-content-between"><span>Horas Normais + Noturnas:</span><strong>{{ $resumo['horas_trabalhadas'] ?? '00:00' }}</strong></li>
                    <li class="d-flex justify-content-between"><span>DSR a Pagar:</span><strong>00:00</strong></li>
                    <li class="d-flex justify-content-between"><span>Dias Completos de Falta:</span><strong>{{ $resumo['faltas'] ?? 0 }}</strong></li>
                    <li class="border-top pt-2 d-flex justify-content-between"><span>Total + DSR:</span><strong>{{ $resumo['total'] ?? '00:00' }}</strong></li>
                </ul>
            </div>
        </div>
        <div class="col-md-6">
            <div class="border rounded p-3 bg-light">
                <h6 class="fw-bold mb-3">Horas Extras</h6>
                <ul class="list-unstyled small">
                    <li class="d-flex justify-content-between"><span>EX 1 a 50%:</span><strong>00:00</strong></li>
                    <li class="d-flex justify-content-between"><span>EN 1 a 70%:</span><strong>00:00</strong></li>
                    <li class="d-flex justify-content-between"><span>EX 2 a 50%:</span><strong>00:00</strong></li>
                    <li class="d-flex justify-content-between"><span>EN 2 a 70%:</span><strong>00:00</strong></li>
                    <li class="d-flex justify-content-between"><span>EX 3 a 100%:</span><strong>00:00</strong></li>
                    <li class="d-flex justify-content-between"><span>EN 3 a 100%:</span><strong>00:00</strong></li>
                </ul>
            </div>
        </div>
    </div>

    <div class="row text-center">
        <div class="col-md-6">
            <hr>
            <small class="text-muted">Assinatura do Funcionário</small>
        </div>
        <div class="col-md-6">
            <hr>
            <small class="text-muted">Assinatura do Responsável</small>
        </div>
    </div>

</div>
@endsection