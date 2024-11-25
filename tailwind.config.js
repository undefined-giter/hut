import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
        './resources/js/**/*.vue',
    ],

    darkMode: 'class',

    theme: {
        extend: {
            fontFamily: {
                kalnia: ['KalniaGlaze', ...defaultTheme.fontFamily.sans],
                mirza: ['Mirza', ...defaultTheme.fontFamily.sans],
                oleo: ['OleoScript', ...defaultTheme.fontFamily.sans],
              },
            colors: {
                light: 'rgba(204, 204, 204, 0.8)',
                dark: 'rgba(20, 20, 20, 0.9)',
                orangeTheme : '#EA580C',
                inputsLight : 'rgba(191, 191, 191, 0.8)',
                inputsDark : 'rgba(17, 24, 39, 0.8)',
            },
            screens: {
                'xs': '480px',
                '2xs': '320px',
            },
        },
    },

    plugins: [forms],
};
