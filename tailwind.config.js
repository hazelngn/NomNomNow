/** @type {import('tailwindcss').Config} */
module.exports = {
  content: ["./app/Views/**/*.php"],
  daisyui: {
    themes: ["light", "dracula", "retro", "night", "sunset"],
  },
  theme: {
    extend: {
      fontFamily: {
        header: ['Rubik Bubbles', 'Lilita One','sans-serif'],
        'sub-header': ['Lilita One','sans-serif'],
        body: ['Josefin Sans', 'Lilita One','sans-serif'],
      },
    },
  },
  plugins: [],
}

