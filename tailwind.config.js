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
        'blue-primary': '#21053D'
      }
    },
  },
  plugins: [
    require('@tailwindcss/typography'),
  ],
}