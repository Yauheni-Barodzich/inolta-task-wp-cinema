const themeName = 'inolta-cinema';
const ftpSettings = {};
var syntax        = 'scss',
	gulpversion   = '4';

var gulp          = require('gulp'),
    autoprefixer  = require('gulp-autoprefixer'),
    browsersync   = require('browser-sync'),
    concat        = require('gulp-concat'),
    cache         = require('gulp-cache'),
    cleancss      = require('gulp-clean-css'),
    ftp           = require('vinyl-ftp'),
	imagemin      = require('gulp-imagemin'),
	notify        = require('gulp-notify'),
	pngquant      = require('imagemin-pngquant'),
	gutil         = require('gulp-util' ),
	rename        = require('gulp-rename'),
	rsync         = require('gulp-rsync'),
	sass 		  = require('gulp-sass')(require('sass'));
	uglify        = require('gulp-uglify');

// 'wp-gulp.loc' локальный домен
gulp.task('browser-sync', function() {
	browsersync({
		proxy: "src",
		notify: false,
		// open: false,
		// tunnel: true,
		// tunnel: "gulp-wp-fast-start"
	})
});

// Обьединяем файлы scss, сжимаем и переменовываем
gulp.task('styles', function() {
	return gulp.src(`src/wp-content/themes/${themeName}/assets/scss/**/*.scss`, {"allowEmpty": true})
	.pipe(sass({ outputStyle: 'compressed' }).on("error", notify.onError()))
	//.pipe(rename({ suffix: '.min', prefix : '' }))
	.pipe(concat('style.min.css'))
	.pipe(autoprefixer(['last 15 versions']))
	.pipe(cleancss( {level: { 1: { specialComments: 0 } } })) // Opt., comment out when debugging
	.pipe(gulp.dest(`src/wp-content/themes/${themeName}/assets/css`))
	.pipe(browsersync.stream())
});


// Обьединяем файлы скриптов, сжимаем и переменовываем
gulp.task('scripts', function() {
	return gulp.src([
		//`src/wp-content/themes/${themeName}/assets/scripts/main.js`,
		//`src/wp-content/themes/${themeName}/assets/libs/jquery/dist/jquery.min.js`, // Connecting my scripts
		`src/wp-content/themes/${themeName}/assets/scripts/main.js`, // Always at the end
		], {"allowEmpty": true})
	.pipe(concat('scripts.min.js'))
	.pipe(uglify()) // Mifify js (opt.)
	.pipe(gulp.dest(`src/wp-content/themes/${themeName}/assets/js`))
	.pipe(browsersync.reload({ stream: true }))
});


// сжимаем картинки в папке images в шаблоне, и туда же возвращаем в готовом виде
gulp.task('imgmin-theme', function() {
	return gulp.src(`src/wp-content/themes/${themeName}/assets/images/**/*`, {"allowEmpty": true})
	.pipe(cache(imagemin())) // Cache Images
	.pipe(gulp.dest(`src/wp-content/themes/${themeName}/assets/images`));
});


// сжимаем картинки в папке uploads, и туда же возвращаем в готовом виде
gulp.task('imgmin-uploads', function() {
	return gulp.src('src/wp-content/uploads/**/*', {"allowEmpty": true})
	.pipe(cache(imagemin())) // Cache Images
	.pipe(gulp.dest('src/wp-content/uploads'));
});


// Отгрузка всего сайта на хостинг
gulp.task('deploy-site', function() { 
	var conn = ftp.create(ftpSettings);
	var globs = [
	'src/**', // Путь до готовой папки вашего сайта к отгрузки на хостинг
	//'src/.htaccess',
	];
	return gulp.src(globs, {buffer: false})
	.pipe(conn.dest('/www/domain.com/')); // Путь до папки сайта на хостинге
});


// Отгрузка только шаблона на хостинг
gulp.task('deploy-theme', function() {
	var conn = ftp.create(ftpSettings);
	var globs = [
	`src/wp-content/themes/${themeName}/**`, // Путь до шаблона у вас на компьютере
	];
	return gulp.src(globs, {buffer: false})
	.pipe(conn.dest(`/www/domain.com/wp-content/themes/${themeName}/`)); // Путь до шаблона на хостинге
});


if (gulpversion == 3) {
  gulp.task('watch', ['styles', 'scripts', 'browser-sync'], function() {
	  gulp.watch([`src/wp-content/themes/${themeName}/assets/scss/**/*.scss`], ['styles']); // Наблюдение за scss файлами в папке scss в теме
	  gulp.watch([`src/wp-content/themes/${themeName}/assets/libs/**/*.js`, `src/wp-content/themes/${themeName}/assets/js/common.js`], ['scripts']); // Наблюдение за JS файлами js в теме
    gulp.watch(`src/wp-content/themes/${themeName}/**/*.php`, browsersync.reload) // Наблюдение за scss файлами php в теме
  });
  gulp.task('default', ['watch']);
}


if (gulpversion == 4) {
	gulp.task('watch', function() {
		gulp.watch(`src/wp-content/themes/${themeName}/assets/scss/**/*.scss`, gulp.parallel('styles')); // Наблюдение за scss файлами в папке scss в теме
		gulp.watch([`src/wp-content/themes/${themeName}/assets/libs/**/*.js`, `src/wp-content/themes/${themeName}/assets/js/common.js`], gulp.parallel('scripts')); // Наблюдение за JS файлами в папке js
    gulp.watch(`src/wp-content/themes/${themeName}/**/*.php`, browsersync.reload) // Наблюдение за scss файлами php в теме
	});
	gulp.task('default', gulp.parallel('styles', 'scripts', 'browser-sync', 'watch'));
}
