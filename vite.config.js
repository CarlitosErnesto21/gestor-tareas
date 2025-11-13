import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import vue from '@vitejs/plugin-vue';

export default defineConfig({
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

    build: {
        manifest: true,
        rollupOptions: {
            output: {
                manualChunks: {
                    vendor: ['vue', '@inertiajs/vue3', 'axios']
                }
            }
        }
    },

    // server: {
    //     host: '0.0.0.0',
    //     port: 5173,
    //     cors: true,
    //     hmr: {
    //         host: '192.168.1.5'
    //     }
    // },
});
