/**
 * Build a WP readme.
 */

var path = require('path');
var handlebars = require( 'handlebars' );

module.exports = function( grunt ) {

	var formatReadme = function( content ) {
		var replaceRules = {
			'#': '=== $1 ===',
			'##': '== $1 ==',
			'#{3,}': '= $1 =',
		};

		// Replace Markdown headings with WP.org style headings
		Object.keys( replaceRules ).forEach( function( pattern ) {
			var patternRegExp = [ '^', pattern, '\\s(.+)$' ].join( '' );

			content = content.replace(
				new RegExp( patternRegExp, 'gm' ),
				replaceRules[ pattern ]
			);
		} );

		return content;
	};

	var replaceVars = function( content, vars ) {
		var template = handlebars.compile( content );

		return template( vars );
	};

	var getPluginVersion = function( pluginSource ) {
		var pattern = new RegExp( 'Version:\\s*(.+)$', 'mi' );
		var match = pluginSource.match( pattern );

		if ( match.length ) {
			return match[1];
		}

		return null;
	};

	grunt.registerTask( 'readmeMdToTxt', 'Build the readme', function() {

		var options = this.options( {
			src: 'readme.md',
			dest: 'readme.txt',
			pluginFile: null,
		} );

		var pkgConfig = grunt.config.get( 'pkg' );
		var srcFile = grunt.file.read( options.src );
		var destDir = path.dirname( options.dest );

		// Extract the version from the main plugin file.
		if ( 'undefined' === typeof pkgConfig.version ) {
			var pluginVersion = getPluginVersion( grunt.file.read( options.pluginFile ) );

			if ( ! pluginVersion ) {
				grunt.warn( 'Failed to parse the plugin version in the plugin file.' );
			}

			pkgConfig.version = pluginVersion;
		}

		// Replace all variables.
		var readmeTxt = replaceVars( srcFile, pkgConfig );

		// Ensure we have the destination directory.
		if ( destDir ) {
			grunt.file.mkdir( destDir );
		}

		// Write the readme.txt.
		grunt.file.write( options.dest, formatReadme( readmeTxt ) );

	} );

}
