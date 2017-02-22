const gulp = require('gulp');
const gutil = require('gulp-util');
const uglify = require('gulp-uglify');
const watch = require('gulp-watch');
const changed = require('gulp-changed');
const sass = require('gulp-sass');
const cleanCss = require('gulp-clean-css');
const autoprefixer = require('gulp-autoprefixer');
const prompt = require('gulp-prompt');
const run = require('gulp-run');
const image = require('gulp-image');

gulp.task('doc', function () {
    return run('jsdoc src/js').exec().pipe(gulp.dest('./doc'));
});

gulp.task('min:js', function () {
    return gulp
        .src(['./webroot/front/js/**/*.js'])
        .pipe(uglify())
        .pipe(gulp.dest('./webroot/front/js-min'));
});

gulp.task('watch:js', function () {
    gulp.watch('./webroot/front/js/**/*.js', function (event) {
        gutil.log('File ' + event.path + ' was ' + event.type + ', running tasks...');
        gulp.run('min:js');
    });
});


gulp.task('min:css', function () {
    return gulp
        .src(['./webroot/front/css/*.css'])
        .pipe(autoprefixer())
        .pipe(cleanCss({compatibility: 'ie8'}))
        .pipe(gulp.dest('./webroot/front/css'));
});

gulp.task('sass', function () {
    return gulp
        .src('./webroot/front/scss/**/*.scss')
        .pipe(sass().on('error', sass.logError))
        .pipe(autoprefixer())
        .pipe(cleanCss({compatibility: 'ie8'}))
        .pipe(gulp.dest('./webroot/front/css'));
});

gulp.task('watch:sass', ['sass'], function () {
    gulp.watch('./webroot/front/scss/**/*.scss', ['sass']);
});

gulp.task('image', function () {
    return gulp.src('./webroot/front/img/*')
        .pipe(image({
            pngquant: true,
            optipng: false,
            zopflipng: true,
            jpegRecompress: false,
            jpegoptim: true,
            mozjpeg: true,
            gifsicle: true,
            svgo: true,
            concurrent: 10
        }))
        .pipe(gulp.dest('./webroot/front/img/'));
});