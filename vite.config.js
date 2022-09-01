import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

import 'dotenv/config'

import path from 'node:path'
import fs from 'node:fs'

const server = (() => {
    const assetUrl = process.env.VITE_URL || null
    if (assetUrl === null) {
        return {}
    }

    const server = {}
    const parsedUrl = new URL(assetUrl)
    if (parsedUrl.protocol === 'https:' && process.env.VITE_HTTPS_CERT && process.env.VITE_HTTPS_KEY) {
        server.https = {
            cert: fs.readFileSync(process.env.VITE_HTTPS_CERT),
            key: fs.readFileSync(process.env.VITE_HTTPS_KEY),
        }
    } else {
        server.https = parsedUrl.protocol === 'https:'
    }
    server.port = parsedUrl.port || (server.https ? 443 : 80)
    server.host = parsedUrl.hostname

    return server
})()

export default defineConfig({
    server,
    resolve: {
        alias: {
            '@': path.resolve(__dirname, 'resources')
        },
    },
    plugins: [
        laravel([
            'resources/css/app.css',
            'resources/js/app.js',
        ]),
    ],
});
