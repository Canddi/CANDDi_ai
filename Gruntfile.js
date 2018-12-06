module.exports = function(grunt) {
    /**
     * Configure individual grunt tasks
    **/
    grunt.config.init(
        {
            composer: {
                options: {
                    usePhp: true,
                    cwd: ".",
                    composerLocation: "/usr/local/bin/composer"
                },
                autoload: {
                    options: {
                        usePhp: true,
                        cwd: [
                            "."
                        ],
                        composerLocation: "/usr/local/bin/composer"
                    }
                }
            },
            phpcs: {
                application: {
                    src: [
                        "src/php/**/*.php"
                    ]
                },
                options: {
                    bin: "vendor/bin/phpcs",
                    standard: "Zend"
                }
            },
            "phpunit-runner": {
                options: {
                    bootstrap: "test/localbootstrap.php",
                    colours: true,
                    configuration: "coverage.xml",
                    phpunit: "vendor/bin/phpunit",
                    processIsolation: true,
                    reportUselessTests: true,
                    showUncoveredFiles: true,
                    strictCoverage: true,
                    verbose: true,
                    logJunit: "reports/unit.xml",
                    testdoxHtml: "reports/testdox.html"
                },
                coverage: {
                    options: {
                        coverageHtml: "reports/coverage",
                        coverageText: ""
                    },
                    files: {
                        testFolder: "test/php/"
                    }
                },
                test: {
                    files: {
                        testFolder: "test/php/"
                    }
                }
            }
        }
    );

    /**
     * Register invokeable grunt tasks
    **/
    grunt.registerTask(
        "build",
        [
            "makeClassmaps"
        ]
    );

    grunt.registerTask(
        "coverage",
        [
            "phpunit-runner:coverage"
        ]
    );

    grunt.registerTask(
        "default",
        [
            "build",
            "test"
        ]
    );

    grunt.registerTask(
        "makeClassmaps",
        [
            "composer:autoload:dump-autoload"
        ]
    );

    grunt.registerTask(
        "phpcs",
        [
            "phpcs"
        ]
    );

    grunt.registerTask(
        "phpunit",
        [
            "phpunit-runner:test"
        ]
    );

    grunt.registerTask(
        "test",
        [
            "phpcs",
            "phpunit-runner:test"
        ]
    );

    /**
     * Load NPM dependencies s.t. we can actually invoke tasks
    **/
    require('matchdep').filterDev(
        [
            'grunt-*',
            '!grunt-template-jasmine-*',
            '!grunt-aws'
        ]
    ).forEach(grunt.loadNpmTasks);
}
