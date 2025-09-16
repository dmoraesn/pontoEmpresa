<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Espelho de Ponto A4 - {{ $dados['usuario']->nome }}</title>
    <link href="https://cdn.jsdelivr.net/npm/remixicon@4.2.0/fonts/remixicon.css" rel="stylesheet">

    <style>
        @page {
            size: A4;
            margin: 10mm; /* Margens da página para impressão */
        }
        body {
            font-family: 'Helvetica', 'Arial', sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f0f4f8; /* Apenas para visualização na tela */
            color: #1f2937;
            font-size: 8pt; /* Fonte base reduzida */
        }
        .a4-sheet {
            width: 100%;
            background-color: white;
            box-sizing: border-box;
        }
        @media print {
            body { background-color: white; }
            .a4-sheet {
                box-shadow: none;
                -webkit-print-color-adjust: exact; /* Garante cores de fundo na impressão */
                print-color-adjust: exact;
            }
        }

        table { width: 100%; border-collapse: collapse; }
        
        /* Cabeçalho e Títulos */
        header h1 { 
            font-size: 16pt; 
            text-align: center; 
            margin: 0 0 15px 0; 
            font-weight: bold; 
            text-transform: uppercase;
        }
        h3 { font-size: 11pt; font-weight: bold; margin-top: 15px; margin-bottom: 8px; border-bottom: 1px solid #e5e7eb; padding-bottom: 4px;}

        /* Seção de Informações do Topo (Estilo Dashboard com Ícones) */
        .info-section { display: table; width: 100%; border-spacing: 8px; margin-bottom: 10px;}
        .info-section-row { display: table-row; }
        .info-card {
            display: table-cell;
            width: 25%;
            background-color: #f9fafb;
            border: 1px solid #e5e7eb;
            padding: 6px 8px;
            font-size: 7.5pt;
            border-radius: 6px;
            vertical-align: top;
        }
        .info-card .label { font-weight: bold; color: #374151; font-size: 7pt; display: block; margin-bottom: 2px;}
        .info-card .value { color: #374151; }
        .info-card table td:first-child { width: 15px; padding-right: 5px; }
        .info-card .icon-sm { font-size: 11pt; color: #6b7280; vertical-align: top; }

        /* Cartões de Resumo com Ícones */
        .summary-section { display: table; width: 100%; border-spacing: 8px; margin-bottom: 10px; }
        .summary-section-row { display: table-row; }
        .summary-card {
            display: table-cell;
            width: 25%;
            border: 1px solid #e5e7eb;
            padding: 8px 10px;
            border-radius: 8px;
            background-color: #f9fafb; /* Cor de fundo padrão */
        }
        .summary-card .label { font-size: 7pt; color: #6b7280; }
        .summary-card .value { font-size: 15pt; font-weight: bold; color: #1f2937; }
        .summary-card .icon { font-size: 24pt; color: #adb5bd; }
        .summary-card table td:last-child { text-align: right; }

        /* Tabela de Detalhes Diários */
        .details-table thead th {
            background-color: #f3f4f6;
            padding: 4px 5px;
            font-size: 7pt;
            text-transform: uppercase;
            text-align: center;
        }
        .details-table tbody td {
            font-size: 7.5pt;
            padding: 3px 5px; /* Espaçamento mínimo para compactar */
            border-bottom: 1px solid #f3f4f6;
            text-align: center;
        }
        .details-table tr { page-break-inside: avoid; }
        .details-table .col-dia, .details-table .col-pontos { text-align: left; }
        .status-falta, .status-folga, .status-ferias { color: #ef4444; font-weight: bold; font-style: italic; }
        .status-ferias { color: #3b82f6; }
        .status-folga { color: #6b7280; }

        /* Rodapé */
        .footer-section { margin-top: 15px; display: table; width: 100%; border-spacing: 8px; }
        .footer-row { display: table-row; }
        .footer-box { display: table-cell; width: 50%; background-color: #f3f4f6; border: 1px solid #e5e7eb; border-radius: 8px; padding: 10px; font-size: 8pt; vertical-align: top; }
        .footer-box h3 { font-size: 10pt; margin-top: 0; margin-bottom: 8px; }
        .footer-box td { padding: 2px 0; }
        .footer-box .total { font-weight: bold; border-top: 1px solid #d1d5db; padding-top: 4px; margin-top: 4px; }
        
        /* Assinaturas */
        .signatures { margin-top: 25px; font-size: 8pt; page-break-inside: avoid !important; }
        .signatures td { width: 50%; padding: 0 20px; text-align: center; }
        .signatures .line { border-top: 1px solid #6b7280; padding-top: 4px; margin-top: 30px; }

    </style>
</head>
<body>
    <div class="a4-sheet">
        <header>
            <h1>Espelho de Ponto - {{ \Carbon\Carbon::createFromFormat('Y-m', $dados['mes_ano'])->locale('pt_BR')->isoFormat('MMMM [de] YYYY') }}</h1>
        </header>

        <div class="info-section">
            <div class="info-section-row">
                <div class="info-card">
                    <table><tr>
                        <td><i class="ri-user-line icon-sm"></i></td>
                        <td>
                            <span class="label">Funcionário</span>
                            <span class="value">{{ $dados['usuario']->nome }}</span>
                        </td>
                    </tr></table>
                </div>
                <div class="info-card">
                    <table><tr>
                        <td><i class="ri-building-line icon-sm"></i></td>
                        <td>
                            <span class="label">Empresa / Cargo</span>
                            <span class="value">{{ $dados['usuario']->empresa->nome ?? 'N/A' }} / {{ $dados['usuario']->cargo }}</span>
                        </td>
                    </tr></table>
                </div>
                <div class="info-card">
                    <table><tr>
                        <td><i class="ri-file-text-line icon-sm"></i></td>
                        <td>
                            <span class="label">Matrícula / Admissão</span>
                            <span class="value">{{ $dados['usuario']->id }} / {{ $dados['usuario']->data_admissao ? \Carbon\Carbon::parse($dados['usuario']->data_admissao)->format('d/m/Y') : 'N/A' }}</span>
                        </td>
                    </tr></table>
                </div>
                <div class="info-card">
                    <table><tr>
                        <td><i class="ri-time-line icon-sm"></i></td>
                        <td>
                            <span class="label">Horário Previsto</span>
                            <span class="value">Seg-Sex: 08:00 - 14:00</span>
                        </td>
                    </tr></table>
                </div>
            </div>
        </div>

        <div class="summary-section">
            <div class="summary-section-row">
                <div class="summary-card">
                    <table><tr>
                        <td><div class="label">Horas Trabalhadas</div><div class="value">{{ $dados['totais']['horasTrabalhadas'] }}</div></td>
                        <td><i class="ri-time-line icon"></i></td>
                    </tr></table>
                </div>
                <div class="summary-card">
                     <table><tr>
                        <td><div class="label">Total Previsto</div><div class="value">{{ $dados['totais']['horasPrevistas'] }}</div></td>
                        <td><i class="ri-briefcase-line icon"></i></td>
                    </tr></table>
                </div>
                <div class="summary-card">
                     <table><tr>
                        <td><div class="label">Horas Extras</div><div class="value">{{ $dados['totais']['horasExtras'] }}</div></td>
                        <td><i class="ri-flashlight-line icon"></i></td>
                    </tr></table>
                </div>
                <div class="summary-card">
                     <table><tr>
                        <td><div class="label">Dias de Falta</div><div class="value">{{ $dados['totais']['diasFalta'] }}</div></td>
                        <td><i class="ri-calendar-close-line icon"></i></td>
                    </tr></table>
                </div>
            </div>
        </div>
        
        <h3>Detalhes Diários</h3>
        <table class="details-table">
            <thead>
                <tr>
                    <th style="width: 15%;" class="col-dia">Dia</th>
                    <th style="width: 25%;" class="col-pontos">Pontos</th>
                    <th>H. Trab.</th>
                    <th>H. Extra</th>
                    <th>Faltas</th>
                    <th style="width: 20%;">Anotações</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($dados['dias'] as $dia)
                <tr>
                    <td class="col-dia">{{ $dia['data'] }} {{ $dia['dia_semana'] }}</td>
                    <td class="col-pontos">
                        @foreach($dia['pontos'] as $ponto)
                            <span style="font-family: monospace;">{{ $ponto->data_hora->format('H:i') }}</span>
                        @endforeach
                    </td>
                    <td>{{ formatarMinutos($dia['trabalhado']) }}</td>
                    <td>{{ formatarMinutos($dia['extra']) }}</td>
                    <td>{{ formatarMinutos($dia['falta']) }}</td>
                    <td>
                        @if ($dia['status'])
                            <span class="status-{{ strtolower($dia['status']) }}">{{ $dia['status'] }}</span>
                        @else
                            --
                        @endif
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>

        <div class="footer-section">
            <div class="footer-row">
                <div class="footer-box">
                    <h3>Resumo e Totais</h3>
                    <table>
                        <tr><td>Dias Completos de Falta:</td><td align="right">{{ $dados['totais']['diasFalta'] }}</td></tr>
                        <tr class="total"><td>Total Trabalhado:</td><td align="right">{{ $dados['totais']['horasTrabalhadas'] }}</td></tr>
                    </table>
                </div>
                <div class="footer-box">
                    <h3>Horas Extras</h3>
                    <table>
                        <tr><td>Extras a 50%:</td><td align="right">{{ $dados['resumo_extras']['he_50'] }}</td></tr>
                        <tr><td>Extras a 100%:</td><td align="right">{{ $dados['resumo_extras']['he_100'] }}</td></tr>
                        <tr class="total"><td>Total de Horas Extras:</td><td align="right">{{ $dados['totais']['horasExtras'] }}</td></tr>
                    </table>
                </div>
            </div>
        </div>

        <table class="signatures">
            <tr>
                <td><div class="line">{{ $dados['usuario']->nome }}</div></td>
                <td><div class="line">Assinatura do Responsável</div></td>
            </tr>
        </table>
    </div>
</body>
</html>