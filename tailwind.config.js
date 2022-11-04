/** @type {import('tailwindcss').Config} */
module.exports = {
  content: [
    "./Views/home.html.twig",
    "./Views/*",
    "./Views/rastreio.php"
  ],
  theme: {
    "container" : {
      "center" : true
    },
    extend: {},
  },
  plugins: [],
}
