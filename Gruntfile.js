/* jshint node:true */
module.exports = function ( grunt ) {
    var path = require( 'path' ),
        SOURCE_DIR = 'src/',
        BUILD_DIR = 'build/',
        autoprefixer = require( 'autoprefixer' ),
        buildConfig = {},
        builds = [ 'admin' ];

    // Load tasks.
    require( 'matchdep' ).filterDev( [ 'grunt-*', '!grunt-legacy-util' ] ).forEach( grunt.loadNpmTasks );

    // Load legacy utils
    grunt.util = require( 'grunt-legacy-util' );

    builds.forEach( function ( build ) {
        var path = SOURCE_DIR + 'admin/js/';
        buildConfig[ build ] = { files: {} };
        buildConfig[ build ].files[ path + build + '.js' ] = [ path + '/src/' + build + '.manifest.js' ];
    } );

    // Project configuration.
    grunt.initConfig( {

        clean: {
            all: [ BUILD_DIR ],
            dynamic: {
                dot: true,
                expand: true,
                cwd: BUILD_DIR,
                src: []
            }
        },
        copy: {
            files: {
                files: [
                    {
                        dot: true,
                        expand: true,
                        cwd: SOURCE_DIR,
                        src: [ // Set here the files to include/exclude.
                            '**',
                            '!**/.git/**' // Ignore version control directories.
                        ],
                        dest: BUILD_DIR
                    }
                ]
            },
            dynamic: {
                dot: true,
                expand: true,
                cwd: SOURCE_DIR,
                dest: BUILD_DIR,
                src: []
            }
        },
        browserify: buildConfig,
        jshint: {
            options: grunt.file.readJSON( '.jshintrc' ),
            grunt: {
                src: [ 'Gruntfile.js' ]
            },
            admin: {
                options: {
                    browserify: true
                },
                src: [
                    SOURCE_DIR + 'admin/js/**/*.js'
                ]
            }
        },
        uglify: {
            options: {
                ASCIIOnly: true
            },
            admin: {
                expand: true,
                cwd: SOURCE_DIR,
                dest: BUILD_DIR,
                ext: '.min.js',
                src: [
                    'admin/js/helixware-mico-admin.js'
                ]
            }
        },
        jsvalidate: {
            options: {
                globals: {},
                esprimaOptions: {},
                verbose: false
            },
            build: {
                files: {
                    src: BUILD_DIR + '{admin,public}/js/**/*.js'
                }
            }
        },
        imagemin: {
            core: {
                expand: true,
                cwd: SOURCE_DIR,
                src: '{admin,public}/images/**/*.{png,jpg,gif,jpeg}',
                dest: SOURCE_DIR
            }
        },
        _watch: {
            all: {
                files: [
                    SOURCE_DIR + '**',
                    '!' + SOURCE_DIR + 'admin/js/src/**',
                    // Ignore version control directories.
                    '!' + SOURCE_DIR + '**/.git/**'
                ],
                tasks: [ 'clean:dynamic', 'copy:dynamic' ],
                options: {
                    dot: true,
                    spawn: false,
                    interval: 2000
                }
            },
            config: {
                files: 'Gruntfile.js'
            }
        }

    } );


    grunt.renameTask( 'watch', '_watch' );

    grunt.registerTask( 'watch', function () {
        if ( !this.args.length || this.args.indexOf( 'browserify' ) > -1 ) {
            grunt.config( 'browserify.options', {
                browserifyOptions: {
                    debug: true
                },
                watch: true
            } );

            grunt.task.run( 'browserify' );
        }

        grunt.task.run( '_' + this.nameArgs );
    } );

    // Default task.
    grunt.registerTask('default', ['build']);

    /*
     * Automatically updates the `:dynamic` configurations
     * so that only the changed files are updated.
     */
    grunt.event.on('watch', function( action, filepath, target ) {
        var src;

        if ( [ 'all', 'rtl', 'browserify' ].indexOf( target ) === -1 ) {
            return;
        }

        src = [ path.relative( SOURCE_DIR, filepath ) ];

        if ( action === 'deleted' ) {
            grunt.config( [ 'clean', 'dynamic', 'src' ], src );
        } else {
            grunt.config( [ 'copy', 'dynamic', 'src' ], src );

            if ( target === 'rtl' ) {
                grunt.config( [ 'rtlcss', 'dynamic', 'src' ], src );
            }
        }
    });
};
