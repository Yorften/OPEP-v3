/** @type {import('tailwindcss').Config} */
module.exports = {
  content: [
    "./index.php",
    "src/components/*.html",
    "src/components/*.php",
    "src/includes/*.php",
    "src/pages/*.php",
    "src/pages/details/*.php",
  ],
  theme: {
    extend: {
      boxShadow: {
        "3xl": "0 35px 60px -15px rgba(0, 0, 0, 0.3)",
      },
    },
  },
  plugins: [
    function ({ addVariant }) {
      addVariant("child", "& > *");
    },
  ],
};
