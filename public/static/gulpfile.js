const gulp = require('gulp');
const concat = require('gulp-concat');
const cssnano = require('gulp-cssnano');
const imagemin = require('gulp-imagemin');
const livereload = require('gulp-livereload');
const rimraf = require('gulp-rimraf');
const sass = require('gulp-sass');
const uglify = require('gulp-uglify');
const hash = require('gulp-hash-filename');
const autoprefixer = require('gulp-autoprefixer');

var config = require('./gulpconfig');
var static = config.static;

function buildVendorsData(vendors) {
    var vendorsData = {};
    for (var vendor in vendors) {
        if (vendors.hasOwnProperty(vendor)) {
            var vendorConfig = vendors[vendor];
            for (var type in vendorConfig) {
                if (vendorConfig.hasOwnProperty(type)) {
                    var matches = vendorConfig[type];
                    if (typeof vendorsData[type] == 'undefined') {
                        vendorsData[type] = [];
                    }
                    if (typeof matches == 'string') {
                        vendorsData[type].unshift(matches);
                    } else {
                        vendorsData[type] = [].concat(vendorsData[type], matches)
                    }
                }
            }
        }
    }
    return vendorsData;
}

var vendorsData = buildVendorsData(static.vendors);

for (var vendorType in vendorsData) {
    if (vendorsData.hasOwnProperty(vendorType)) {
        if (!static.src.hasOwnProperty(vendorType)) {
            static.src[vendorType] = [];
        }
        static.src[vendorType] = [].concat(vendorsData[vendorType], static.src[vendorType]);
    }
}

gulp.task('scss', function() {
    return gulp.src(static.src.scss)
        .pipe(sass({
            includePaths: static.src.scss_include ? frontend.src.scss_include : []
        }).on('error', sass.logError))
        .pipe(gulp.dest(static.dst.scss));
});

gulp.task('css', ['scss', 'clear_css'], function() {
    var pipe = gulp.src(static.src.css);

    pipe = pipe.pipe(autoprefixer());
    if (config.compress) {
        pipe = pipe.pipe(cssnano())
    }
    pipe = pipe.pipe(concat(config.name + '.css'));
    if (config.hash) {
        pipe = pipe.pipe(hash());
    }
    return pipe.pipe(gulp.dest(static.dst.css)).
    pipe(livereload());
});

gulp.task('js', ['clear_js'], function() {
    var pipe = gulp.src(static.src.js);
    if (config.compress) {
        pipe = pipe.pipe(uglify())
    }
    pipe = pipe.pipe(concat(config.name + '.js'));
    if (config.hash) {
        pipe = pipe.pipe(hash());
    }
    return pipe.pipe(gulp.dest(static.dst.js)).
    pipe(livereload());
});

gulp.task('images', function() {
    var pipe = gulp.src(static.src.images);
    if (config.compress) {
        pipe = pipe.pipe(imagemin())
    }
    return pipe.pipe(gulp.dest(static.dst.images)).pipe(livereload());
});

gulp.task('fonts', function() {
    return gulp.src(static.src.fonts)
        .pipe(gulp.dest(static.dst.fonts)).pipe(livereload());
});

gulp.task('watch', ['build'], function() {
    livereload({ start: true });

    gulp.watch(static.src.scss, ['css']);
    gulp.watch(static.src.js, ['js']);
    gulp.watch(static.src.images, ['images']);
    gulp.watch(static.src.fonts, ['fonts']);
});


gulp.task('clear', function() {
    return gulp.src(['dist/*']).pipe(rimraf());
});

gulp.task('clear_css', function() {
    return gulp.src(['dist/css/*']).pipe(rimraf());
});

gulp.task('clear_js', function() {
    return gulp.src(['dist/js/*']).pipe(rimraf());
});

gulp.task('build', ['clear'], function(){
    gulp.start(
       'js', 'images', 'fonts'
    );
});

gulp.task('default', function(){
    gulp.start('watch');
});
