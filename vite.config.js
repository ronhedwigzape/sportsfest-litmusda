import { fileURLToPath, URL } from 'node:url'
import { defineConfig, loadEnv } from 'vite'
import vue from '@vitejs/plugin-vue'
import vuetify from 'vite-plugin-vuetify'
// https://github.com/vuetifyjs/vuetify-loader/tree/next/packages/vite-plugin


// https://vitejs.dev/config/
export default ({mode}) => {
    const config = {
        plugins: [
            vue(),
            vuetify({
                autoImport: true
            })
        ],
        resolve: {
            alias: {
                '@': fileURLToPath(new URL('./src', import.meta.url))
            }
        },
        base: undefined,
        publicDir: 'assets',
        server: {
            host: 'localhost',
            port: 5177,
            strictPort: true
        },
        build: {
            outDir: 'public'
        }
    };

    process.env = {...process.env, ...loadEnv(mode, process.cwd())};
    const SKIP_BASE_PATH = process.env.VITE_SKIP_BASE_PATH;
    if (SKIP_BASE_PATH === undefined || SKIP_BASE_PATH === 'false')
        config.base = '/fobi/';

    return defineConfig(config);
};