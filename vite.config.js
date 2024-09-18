import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import vue from '@vitejs/plugin-vue';

// chunk分割のため
import { visualizer } from 'rollup-plugin-visualizer'

export default defineConfig({
    // chunk分割のため、buildをセット
    build: {
        rollupOptions: {
            output: {
                manualChunks: {
                    vue: ['vue']
                },
            },
            plugins: [visualizer()],
        },
    },
    plugins: [
        laravel({
            input: [
                'resources/sass/app.scss',
                'resources/js/app.js',
            ],
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
    resolve: {
        alias: {
            vue: 'vue/dist/vue.esm-bundler.js',
        },
    },
});
