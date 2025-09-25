{{-- resources/views/funcionario/ponto.blade.php (REVISADO) --}}
@extends('layouts.funcionario')

@section('title', 'Bater Ponto')

@section('content')
    {{-- Título --}}
    <h1 class="text-3xl font-extrabold text-indigo-800 mb-6 flex items-center justify-center space-x-2">
        <span class="material-symbols-outlined text-4xl">schedule</span>
        <span>Ponto Rápido</span>
    </h1>

    {{-- Card da Última Marcação (Resumo do Histórico do Dia) --}}
    <div class="bg-indigo-100 p-4 rounded-xl mb-6 shadow-inner border-l-4 border-indigo-500">
        @if ($ultimaMarcacao)
            <p class="text-sm font-medium text-indigo-700 mb-1">Último Registro:</p>
            <p class="text-lg font-bold text-indigo-900">
                {{ $ultimaMarcacao->tipo }}
            </p>
            <p class="text-sm text-gray-600 mt-1">
                <span class="font-mono">{{ \Carbon\Carbon::parse($ultimaMarcacao->data_hora)->format('H:i') }}</span>
                em {{ \Carbon\Carbon::parse($ultimaMarcacao->data_hora)->format('d/m/Y') }}
            </p>
        @else
            <p class="text-gray-600 font-medium">Nenhuma marcação registrada hoje. Comece o dia!</p>
        @endif
    </div>

    <p class="text-gray-600 mb-6 font-medium">Aponte para o QR Code para registrar seu ponto.</p>

    {{-- Leitor de QR (com altura corrigida) --}}
    <div id="qr-reader" class="w-full h-64 rounded-xl overflow-hidden shadow-xl border-4 border-indigo-400"></div>
    <div id="resultado" class="mt-6 p-4 text-center rounded-xl font-semibold transition-all duration-300"></div>

    <div class="mt-8">
        {{-- Botão para a tela de Histórico Completo --}}
        <a href="{{ route('funcionario.historico') }}"
           class="w-full inline-flex items-center justify-center space-x-2 px-6 py-3 text-base font-bold text-white bg-indigo-600 rounded-full hover:bg-indigo-700 transition duration-150 shadow-lg hover:shadow-xl transform hover:-translate-y-0.5">
            <span class="material-symbols-outlined">history</span>
            <span>Ver Histórico Completo</span>
        </a>
    </div>
@endsection

@push('scripts')
<script src="https://unpkg.com/html5-qrcode"></script>
<script>
    // ... (O script JS está como o finalizado anteriormente, garantindo funcionalidade e feedback visual)
    const html5QrCode = new Html5Qrcode("qr-reader");
    const qrCodeSuccessDiv = document.getElementById("resultado");
    const qrCodeConfig = { fps: 10, qrbox: { width: 220, height: 220 } };

    const iniciarScanner = async () => {
        try {
            await html5QrCode.start({ facingMode: "environment" }, qrCodeConfig, onScanSuccess);
            qrCodeSuccessDiv.innerHTML = `<p class="text-indigo-500">Aguardando QR Code...</p>`;
            qrCodeSuccessDiv.className = "mt-6 p-4 text-center rounded-xl font-semibold transition-all duration-300";
        } catch (err) {
            qrCodeSuccessDiv.className = "mt-6 p-4 text-center rounded-xl font-semibold bg-red-100 text-red-700 shadow-md flex items-center justify-center space-x-2";
            qrCodeSuccessDiv.innerHTML = `<span class="material-symbols-outlined">error</span> <p>Erro ao iniciar a câmera: ${err.message}</p>`;
        }
    };

    const onScanSuccess = (decodedText) => {
        html5QrCode.stop().then(() => sendToken(decodedText)).catch(err => {
            console.error("Erro ao parar o scanner:", err);
            sendToken(decodedText);
        });
    };

    const sendToken = (token) => {
        qrCodeSuccessDiv.className = "mt-6 p-4 text-center rounded-xl font-semibold bg-yellow-100 text-yellow-700 shadow-md animate-pulse flex items-center justify-center space-x-2";
        qrCodeSuccessDiv.innerHTML = `<span class="material-symbols-outlined">hourglass_top</span> <p>Registrando ponto...</p>`;

        fetch('{{ route("funcionario.marcar") }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({ token: token })
        })
        .then(res => {
            if (!res.ok) {
                return res.json().then(error => { throw new Error(error.message || `Erro do servidor: ${res.status}`); });
            }
            return res.json();
        })
        .then(data => {
            qrCodeSuccessDiv.className = "mt-6 p-4 text-center rounded-xl font-semibold bg-green-100 text-green-700 shadow-lg flex items-center justify-center space-x-2";
            qrCodeSuccessDiv.innerHTML = `<span class="material-symbols-outlined">check_circle</span> <p>${data.message}</p>`;
            setTimeout(() => { window.location.reload(); }, 2000);
        })
        .catch(error => {
            qrCodeSuccessDiv.className = "mt-6 p-4 text-center rounded-xl font-semibold bg-red-100 text-red-700 shadow-lg flex items-center justify-center space-x-2";
            qrCodeSuccessDiv.innerHTML = `<span class="material-symbols-outlined">error</span> <p>Erro ao registrar: ${error.message}</p>`;
            setTimeout(() => { iniciarScanner(); }, 3000);
        });
    };

    window.onload = iniciarScanner;
</script>
@endpush
