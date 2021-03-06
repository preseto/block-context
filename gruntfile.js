const ignoreParse = require( 'parse-gitignore' );

module.exports = ( grunt ) => {

	// Load all Grunt plugins.
	require( 'load-grunt-tasks' )( grunt );

	grunt.loadTasks( './scripts/grunt' );

	// Get a list of all the files and directories to exclude from the distribution.
	const distignore = ignoreParse( '.distignore', {
		invert: true,
	} );

	grunt.initConfig( {
		pkg: grunt.file.readJSON( 'package.json' ),

		dist_dir: 'dist/block-context',

		clean: {
			build: [
				'<%= dist_dir %>',
				'dist/zips',
			],
			js: [
				'js/dist',
			],
		},

		readmeMdToTxt: {
			options: {
				src: 'readme.txt.md',
				dest: '<%= dist_dir %>/readme.txt',
				pluginFile: 'block-context.php',
			},
		},

		copy: {
			dist: {
				src: [ '**' ].concat( distignore ),
				dest: '<%= dist_dir %>',
				expand: true,
			}
		},

		compress: {
			release: {
				options: {
					archive: 'dist/zips/block-context.zip',
				},
				expand: true,
				cwd: 'dist',
				src: 'block-context/**',
			}
		},

		wp_deploy: {
			options: {
				plugin_slug: 'block-context',
				svn_user: 'kasparsd',
				build_dir: '<%= dist_dir %>',
				assets_dir: 'assets/wporg',
			},
			all: {
				options: {
					deploy_tag: true,
					deploy_trunk: true,
				}
			},
			trunk: {
				options: {
					deploy_tag: false,
				}
			}
		},
	} );

	grunt.registerTask(
		'release', [
			'clean:build',
			'copy',
			'readmeMdToTxt',
		]
	);

	grunt.registerTask(
		'release-zip', [
			'release',
			'compress',
		]
	);

	grunt.registerTask(
		'deploy', [
			'release',
			'wp_deploy:all',
		]
	);

	grunt.registerTask(
		'deploy-trunk', [
			'release',
			'wp_deploy:trunk',
		]
	);

};
