/** @type {import('tailwindcss').Config} */
export default {
  content: [
    "./resources/**/*.blade.php",
    "./resources/**/*.js",
  "./resources/**/*.vue",

  ],
  theme: {
    extend: {
      screens: {
        'xs': '475px',
        'sm': '640px',
        'md': '768px',
        'lg': '1024px',
        'xl': '1280px',
        '2xl': '1536px',
        // HAPUS 3xl dan lainnya
      },
      colors: {
        'primary': '#F6E7E1',
        'secondary': '#E8D8C4',
        'accent': '#CFA5A5',
        'text': '#2F2F2F',
        'muted': '#8A8A8A',
        'bg': '#FAFAFA',
      },
      fontFamily: {
        'heading': ['Playfair Display', 'serif'],
        'body': ['Inter', 'sans-serif'],
      },
      transitionDuration: {
        '150': '150ms',
        '200': '200ms',
        '250': '250ms',
        '300': '300ms',
      },
    },
  },
  plugins: [],
}

