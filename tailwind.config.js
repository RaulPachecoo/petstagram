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
          beige: '#DDD0C8',
          crema: '#EFE3D6',
          acento: '#6A0DAD',        
          acentoOscuro: '#3F0066',  
          marron: '#323232',
          fondoTarjeta: '#F5F0E6', 
        },
      }


    },
  },
  plugins: [],
}

