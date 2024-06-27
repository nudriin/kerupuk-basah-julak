/** @type {import('tailwindcss').Config} */
module.exports = {
  content: [
    "./public/**/*.{html,js}",
    "./app/View/header.{html,js,php}",
    "./app/View/admin-header.{html,js,php}",
  ],
  theme: {
    extend: {
      fontFamily: {
        nunito: ['Nunito', 'sans-serif'],
        kanit: ['Kanit', 'sans-serif'],
        bree: ['Bree Serif', 'serif'],
        secularOne: ['Secular One', 'sans-serif'],
        poppins: ['Poppins', 'sans-serif'],
        rubik: ['Rubik', 'sans-serif']
      },
      colors : {
        "biru" : '#032FF2',
        "abu" : '#262433',
        "dark-white" : '#EEEFFF',
        "kuning" : '#FFCE00',
        "merah" : '#DC2323'
      },
      backgroundImage : {
        "hero-bg" : "url('/public/Template/img/bg/Bg-hero.png')"
      }
    },
  },
  plugins: [
    // require("daisyui"),
    // require('@tailwindcss/forms')
  ],
}

