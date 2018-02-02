var gulp = require('gulp');
var chug = require('gulp-chug');
var argv = require('yargs').argv;

config = [
    '--rootPath',
    argv.rootPath || '../../../../../../../tests/Application/web/assets/',
    '--nodeModulesPath',
<<<<<<< HEAD
    argv.nodeModulesPath || '../../../../../../../tests/Application/node_modules/',
    '--vendorPath',
    argv.vendorPath || '../../../../../../../vendor/'
=======
    argv.nodeModulesPath || '../../../../../../../tests/Application/node_modules/'
>>>>>>> a234fcdaa31aaea4c11ba6ce577f4f225747cdd2
];

gulp.task('admin', function() {
    gulp.src('../../vendor/sylius/sylius/src/Sylius/Bundle/AdminBundle/Gulpfile.js', { read: false })
        .pipe(chug({ args: config }))
    ;
});

gulp.task('shop', function() {
    gulp.src('../../vendor/sylius/sylius/src/Sylius/Bundle/ShopBundle/Gulpfile.js', { read: false })
        .pipe(chug({ args: config }))
    ;
});

gulp.task('default', ['admin', 'shop']);
