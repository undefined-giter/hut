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
                mirza: ['Mirza', ...defaultTheme.fontFamily.sans],
                oleo: ['OleoScript', ...defaultTheme.fontFamily.sans],
                muktaRegular: ['MuktaMahee Regular', ...defaultTheme.fontFamily.sans],
                muktaExtraBold: ['MuktaMahee ExtraBold', ...defaultTheme.fontFamily.sans],
              },
            colors: {
                light: 'rgba(203, 189, 170, 0.8)',
                dark: 'rgba(12, 24, 12, 0.8)',
                orangeTheme : '#EA580C',
                inputsLight : 'rgba(191, 191, 191, 0.8)',
                inputsDark : 'rgba(13, 37, 13, 0.8)',
            },
            screens: {
                'xs': '480px',
                '2xs': '320px',
            },
        },
    },

    plugins: [forms],
};
