'use strict';
const gulp = require('gulp');
const concat = require('gulp-concat');
const browserSync = require('browser-sync').create();
const {watch} = require('gulp');
const rtlcss = require('gulp-rtlcss');
const rename = require("gulp-rename");
const sass = require('gulp-sass');
sass.compiler = require('node-sass');

const compileSass = (cb) => {
    gulp.src('./assets/src/sass/main.scss')
        .pipe(sass().on('error', sass.logError))
        .pipe(gulp.dest('./assets/css'))
        .pipe(browserSync.stream());

    gulp.src('./assets/src/sass/woocommerce.scss')
        .pipe(sass().on('error', sass.logError))
        .pipe(rename("main-woocommerce.css"))
        .pipe(gulp.dest('./assets/css'))
        .pipe(browserSync.stream());

    cb();
};

const buildRtl = (cb) => {
    return gulp.src('./assets/css/main.css')
        .pipe(rtlcss())
        .pipe(rename("style-rtl.css"))
        .pipe(gulp.dest('./'));

    cb();
};

const concatJsFiles = (cb) => {
    return gulp.src(['./node_modules/sticky-js/dist/sticky.min.js'])
        .pipe(concat('vendor.min.js'))
        .pipe(gulp.dest('./assets/js'));

    cb();
};

const concatRtl = (cb) => {
    return gulp.src(['./style-rtl.css', './assets/css/rtl.css'])
        .pipe(concat('style-rtl.css'))
        .pipe(gulp.dest('./'));

    cb();
};

function liveServer(cb) {
    browserSync.init({
        proxy: 'shoppe.local'
    });
    watch(['./assets/src/sass/**/*.scss']).on('change', gulp.series(compileSass));

    cb();
}

exports.default = gulp.series(compileSass, liveServer, concatJsFiles);
exports.rtlcss = gulp.series(buildRtl);
