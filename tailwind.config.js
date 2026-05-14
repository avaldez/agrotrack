/** @type {import('tailwindcss').Config} */
export default {
    content: [
        "./resources/**/*.blade.php",
        "./resources/**/*.js",
        "./app/Http/Livewire/**/*.php",
    ],
    theme: {
        extend: {
            colors: {
                agro: {
                    50: '#E1F5EE',
                    100: '#C3EBDE',
                    200: '#A8E0CC',
                    300: '#6FCDA8',
                    400: '#3DB882',
                    500: '#1D9E75',
                    600: '#0F6E56',
                    700: '#085041',
                    800: '#063A2F',
                    900: '#04281F',
                },
            },
            fontSize: {
                '2xs': '0.65rem',
            },
        },
    },
    plugins: [
        require('@tailwindcss/forms'),
    ],
};
