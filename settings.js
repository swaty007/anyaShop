const themeLocation = "./wp-content/themes/anya/";
const urlToPreview = "http://127.0.0.1:85/";
const paths = {
  php: {
    watch: themeLocation + "./**/*.php",
  },
  styles: {
    src: themeLocation + "scss/style.scss",
    dist: themeLocation,
    watch: themeLocation + "scss/**/*.scss",
  },
  scripts: {
    // src: [themeLocation + "js/modules/*.js", themeLocation + "js/scripts.js"],
    // dist: themeLocation + "js/",
    watch: [
      themeLocation + "js/modules/**/*.js",
      themeLocation + "js/modules/**/*.vue",
      themeLocation + "js/scripts.js",
    ],
  },
  images: {
    src: [
      themeLocation + "img/**/*.{jpg,jpeg,png,gif,svg}",
      // themeLocation + "!img/svg/*.svg",
      // themeLocation + "!img/favicon.{jpg,jpeg,png,gif}",
    ],
    dist: themeLocation + "img/",
    watch: themeLocation + "img/**/*.{jpg,jpeg,png,gif,svg}",
  },
  sprites: {
    src: themeLocation + "img/svg/*.svg",
    dist: themeLocation + "img/sprites/",
    watch: themeLocation + "img/svg/*.svg",
  },
  favicons: {
    src: themeLocation + "img/favicon.{jpg,jpeg,png,gif}",
    dist: themeLocation + "img/favicons/",
  },
};

export default { paths, themeLocation, urlToPreview };
