// View your website at your own local server
// for example http://vite-php-setup.test

// http://localhost:3000 is serving Vite on development
// but accessing it directly will be empty

// IMPORTANT image urls in CSS works fine
// BUT you need to create a symlink on dev server to map this folder during dev:
// ln -s {path_to_vite}/src/assets {path_to_public_html}/assets
// on production everything will work just fine

import { defineConfig } from 'vite';
import liveReload from 'vite-plugin-live-reload';
import { resolve } from 'path';
import fs from 'fs';


// https://vitejs.dev/config
export default defineConfig({

    plugins: [
        liveReload(__dirname +'/src/templates/**/*.php')
    ],

    // config
    root: process.env.NODE_ENV === '',
    base: '/wp-content/themes/my-theme/',
    publicDir: 'src/templates',
    
    css: {
        devSourcemap: true  
    },

    build: {
    // output dir for production build
        outDir: resolve(__dirname, './dist'),
        emptyOutDir: true,

        // emit manifest so PHP can find the hashed files
        manifest: true,

        // esbuild target
        target: 'es2018',

        // our entry
        rollupOptions: {
            input: {
                main: resolve( __dirname + '/src/ts/index.ts'),
                admin: resolve(__dirname + '/src/ts/admin.ts')
            },

            // output: {
            //     entryFileNames: `app.[name].js`,
            //     chunkFileNames: `vendor.[name].js`,
            //     assetFileNames: `[name].[ext]`
            // }
        },

        // minifying switch
        minify: process.env.NODE_ENV === 'production',
        write: true
    },

    server: {

        // required to load scripts from custom host
        cors: true,

        // we need a strict port to match on PHP side
        // change freely, but update in your functions.php to match the same port
        strictPort: true,
        port: 3000,

        // serve over http
        https: false,

        hmr: {
            host: 'localhost',
        },
    
    },

    // required for in-browser template compilation
    // https://v3.vuejs.org/guide/installation.html#with-a-bundler
    resolve: {
        alias: {
            '@/': `${__dirname}/src/`
        }
    }
});