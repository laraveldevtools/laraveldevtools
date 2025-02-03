import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import { resolve } from 'path';

export default defineConfig({
    build: {
        manifest: false,
        outDir: resolve(__dirname, 'public/build'),
        rollupOptions: {
            output: {
                entryFileNames: `app.js`,
                chunkFileNames: `[name].js`,
                assetFileNames: ({name}) => {
                    if (/\.css$/.test(name ?? '')) {
                        return 'app.css'
                    }
                    return '[name][extname]'
                }
            }
        }
    },
    plugins: [
        laravel({
            input: [
                'resources/css/app.css',
                'resources/js/app.js',
            ],
            refresh: true,
            publicDirectory: 'public'
        })
    ]
});