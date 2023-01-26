import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

import path from 'node:path'

export default defineConfig({
    resolve: {
        alias: {
            '@': path.resolve(__dirname, 'resources')
        },
    },
    plugins: [
        laravel({
            input: [
                'resources/css/app.css',
                'resources/js/app.js',
            ],
            valetTls: process.env.VITE_VALET_TLS || null,
        }),
    ],
});
