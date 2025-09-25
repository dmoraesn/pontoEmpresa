@echo off
title Laravel HTTPS Server

REM Caminho do PHP do XAMPP
set PHP_PATH=C:\xampp\php\php.exe

REM Caminho do projeto Laravel
set PROJECT_PATH=C:\xampp\htdocs\ponto_empresa

REM Caminho dos certificados
set CERT_PATH=%PROJECT_PATH%\certs

echo ===========================================
echo Iniciando Laravel com HTTPS...
echo ===========================================

cd %PROJECT_PATH%
%PHP_PATH% -S 0.0.0.0:8000 -t public -d "openssl.cafile=%CERT_PATH%\laravel.crt" -d "openssl.local_cert=%CERT_PATH%\laravel.crt" -d "openssl.local_pk=%CERT_PATH%\laravel.key"

pause
