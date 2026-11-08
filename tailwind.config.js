/** @type {import('tailwindcss').Config} */
module.exports = {
  darkMode: 'class',
  content: [
    './*.php',
    './template-parts/**/*.php',
    './templates/**/*.php',
    './inc/**/*.php',
    './assets/js/**/*.js',
  ],
  theme: {
    extend: {
      colors: {
        primary: {
          DEFAULT: 'rgb(var(--primary-rgb, 99 102 241) / <alpha-value>)',
          hover: 'var(--primary-hover, #4f46e5)',
          light: 'var(--primary-light, #e0e7ff)',
        },
      },
    },
  },
  plugins: [],
};

