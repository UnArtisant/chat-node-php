const colors = require('tailwindcss/colors')

module.exports = {
    mode: 'jit',
    purge: {
        layers: ["components", "utilities"],
        content: [
            './templates/**/*.html.twig'
        ],
    },

    theme: {
        extend: {
            colors: {
                sky: colors.sky,
                teal: colors.teal,
                rose: colors.rose,
            },
        },
    },
    variants: {
        extend: {},
    },
    plugins: [
        require('@tailwindcss/forms'),
    ],
}