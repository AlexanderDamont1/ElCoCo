import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';

/** @type {import('tailwindcss').Config} */
export default {
    darkMode: 'class',

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

            keyframes: {
                fadeIn: {
                    "0%": { opacity: 0, transform: "translateY(10px)" },
                    "100%": { opacity: 1, transform: "translateY(0)" }
                },

                /* 🌈 Scroll sin pausas (suave, continuo y optimizado con GPU) */
                scroll: {
                    "0%": { transform: "translate3d(0,0,0)" },
                    "100%": { transform: "translate3d(-100%,0,0)" }
                }
            },

            animation: {
                fade: "fadeIn 0.4s ease-out",

                /* 🚀 Animación completamente continua */
                scroll: "scroll 20s linear infinite"
            }
        },
    },

    plugins: [forms],
};
