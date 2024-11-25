import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';
const defaultTheme = require('tailwindcss/defaultTheme')
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
                sans: ['Inter var', ...defaultTheme.fontFamily.sans],
            },
        },
    },

    plugins: [forms],
};
/** @type {import('tailwindcss').Config} */
module.exports = {
    content: [
      "./resources/**/*.blade.php",
      "./resources/**/*.js",
      "./resources/**/*.vue",
      "./node_modules/tw-elements/js/**/*.js",
      "./node_modules/flowbite/**/*.js",
      'node_modules/preline/dist/*.js',
    ],
    theme: {
      extend: {},
    },
    darkMode: "class",
    plugins: [
      require('tw-elements/plugin.cjs'),
      require('preline/plugin'),

    ],
  }

