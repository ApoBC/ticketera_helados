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
                sans: ['Host Grotesk', ...defaultTheme.fontFamily.sans],
            },
            colors: {
                ink: '#0C0D0D',
                mint: '#ECF4EE',
                offwhite: '#FAFAFA',
            },
        },
    },

    plugins: [forms],
};
