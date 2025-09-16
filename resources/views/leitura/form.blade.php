<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>QR Code de Registro</title>
</head>
<body>
    <h2>Escaneie este QR para registrar entrada</h2>

    <img src="https://api.qrserver.com/v1/create-qr-code/?data={{ urlencode(route('leitura.form')) }}&size=200x200" alt="QR Code">
</body>
</html>
