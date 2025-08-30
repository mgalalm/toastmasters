import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import vue from '@vitejs/plugin-vue';

export default defineConfig({
    // server: {
    //     origin: 'http://toastmasters.dengine.eu',
    //     host: '0.0.0.0',
    //     port: 5173,
    //     hmr: {
    //         host: 'toastmasters.dengine.eu',
    //     },
    //     cors: true, // allows requests from anywhere, or be explicit
    // },
    plugins: [
        laravel({
            input: 'resources/js/app.js',
            refresh: true,
        }),
        vue({
            template: {
                transformAssetUrls: {
                    base: null,
                    includeAbsolute: false,
                },
            },
        }),
    ],
});
