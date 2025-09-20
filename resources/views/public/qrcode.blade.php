<!DOCTYPE html>
<html lang="pt-BR" class="h-full bg-gray-100">
<head>
    <meta charset="UTF-8">
    <title>Ponto Eletrônico - QR Code</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/qrious/4.0.2/qrious.min.js"></script>
</head>

<body class="flex items-center justify-center h-screen p-4">

    <main class="bg-white shadow-2xl rounded-2xl p-6 sm:p-10 w-full max-w-md text-center flex flex-col items-center">
        <!-- Data e Hora -->
        <section class="bg-gradient-to-br from-blue-500 to-purple-600 text-white rounded-xl py-3 px-6 shadow-lg mb-8 w-full">
            <p class="text-sm font-light opacity-80">{{ now()->translatedFormat('D, d \d\e M \d\e Y') }}</p>
            <p class="text-3xl font-bold mt-1">{{ now()->format('H:i:s') }}</p>
        </section>

        <!-- Nome/Logo -->
        <h1 class="text-lg text-blue-500 font-semibold mb-6">Ponto Empresa</h1>

        <!-- QR Code Dinâmico -->
        <canvas id="qrcode" class="w-64 h-64 border-8 border-gray-200 rounded-lg shadow-xl"></canvas>

        <!-- Token visível -->
        <p class="text-sm text-gray-400 mt-6">
            Token: <span class="font-mono text-gray-700 font-bold text-lg">
                {{ $token ?? 'SEM TOKEN DISPONÍVEL' }}
            </span>
        </p>
    </main>

    <script>
        @if($token)
        new QRious({
            element: document.getElementById("qrcode"),
            value: "{{ $token }}",
            size: 256,
            level: "H"
        });
        @endif
    </script>
</body>
</html>
