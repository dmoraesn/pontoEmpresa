<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Registro de Presença</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        body { font-family: sans-serif; text-align: center; padding: 20px; background: #f9f9f9; }
        .clock { font-size: 2rem; margin: 10px 0; }
        .token { font-weight: bold; font-size: 1.5rem; margin: 10px 0; }
        .qr-container {
            display: inline-block;
            padding: 20px;
            border: 5px solid #4f46e5;
            border-radius: 16px;
            animation: pulse 1.5s infinite;
            background: white;
        }

        @keyframes pulse {
            0% { box-shadow: 0 0 0 0 rgba(79,70,229,0.7); }
            70% { box-shadow: 0 0 0 10px rgba(79,70,229,0); }
            100% { box-shadow: 0 0 0 0 rgba(79,70,229,0); }
        }

        .success {
            color: green;
            font-weight: bold;
            animation: fadeIn 1s ease-out;
        }

        @keyframes fadeIn {
            from { opacity: 0; }
            to { opacity: 1; }
        }
    </style>
    <script src="https://cdn.jsdelivr.net/npm/qrcode/build/qrcode.min.js"></script>
</head>
<body>
    <h1>Registro de Presença</h1>

    <div class="clock" id="data"></div>
    <div class="clock" id="hora"></div>

    <div class="qr-container">
        <canvas id="qrcode"></canvas>
    </div>

    <div class="token">Token de acesso: <span id="token">{{ $token }}</span></div>

    <div id="status" class="success"></div>

    <script>
        const updateClock = () => {
            const now = new Date();
            const options = { timeZone: 'America/Sao_Paulo' };
            const data = now.toLocaleDateString('pt-BR', options);
            const hora = now.toLocaleTimeString('pt-BR', options);
            document.getElementById('data').textContent = `Hoje é ${data}`;
            document.getElementById('hora').textContent = `Agora são ${hora}`;
        };

        setInterval(updateClock, 1000);
        updateClock();

        const token = document.getElementById('token').textContent;
        const timestamp = '{{ $timestamp }}';
        const qrData = JSON.stringify({ token, timestamp });

        QRCode.toCanvas(document.getElementById('qrcode'), qrData, {
            width: 200,
        });

        // Simula leitura (em produção, o scanner envia via POST)
        const simulateRead = () => {
            fetch('/leitura/registrar', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({ token, timestamp })
            })
            .then(res => res.json())
            .then(data => {
                document.getElementById('status').textContent = data.message;
            });
        };

        // Atalho: simula leitura ao clicar no QR
        document.getElementById('qrcode').addEventListener('click', simulateRead);

        // Atualiza QR a cada 10s (recarrega página)
        setTimeout(() => location.reload(), 10000);
    </script>
</body>
</html>
