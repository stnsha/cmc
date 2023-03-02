const defaultTheme = require('tailwindcss/defaultTheme');

/** @type {import('tailwindcss').Config} */
module.exports = {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './vendor/laravel/jetstream/**/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
        './src/**/*.{html,js}',
        './node_modules/tw-elements/dist/js/**/*.js'
    ],

    theme: {
        extend: {
            fontFamily: {
                sans: ['Nunito', ...defaultTheme.fontFamily.sans],
            },
            colors: {
                'primary': '#603C24',
                'secondary': '#3D2A1E',
                'brown-cream': '#8E6743',
                'light-brown': '#B99B6B',
                'medium-gray': '#6C7073',
                'light-gray': '#C0BBB1',
            }
        },
    },

    plugins: [require('@tailwindcss/forms'), require('@tailwindcss/typography'),require('tw-elements/dist/plugin')]
};
