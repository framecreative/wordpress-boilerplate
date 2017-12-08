/* global process */

const lazypipe      = require('lazypipe');
const fs            = require('fs');
const runSequence   = require('run-sequence');
const gulp          = require('gulp');
const gulpif        = require('gulp-if');
const rev           = require('gulp-rev');
const notifier      = require('node-notifier');
const browserSync   = require('browser-sync').create();
const sourcemaps    = require('gulp-sourcemaps');
const sass          = require('gulp-sass');
const sassGlob      = require('gulp-sass-glob');
const svgStore      = require('gulp-svgstore');
const svgMin        = require('gulp-svgmin');
const modernizr     = require('gulp-modernizr');
const gutil         = require('gulp-util');
const postcss       = require('gulp-postcss');
const autoprefixer  = require('autoprefixer');
const cssnano       = require('cssnano');
const webpackStream = require('webpack-stream-fixed');
const webpack       = require('webpack');
const named         = require('vinyl-named-with-path');
const rename        = require('gulp-rename');
const webpackConfig = require('./webpack.config.js');
const npmConfig     = JSON.parse(fs.readFileSync('./package.json')).config;

const dupeFiles     = [
  `${npmConfig.assetSource}**/*`, `!${npmConfig.assetSource}{styles,scripts,icons,vendor,fonts}{,/**/*}`
];

const isProduction = process.env.NODE_ENV === 'production';


// Output any errors but keep on running
const handleError = function(err) {

  notifier.notify({
    'title': 'Gulp Error',
    'message': err.plugin.toString()
  });

  gutil.log( gutil.colors.red( err.toString() ) );
  this.emit('end');

}


const writeVersionsFile = function() {

    return lazypipe()
    .pipe( rev.manifest,`${npmConfig.assetDist}versions.json`, {
        merge: true,
        base: npmConfig.assetDist
    } )
    .pipe( gulp.dest, npmConfig.assetDist )();

};

/* DUPE */

gulp.task( 'dupe', function(){

  return gulp.src( dupeFiles, { base: npmConfig.assetSource } )
    .pipe( gulp.dest( npmConfig.assetDist ) );

} );


/* STYLES */

gulp.task( 'styles', function() {

    return gulp.src( `${npmConfig.assetSource}styles/*.scss`, { base: npmConfig.assetSource } )
        .pipe( sourcemaps.init() )
        .pipe( sassGlob() )
        .pipe( sass({
          includePaths: ['node_modules', 'bower_components']
        }).on('error', handleError) )
        .pipe( postcss([
          autoprefixer({ browsers: ['iOS >= 7', 'ie >= 9'] }),
          cssnano({ safe: true })
        ]) )
        .pipe( gulpif( isProduction, rev() ) )
        .pipe( sourcemaps.write('./') )
        .pipe( gulp.dest( npmConfig.assetDist ) )
        .pipe( browserSync.stream({match: '**/*.css'}) )
        .pipe( writeVersionsFile() );

});




/* SCRIPTS */

gulp.task( 'scripts', function() {

    return gulp.src( `${npmConfig.assetSource}scripts/*.js`, { base: npmConfig.assetSource } )
    .pipe( named() )
    .pipe( webpackStream( webpackConfig, webpack ).on('error', handleError) )
    .pipe( gulpif( isProduction, rev() ) )
    .pipe( gulp.dest( npmConfig.assetDist ) )
    .pipe( browserSync.stream({match: '**/*.js'}) )
    .pipe( writeVersionsFile() );

});



/* ICONS */

gulp.task( 'icons', function() {

  return gulp.src( `${npmConfig.assetSource}icons/*.svg`, { base: `${npmConfig.assetSource}icons/` } )
      .pipe( svgMin() )
      .pipe( rename( { prefix: 'icons--' } ) )
      .pipe( svgStore() )
      .pipe( gulpif( isProduction, rev() ) )
      .pipe( gulp.dest( npmConfig.assetDist ) )
      .pipe( writeVersionsFile() );

});


/* Fonts */

gulp.task( 'fonts', function() {

    return gulp.src( `${npmConfig.assetSource}fonts/**/*`, { base: npmConfig.assetSource } )
        .pipe( gulp.dest( npmConfig.assetDist ) );

});


/* MODERNIZR */

gulp.task( 'modernizr', function() {

  return gulp.src(
    [
      `${npmConfig.assetSource}scripts/**/*.js`,
      `${npmConfig.assetSource}styles/**/*.scss`
    ],
    { base: npmConfig.assetSource } )
    .pipe( modernizr( 'scripts/modernizr.js', {
      tests: ['flexbox'],
      options : [
          'setClasses',
          'addTest',
          'html5printshiv',
          'html5shiv',
          'testProp',
          'fnBind'
      ]
    }) )
    .pipe( gulpif( isProduction, rev() ) )
    .pipe( gulp.dest( npmConfig.assetDist ) )
    .pipe( writeVersionsFile() );

});



/* Browsersync */

gulp.task( 'browsersync', function() {

  return browserSync.init({
    proxy: npmConfig.devUrl,
    files: [ `${npmConfig.themeFolder}/**/*.php`,
      `${npmConfig.themeFolder}/**/*.twig`
    ],
    snippetOptions: {
      whitelist: [ '/wordpress/wp-admin/admin-ajax.php', '/**/?wc-ajax=*' ],
      blacklist: [ '/wordpress/**']
    },
    notify: false,
    open: false
  });

});


/* CLEAN */

gulp.task('clean', require('del').bind(null, [npmConfig.assetDist]));


/* BUILD */

gulp.task( 'build', function( cb ) {

  runSequence( 'clean', 'modernizr', 'scripts', 'styles', 'icons', 'fonts', 'dupe', cb );

});



/* WATCHER */

gulp.task( 'watch', ['build'], function(cb){

  webpackConfig.watch = true;
  gulp.start('scripts');

  gulp.watch( [ dupeFiles ], ['dupe'] );
  gulp.watch( [ `${npmConfig.assetSource}/styles/**/*.scss` ], ['styles'] );
  gulp.watch( [ `${npmConfig.assetSource}/icons/**/*.svg` ], ['icons'] );
  gulp.watch( [ `${npmConfig.assetSource}/fonts/**/*` ], ['fonts'] );

  return cb();
});



/* WATCHER */

gulp.task( 'default', [ 'browsersync', 'watch' ] );
