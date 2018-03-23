var gulp        = require('gulp'),
    gulpWebpack = require('gulp-webpack'),
    uglifyJS    = require('gulp-uglify'),
    sass        = require('gulp-sass');

gulp.task('default', [
    'build-app-js',
    'build-app-css'
]);

gulp.task('build-app-js', function () {
    gulp.src('src/app/Application/Http/App/resources/js/app.js')
        .pipe(gulpWebpack({
            output: {
                filename: 'app.js'
            },
            module: {
                loaders: [
                    {
                        test: /\.vue$/,
                        loader: 'vue'
                    },
                    {
                        test: /\.json/,
                        loader: 'json'
                    }
                ]
            }
        }))
        .pipe(uglifyJS())
        .pipe(gulp.dest('./src/public/js'));
});

gulp.task('build-app-css', function () {
    return gulp.src('src/app/Application/Http/App/resources/sass/app.scss')
        .pipe(sass({outputStyle: 'compressed'}))
        .pipe(gulp.dest('src/public/css'))
});
