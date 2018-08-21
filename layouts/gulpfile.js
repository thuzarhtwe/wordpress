'use strict';
/*------------------------------------------------------------------------------
 * 1. DEPENDENCIES
------------------------------------------------------------------------------*/
var gulp        = require('gulp'), // gulp
    $           = require('gulp-load-plugins')({ pattern: ['gulp-*', 'gulp.*'] }), // load plugins
    runSequence = require('run-sequence'), // run order
    rimraf      = require('rimraf'), // delete files/folder directly
    browserSync = require('browser-sync'), // for browser syncronization
    reload      = browserSync.reload // reload
;

/*------------------------------------------------------------------------------
 * 2. FILE DESTINATIONS (RELATIVE TO ASSSETS FOLDER)
------------------------------------------------------------------------------*/
// Declare configuration
var conf = {
	src   :	"./src",
	dist  :	"./assets",
	url   :	"localhost:8888",
	imgExt: "png,jpg,jpeg,gif,svg"
};

// Declare plumberErrorHandler (used for gulp error)
var plumberErrorHandler = {
	errorHandler: $.notify.onError({
		title: 'Gulp',
		message: 'Error: <%= error.message %>'
	})
};

/*------------------------------------------------------------------------------
 * 3. Gulp Tasks
------------------------------------------------------------------------------*/
gulp.task('default', ['build', 'watch', 'browser-sync']);

gulp.task('clean', function(cb) {
	rimraf(conf.dist, cb);
});

gulp.task('build', ['clean'], function(cb) {
	runSequence(['js', 'sass', 'css', 'php'], cb);
});

gulp.task('browser-sync', function () {
	browserSync({
		proxy: conf.url
	});
});

gulp.task('watch', function() {
	gulp.watch(conf.src + '/scss/**/*.scss', ['sass']);
	gulp.watch(['./inc/slider/css/*.css', './layouts/*.css'], ['css']);
	gulp.watch([conf.src + '/js/*.js', './js/*.js'], ['js']);
	gulp.watch(['./*.php', './template-parts/*.php', './inc/**/*.php'], ['php']);
});

gulp.task('php', function() {
	gulp.src(['./*.php', './template-parts/*.php', './inc/**/*.php'])
		.pipe($.plumber(plumberErrorHandler))
		.pipe(reload({ stream: true }));
	}
);

gulp.task('sass', function () {
	gulp.src(conf.src + '/scss/*.scss')
		.pipe($.plumber(plumberErrorHandler))
		.pipe($.sourcemaps.init())
		.pipe($.sass())
		.pipe($.autoprefixer())
		.pipe($.sourcemaps.write())
		.pipe(gulp.dest('./'))
		.pipe(reload({ stream: true }));
});

gulp.task('css', function () {
	gulp.src(['./inc/slider/css/*.css', './layouts/*.css'])
  	.pipe($.plumber(plumberErrorHandler))
  	.pipe(reload({ stream: true }));
});

gulp.task('js', function () {
	gulp.src([conf.src + '/js/*.js'])
  	.pipe($.plumber(plumberErrorHandler))
  	.pipe($.concat('bundle.js'))
  	.pipe($.uglify({ preserveComments: 'license' }))
  	.pipe($.rename({ suffix: '.min' }))
  	.pipe(gulp.dest(conf.dist + '/script/'))
  	.pipe(reload({ stream: true }));
});
