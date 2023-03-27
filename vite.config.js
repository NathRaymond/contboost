import { defineConfig, normalizePath } from 'vite';
import laravel from 'laravel-vite-plugin';
import { viteStaticCopy } from 'vite-plugin-static-copy';
import path from 'node:path'

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/themes/admin/assets/sass/app.scss',
                'resources/themes/admin/assets/js/app.js',
                'resources/themes/neuralink/assets/sass/app.scss',
                'resources/themes/neuralink/assets/js/app.js',
                'resources/themes/neuralink/assets/sass/editor.scss',
                'resources/themes/neuralink/assets/js/editor.js',
                'resources/themes/default/assets/sass/install.scss',
            ],
            refresh: true,
        }),
        viteStaticCopy({
            targets: [
                {
                    src: normalizePath(path.resolve(__dirname, './resources/themes/neuralink/assets/images')),
                    dest: normalizePath(path.resolve(__dirname, './public/themes/neuralink')),
                },
                {
                    src: normalizePath(path.resolve(__dirname, './resources/themes/default/assets/images')),
                    dest: normalizePath(path.resolve(__dirname, './public/themes/default')),
                },
            ]
        })
    ],
});
