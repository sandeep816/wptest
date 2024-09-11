/** @type {import('tailwindcss').Config} */
const THEME_PATH = `wp-content/themes/radhakrishn`;
module.exports = {
  content: require('fast-glob').sync([
    `${THEME_PATH}/*.php`,
    `${THEME_PATH}/**/*.php`,
    `${THEME_PATH}/src/**/*.js`,
  ]),
  theme: {
    extend: {
      fontFamily: {
        'NotoSans': ["Noto Sans", "serif"],
      },
      colors: {
        primary: '#610802',
        secondary: '#850b00',
        tertiary: '#fff19a',
        tertiarylight: '#fffad7',
      },
      container: {
        center: true,
        padding: {
          DEFAULT: "15px",
        },
      },
    },
  },
  plugins: [],
}