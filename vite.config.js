import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/css/app.css',
                'resources/css/dartcars.css',
                'resources/css/assets/vendor/nucleo/css/nucleo.css',
                'resources/css/assets/vendor/@fortawesome/fontawesome-free/css/all.min.css',
                'resources/js/app.js'
            ],
            refresh: true,
        }),
    ],
});
