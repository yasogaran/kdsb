import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
    ],

    theme: {
        extend: {
            fontFamily: {
                sans: ['Figtree', ...defaultTheme.fontFamily.sans],
            },
            colors: {
                'primary': '#78350f',      // amber-900
                'secondary': '#064e3b',    // emerald-900
                'accent': '#991b1b',       // red-800
                'neutral': '#f1f5f9',      // slate-100
            },
        },
    },

    plugins: [forms],
};
