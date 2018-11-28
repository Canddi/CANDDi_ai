/**
 * Created by steve on 28/07/2014.
 */
module.exports = function (grunt) {

    var strRelease      = grunt.option('release'),
        strReleaseMD5   = grunt.option('releaseMD5'),
        strClient       = grunt.option('client'),
        strBaseDest     = strRelease + '/js/';

    var  _              = require('underscore')._,
        objBasePaths    = {
            'CanddiAI'         : 'CanddiAI',
            'zend'              : 'vendor/zendframework/zendframework1/library/Zend'
        },
        objClassMaps = {},
        objPhpunit = {},
        arrConcurrentClassmaps = [];

    //remap classmaps so it actually generates classmaps
    _.each(objBasePaths, function (val, key) {
        var strLibraryDir = './src/main/php/' + val;
        console.log(strLibraryDir);

        objClassMaps[key] = 'php src/site/resources/ZendClassmaps/classmap_generator.php -w -l ' + strLibraryDir + ' -o ' + strLibraryDir + '/.classmap.php';
        arrConcurrentClassmaps.push('exec:' + key);
    });

    grunt.config.init({
        concurrent : {
            classmaps : arrConcurrentClassmaps
        },
        exec : objClassMaps,
        phplint : {
            options : {
                swapPath : '/tmp'
            },
            all : ['**/*.php', '!libs/**', '!node_modules/**', '!vendor/**']
        },
        phpunit : {
            classes : {
                dir : '../../test/php/'
            },
            options: {
                bin: 'vendor/phpunit/phpunit/phpunit',
                colors: true,
                verbose: true,
                stopOnError : true,
                stopOnFailure : true,
                stderr : true
            }
        }
    });
    //this setups a different target for each of the php dirs
    grunt.config.merge({
        phpunit : objPhpunit
    });

    var arrBuildTasks = ['makeClassmaps', 'string-replace', 'phplint'];

    if (grunt.option('production')) {
        arrBuildTasks.push('install');
        arrBuildTasks.push('test');
    }

    grunt.registerTask('install', ['composer:install']);
    grunt.registerTask('makeClassmaps', ['concurrent:classmaps']);
    grunt.registerTask('test', ['string-replace', 'phpunit']);
    grunt.registerTask('build', arrBuildTasks);
    grunt.registerTask('default', ['build', 'test']);

    require('matchdep').filterDev(['grunt-*', '!grunt-template-jasmine-*', '!grunt-aws']).forEach(grunt.loadNpmTasks);
};
