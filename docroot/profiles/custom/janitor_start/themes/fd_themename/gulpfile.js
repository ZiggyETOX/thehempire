var gulp          = require('gulp');
var browserSync   = require('browser-sync').create();
var $             = require('gulp-load-plugins')();
var autoprefixer  = require('autoprefixer');
var sourcemaps    = require('gulp-sourcemaps');

var sassPaths = [
  'node_modules/foundation-sites/scss',
  'node_modules/motion-ui/src'
];

function sass() {
  return gulp.src('scss/app.scss')
    .pipe(sourcemaps.init())
    .pipe($.sass({
      includePaths: sassPaths,
      outputStyle: 'compressed' // if css compressed **file size**
    })
      .on('error', $.sass.logError))
    .pipe($.postcss([
      autoprefixer({ browsers: ['last 2 versions', 'ie >= 9'] })
    ]))
    .pipe(sourcemaps.write())
    .pipe(gulp.dest('css'))
    .pipe(browserSync.stream());
};

function serve() {
  browserSync.init({
    files: [
      'css/**/*.css',
      'templates/**/*.twig',
      '*.theme'
    ],
    proxy: "http://127.0.0.1:8080"
  });

  gulp.watch("scss/*/*.scss", sass);
  gulp.watch("scss/*.scss", sass);
  gulp.watch("*.html").on('change', browserSync.reload);
}

// update foundation dependencies js (needs to be listed here)
var jsPaths = [
  'node_modules/foundation-sites/dist/js/plugins/foundation.core.min.js',
  'node_modules/foundation-sites/dist/js/plugins/foundation.accordion.min.js',
  'node_modules/foundation-sites/dist/js/plugins/foundation.util.keyboard.min.js'
];
gulp.task('copyjs', function () {
  return gulp.src(jsPaths).pipe(gulp.dest('js'));
});

gulp.task('sass', sass);
gulp.task('serve', gulp.series('sass', serve));
gulp.task('default', gulp.series('sass', serve));
