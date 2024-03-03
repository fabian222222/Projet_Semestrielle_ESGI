/** @type {import('tailwindcss').Config} */
module.exports = {
  content: [
    "./assets/**/*.js",
    "./templates/**/*.html.twig",
  ],
  theme: {
    extend: {
      colors: {
        'red-primary': '#EA3E2B',
        'red-secondary' : '#ff0000',
        'blue-primary': '#21053D',
        'black': '#000',


        'primary': '#f9fafb',
        'secondary': '#f3f4f6',
        'third': '#e5e7eb',
        'four': '#d1d5db',


        'dark-mode-primary': '#1D1D1D',
        'dark-mode-secondary': '#202020',
        'dark-mode-third': '#292929',
        'dark-mode-four': '#363434',
        'dark-mode-five': '#413f3f',
        'dark-light-purple': '#7058DC',
        'dark-dark-purple': '#512d8d',
      }
    },
  },
  plugins: [
    require('@tailwindcss/typography'),
  ],
}