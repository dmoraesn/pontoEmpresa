import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import tailwindcss from '@tailwindcss/vite';
import fs from 'fs';

export default defineConfig({
    server: {
        https: {
            key: fs.readFileSync('certs/laravel.key'),
            cert: fs.readFileSync('certs/laravel.crt'),
        },
        host: '0.0.0.0',  // deixa visível na rede local
        port: 5173,       // porta padrão do Vite
    },
    plugins: [
        laravel({
            input: ['resources/css/app.css', 'resources/js/app.js'],
            refresh: true,
        }),
        tailwindcss(),
    ],
});
