const THEME_PATH = `wp-content/themes/radhakrishn`;
let mix = require('laravel-mix');
let path = require('path');
//console.log(path);

mix
  .js(`${THEME_PATH}/src/js/app.js`, `js`)
  .sourceMaps()
  .sass(`${THEME_PATH}/src/scss/editor-style.scss`, 'css')
  .sass(`${THEME_PATH}/src/scss/app.scss`, 'css', {
    sassOptions: {
      sourceMaps: true,
    },
  })
  .setPublicPath(`${THEME_PATH}/assets`)
  .options({
    processCssUrls: false,
    postCss: [require('tailwindcss')],
  })
  
  .browserSync({
    files: [
      `./${THEME_PATH}/**/*.php`,
      `./${THEME_PATH}/src/**.*.js`,
      `./${THEME_PATH}/src/**.*.scss`,
    ],
    proxy: 'https://wptest.ddev.site/',
    https: false,
  });

