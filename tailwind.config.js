/** @type {import('tailwindcss').Config} */
export default {
  content: [
    "./resources/views/**/*.blade.php",
    "./resources/js/**/*.js",
    "./vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php"
  ],
  theme: {
    extend: {
      colors: {
        pet: {
          beige: '#FFF4E0',
          crema: '#EFE3D6',
          acento: '#6A0DAD',        // nuevo
          acentoOscuro: '#3F0066',  // nuevo
          marron: '#8D6E63',
          fondoTarjeta: '#FFFDF8',
        },
      }


    },
  },
  plugins: [],
}

