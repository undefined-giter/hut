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
                danfo: ['Danfo', ...defaultTheme.fontFamily.sans],
                jacques: ['JacquesFrancoisShadow', ...defaultTheme.fontFamily.sans],
                kalnia: ['KalniaGlaze', ...defaultTheme.fontFamily.sans],
                mirza: ['Mirza', ...defaultTheme.fontFamily.sans],
                oleo: ['OleoScript', ...defaultTheme.fontFamily.sans],
              },
            colors: {
                htmlLightBg: '#ffa448',
                htmlDarkBg: '#141a23',
                light: '#ccc',
                dark: '#131516',
            },
            screens: {
                'xs': '480px',
                '2xs': '320px',
            },
        },
    },

    plugins: [forms],
};
