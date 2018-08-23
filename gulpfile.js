'use strict';
/*------------------------------------------------------------------------------
 * 1. DEPENDENCIES
------------------------------------------------------------------------------*/
var gulp = require('gulp'),
  $g = require('gulp-load-plugins')({ pattern: ['gulp-*', 'gulp.*'] }),
  runSequence = require('run-sequence'),
  rimraf = require('rimraf'),
  sourcemaps = require('gulp-sourcemaps')
  ;

/*------------------------------------------------------------------------------
 * 2. FILE DESTINATIONS (RELATIVE TO ASSSETS FOLDER)
------------------------------------------------------------------------------*/
// Declare configuration
var conf = {
  dist_js: "./assets",
  dist_css: "./style.css",
  dist_csscomb: './csscomb.json',
  dist_scss: "./src/scss/**/*.scss",
  dist_watchcss: "['./inc/slider/css/*.css', './layouts/*.css']",
  dist_watchjs: "./src/js/*.js",
  dist_php: "['./*.php', './template-parts/*.php', './inc/**/*.php']"

};

// Declare plumberErrorHandler (used for gulp error)
var plumberErrorHandler = {
  errorHandler: $g.notify.onError({
    title: 'Gulp',
    message: 'Error: <%= error.message %>'
  })
};

/*------------------------------------------------------------------------------
 * 3. Gulp Tasks
------------------------------------------------------------------------------*/
gulp.task('default', ['build', 'watch']);

gulp.task('build', ['clean'], function (cb) {
  runSequence(['js', 'sass', 'css', 'php'], cb);
});

gulp.task('watch', function () {
  gulp.watch(conf.dist_watchjs, ['js']);
  gulp.watch(conf.dist_scss, ['sass']);
  gulp.watch(conf.dist_watchcss, ['css']);
  gulp.watch(conf.dist_php, ['php']);
});

gulp.task('clean', function () {
  rimraf.sync(conf.dist_js);
  rimraf.sync(conf.dist_css);
});

gulp.task('js', function () {
  gulp.src(conf.dist_watchjs)
    .pipe($g.plumber(plumberErrorHandler))
    .pipe($g.concat('bundle.js'))
    .pipe($g.uglify())
    .pipe($g.rename({ suffix: '.min' }))
    .pipe(gulp.dest(conf.dist_js + '/script/'));
});

gulp.task('sass', function () {
  gulp.src(conf.dist_scss)
    .pipe($g.plumber(plumberErrorHandler))
    .pipe($g.sourcemaps.init())
    .pipe($g.sass())
    .pipe($g.autoprefixer())
    .pipe($g.sourcemaps.write())
    .pipe($g.csscomb(conf.dist_csscomb))
    .pipe(gulp.dest('./'));
});

gulp.task('css', function () {
  gulp.src(conf.dist_watchcss)
    .pipe($g.plumber(plumberErrorHandler));
});

gulp.task('php', function () {
  gulp.src(conf.dist_php)
    .pipe($g.plumber(plumberErrorHandler));
});
