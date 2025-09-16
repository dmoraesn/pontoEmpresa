<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Registro de Presença</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    {{-- Tailwind via CDN --}}
    <script src="https://cdn.tailwindcss.com"></script>

    {{-- QRCode.js --}}
    <script src="https://cdnjs.cloudflare.com/ajax/libs/qrcodejs/1.0.0/qrcode.min.js"></script>

    <style>
        .pulse-border {
            border: 4px solid #2563eb;
            border-radius: 1rem;
            padding: 1rem;
            animation: pulse 1.5s infinite;
        }

        @keyframes pulse {
            0% {
                box-shadow: 0 0 0 0 rgba(37, 99, 235, 0.4);
            }
            70% {
                box-shadow: 0 0 0 15px rgba(37, 99, 235, 0);
            }
            100% {
                box-shadow: 0 0 0 0 rgba(37, 99, 235, 0);
            }
        }

        .check-animation {
            animation: checkFade 0.8s ease-in-out;
        }

        @keyframes checkFade {
            0% { opacity: 0; transform: scale(0.9); }
            50% { opacity: 1; transform: scale(1.1); }
            100% { opacity: 0; transform: scale(1.0); }
        }
    </style>
</head>
<body class="bg-gray-100 flex items-center justify-center min-h-screen px-4">

<div class="bg-white shadow-lg rounded-lg p-8 text-center max-w-md w-full">
    <h1 class="text-2xl font-bold text-gray-800 mb-4">Registro de Presença</h1>

    <p id="data" class="text-gray-600 text-sm mb-1"></p>
    <p id="hora" class="text-gray-700 text-lg font-mono mb-4"></p>

    <div id="qrcode" class="pulse-border inline-block"></div>

    <p id="tokenTexto" class="mt-4 font-mono text-blue-700 text-lg tracking-widest"></p>

    <div id="check" class="mt-4 text-green-600 text-5xl hidden">
        ✔️
    </div>
</div>

<script>
    const dataEl = document.getElementById('data');
    const horaEl = document.getElementById('hora');
    const tokenTexto = document.getElementById('tokenTexto');
    const checkEl = document.getElementById('check');

    const qrcode = new QRCode(document.getElementById("qrcode"), {
        text: "carregando...",
        width: 200,
        height: 200,
        correctLevel: QRCode.CorrectLevel.H
    });

    function atualizarDataHora() {
        const agora = new Date();
        const options = { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric' };
        dataEl.innerText = 'Hoje é ' + agora.toLocaleDateString('pt-BR', options);
        horaEl.innerText = 'Agora são ' + agora.toLocaleTimeString('pt-BR');
    }

    function gerarTokenAleatorio() {
        const letras = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
        const numeros = '0123456789';

        const parte1 = letras.charAt(Math.floor(Math.random() * letras.length)) +
                       letras.charAt(Math.floor(Math.random() * letras.length)) +
                       numeros.charAt(Math.floor(Math.random() * numeros.length));

        const parte2 = letras.charAt(Math.floor(Math.random() * letras.length)) +
                       letras.charAt(Math.floor(Math.random() * letras.length)) +
                       numeros.charAt(Math.floor(Math.random() * numeros.length));

        return `${parte1}-${parte2}`;
    }

    function atualizarQR() {
        const novoToken = gerarTokenAleatorio();
        qrcode.clear();
        qrcode.makeCode(novoToken);
        tokenTexto.innerText = "Token de acesso: " + novoToken;

        // Simula "leitura" a cada 3 ciclos (apenas para efeito visual)
        if (Math.random() > 0.66) {
            checkEl.classList.remove('hidden');
            checkEl.classList.add('check-animation');
            setTimeout(() => {
                checkEl.classList.add('hidden');
                checkEl.classList.remove('check-animation');
            }, 800);
        }
    }

    // Iniciar
    atualizarDataHora();
    atualizarQR();

    // Atualizações regulares
    setInterval(atualizarDataHora, 1000);
    setInterval(atualizarQR, 10000);
</script>

</body>
</html>
