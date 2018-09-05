
var gulp = require('gulp');
var util = require('gulp-util');
var sass = require('gulp-sass');
var concat = require('gulp-concat');
var sourcemaps = require('gulp-sourcemaps');
var livereload = require('gulp-livereload');

gulp.task('sass', function () {
	return gulp.src('./web/sass/*.scss')
		.pipe(sourcemaps.init())
		.pipe(sass({errLogToConsole: true}).on('error', function (error) {
			util.log(util.colors.red(error.messageFormatted));
        }))
		.pipe(sourcemaps.write())
		.pipe(gulp.dest('./web/css'))
		.pipe(livereload());
;
	return gulp.src('./web/js/**/*.js')
		.pipe(sourcemaps.init())
		.pipe(concat('main.js'))
		//only uglify if gulp is ran with '--type production'
		//.pipe(gutil.env.type === 'production' ? uglify() : gutil.noop()) 
		.pipe(sourcemaps.write())
		.pipe(gulp.dest('./web/js'))
		.pipe(livereload());
});

gulp.task('watch', function () {
	livereload.listen();
	
	gulp.watch('./web/sass/**/*.scss', ['sass']);
	gulp.watch('./web/js/**/*.js', ['scripts']);
});

