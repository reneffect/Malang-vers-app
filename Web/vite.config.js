import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import { bunny } from 'laravel-vite-plugin/fonts';
import tailwindcss from '@tailwindcss/vite';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/css/guest.css',
                'resources/js/guest.js',
                'resources/css/login/login.css',
                'resources/js/login/login.js',
                'resources/css/login/admin/login.css',
                'resources/js/login/admin/login.js',
                'resources/css/user/member/member-home.css',
                'resources/js/user/member/member-home.js',
            ],
            refresh: true,
            fonts: [
                bunny('Instrument Sans', {
                    weights: [400, 500, 600],
                }),
            ],
        }),
        tailwindcss(),
    ],
    server: {
        watch: {
            ignored: ['**/storage/framework/views/**'],
        },
    },
});
