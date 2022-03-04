'use strict';

const gulp = require('gulp');
const sass = require('gulp-sass')(require('sass'));
const concat = require('gulp-concat');
const cleanCSS = require('gulp-clean-css');
const sourcemaps = require('gulp-sourcemaps');
const rename = require('gulp-rename');
const { src, series, parallel, dest, watch } = require('gulp');

// Sass task: compiles the style.scss file into style.css
function style() {
    return gulp.src('./scss/style.scss')
        //return gulp.src(StylePath)
        //.pipe(sourcemaps.init()) // initialize sourcemaps first
        .pipe(sass().on('error', sass.logError)) // compile SCSS to CSS
        .pipe(sourcemaps.init())
        .pipe(cleanCSS())
        .pipe(sourcemaps.write())
        .pipe(rename('style.min.css'))
        .pipe(concat('style.min.css'))
        //.pipe(sourcemaps.write('../user-maps')) // write sourcemaps file in current directory
        .pipe(gulp.dest('./css/')) // put final CSS in dist folder
}

// Watch task: watch SCSS and JS files for changes
// If any change, run scss and js tasks simultaneously
function watchTask() {
    gulp.watch('./scss/**/*.scss', style);
}

// Export the default Gulp task so it can be run
// Runs the scss and js tasks simultaneously
// then runs cacheBust, then watch task
exports.style = style;

exports.default = watchTask;