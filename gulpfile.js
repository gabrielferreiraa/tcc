const gulp         = require('gulp');
const gutil        = require('gulp-util');
const uglify       = require('gulp-uglify');
const watch        = require('gulp-watch');
const imagemin     = require('gulp-imagemin');
const changed      = require('gulp-changed');
const sass         = require('gulp-sass');
const cleanCss     = require('gulp-clean-css');
const autoprefixer = require('gulp-autoprefixer');
const prompt       = require('gulp-prompt');
const run          = require('gulp-run');

gulp.task('doc', function(){
    return run('jsdoc src/js').exec().pipe(gulp.dest('./doc'));
});

gulp.task('min:js', function(){
    return gulp
        .src(['src/js/**/*.js'])
        .pipe(uglify())
        .pipe(gulp.dest('build/js'));
});

gulp.task('watch:min:js', function(){
    gulp.watch('src/js/**/*.js', function(event){
        gutil.log('File ' + event.path + ' was ' + event.type + ', running tasks...');
        gulp.run('min:js');
    });
});


gulp.task('min:css', function(){
    return gulp
        .src(['./webroot/front/css/*.css'])
        .pipe(autoprefixer())
        .pipe(cleanCss({compatibility: 'ie8'}))
        .pipe(gulp.dest('./webroot/front/css'));
});

gulp.task('sass', function(){
    return gulp
        .src('./webroot/front/scss/**/*.scss')
        .pipe(sass().on('error', sass.logError))
        .pipe(autoprefixer())
        .pipe(cleanCss({compatibility: 'ie8'}))
        .pipe(gulp.dest('./webroot/front/css'));
});

gulp.task('watch:sass', ['sass'], function(){
    gulp.watch('./webroot/front/scss/**/*.scss', ['sass']);
});

gulp.task('min:jpg', function(){
    return gulp
        .src('src/img/**/*.jpg')
        .pipe(changed('build/img/'))
        .pipe(imagemin({
            progressive: true
        }))
        .pipe(gulp.dest('build/img/'));
});

gulp.task('min:png', function(){
    return gulp
        .src('src/img/**/*.png')
        .pipe(changed('build/img/'))
        .pipe(imagemin({
            progressive: true
        }))
        .pipe(gulp.dest('build/img/'));
});
