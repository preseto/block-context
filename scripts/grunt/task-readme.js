/**
 * Build a WordPress readme.txt file out of a markdown source template.
 */

const path = require( 'path' );
const handlebars = require( 'handlebars' );

function formatReadme( content ) {
	const replaceRules = {
		'#': '=== $1 ===',
		'##': '== $1 ==',
		'#{3,}': '= $1 =',
	};

	// Replace Markdown headings with WP.org style headings
	Object.keys( replaceRules ).forEach( pattern => {
		const patternRegExp = [ '^', pattern, '\\s(.+)$' ].join( '' );

		content = content.replace(
			new RegExp( patternRegExp, 'gm' ),
			replaceRules[ pattern ]
		);
	} );

	return content;
};

function replaceVars( content, vars ) {
	const template = handlebars.compile( content );

	return template( vars );
};

function getPluginVersion( pluginSource ) {
	const pattern = new RegExp( 'Version:\\s*(.+)$', 'mi' );
	const match = pluginSource.match( pattern );

	if ( match.length ) {
		return match[1];
	}

	return null;
};

module.exports = ( grunt ) => {

	grunt.registerTask( 'readmeMdToTxt', 'Convert a Markdown readme into WordPress readme', function() {
		const options = this.options( {
			src: 'readme.md',
			dest: 'readme.txt',
			pluginFile: null,
		} );

		const pkgConfig = grunt.config.get( 'pkg' );
		const srcFile = grunt.file.read( options.src );
		const destDir = path.dirname( options.dest );

		// Extract the version from the main plugin file.
		if ( 'undefined' === typeof pkgConfig.version ) {
			const pluginVersion = getPluginVersion( grunt.file.read( options.pluginFile ) );

			if ( ! pluginVersion ) {
				grunt.warn( 'Failed to parse the plugin version in the plugin file.' );
			}

			pkgConfig.version = pluginVersion;
		}

		// Replace all variables.
		const readmeTxt = replaceVars( srcFile, pkgConfig );

		// Ensure we have the destination directory.
		if ( destDir ) {
			grunt.file.mkdir( destDir );
		}

		// Write the readme.txt.
		grunt.file.write( options.dest, formatReadme( readmeTxt ) );
	} );
}
