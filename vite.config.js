import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import react from '@vitejs/plugin-react';
import tailwindcss from '@tailwindcss/vite';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/css/app.css',
                'resources/js/app.jsx',           // Admin (Inertia + React)
                'resources/js/app-frontend.js'     // Frontend (Alpine.js)
            ],
            refresh: true,
        }),
        react(),
        tailwindcss(),
    ],
    server: {
        host: 'localhost',
        port: 5173,
        https: false,
        hmr: {
            host: 'localhost',
            protocol: 'ws',
        },
    },
});
