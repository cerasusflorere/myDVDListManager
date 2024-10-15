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
                // manualChunks: {
                    // vue: ['vue']
                // },
                manualChunks(id) {
                    if(id.includes("vue")) {
                        if(id.includes("node_modules")) {
                            return "vue-vendor";
                        }
                        if(id.includes("js")) {
                            return "vue-js";
                        } 
                    }
                    if(id.includes("node_modules")) {
                        // return id.toString().split('node_modules/')[1].split('/')[0].toString();
                        return "vendor";
                    }
                }
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
        })
    ],
    resolve: {
        alias: {
            vue: 'vue/dist/vue.esm-bundler.js',
        },
    },
});
