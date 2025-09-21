<!DOCTYPE html>
<html lang="pt-BR" class="h-full bg-gray-100">
<head>
    <meta charset="UTF-8">
    <title>Ponto Eletrônico - QR Code</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/qrious/4.0.2/qrious.min.js"></script>

    <style>
        @keyframes pulse-border {
            0% { border-color: #e5e7eb; }
            50% { border-color: #60a5fa; } /* Cor azul sutil */
            100% { border-color: #e5e7eb; }
        }
        .animate-pulse-border {
            animation: pulse-border 1.5s ease-in-out infinite;
        }
    </style>
</head>

<body class="flex items-center justify-center h-screen p-4">

    <main class="bg-white shadow-2xl rounded-2xl p-6 sm:p-10 w-full max-w-md text-center flex flex-col items-center">
        <section class="bg-gradient-to-br from-blue-500 to-purple-600 text-white rounded-xl py-3 px-6 shadow-lg mb-8 w-full">
            <p id="currentDate" class="text-sm font-light opacity-80">{{ now()->translatedFormat('D, d \d\e M \d\e Y') }}</p>
            <p id="currentTime" class="text-3xl font-bold mt-1">{{ now()->format('H:i:s') }}</p>
        </section>

        <h1 class="text-lg text-blue-500 font-semibold mb-6">Ponto Empresa</h1>

        <canvas id="qrcode" class="w-64 h-64 border-8 rounded-lg shadow-xl animate-pulse-border"></canvas>

        <p class="text-sm text-gray-400 mt-6">
            Token: <span class="font-mono text-gray-700 font-bold text-lg">
                {{ $token ?? 'SEM TOKEN DISPONÍVEL' }}
            </span>
        </p>
    </main>

    <script>
        // 1. Relógio Dinâmico
        const updateClock = () => {
            const now = new Date();
            const timeString = now.toLocaleTimeString('pt-BR', { hour12: false });
            document.getElementById('currentTime').textContent = timeString;
        };
        setInterval(updateClock, 1000); // Atualiza a cada 1 segundo

        // 2. QR Code Dinâmico
        @if($token)
            new QRious({
                element: document.getElementById("qrcode"),
                value: "{{ $token }}",
                size: 256,
                level: "H"
            });
        @endif

        // 3. Recarrega a página para novo QR Code a cada 15 segundos
        setInterval(() => {
            window.location.reload();
        }, 15000); // 15000 milissegundos = 15 segundos
    </script>
</body>
</html>