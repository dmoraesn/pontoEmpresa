{{-- resources/views/leitura/scan.blade.php --}}
@extends('layouts.public')

@section('content')
<div class="text-center">
    <h2 class="text-2xl font-bold mb-4">Escaneie o QR Code para registrar sua presença</h2>

    <div id="reader" style="width: 300px; margin: 0 auto;"></div>

    <p class="mt-4 text-green-600 font-semibold" id="resultado"></p>
</div>

<script src="https://unpkg.com/html5-qrcode" type="text/javascript"></script>
<script>
    function registrarMarcacao(token) {
        fetch('/leitura/registrar', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({ token: token })
        })
        .then(response => response.json())
        .then(data => {
            alert('Registrado com sucesso!');
        })
        .catch(error => {
            alert('Erro ao registrar ponto.');
            console.error(error);
        });
    }

    // Simulação: substitua isso pelo leitor QR real
    const tokenLido = 'abcdef123456';
    registrarMarcacao(tokenLido);
</script>

@endsection
