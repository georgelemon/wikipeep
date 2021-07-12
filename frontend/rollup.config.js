import resolve from '@rollup/plugin-node-resolve';
import commonjs from '@rollup/plugin-commonjs';
import { terser } from 'rollup-plugin-terser';

export default {
    input: 'src/app.js',
    output: {
        name: 'Wikipeep',
        file: `../public/assets/app.min.js`,
        format: 'iife',                         // "amd", "cjs", "system", "es", "iife" or "umd"
        sourcemap: true
    },
    plugins: [
        resolve(),
        commonjs({
            transformMixedEsModules: true,
        }),
        // terser({
        //     format: {
        //       comments: false
        //     },
        // }),
    ]
};