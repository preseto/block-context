<?php

$plugin_slug = 'block-context';

$root_dir = dirname( __DIR__ );
$target_default = sprintf( '%s/%s.zip', $root_dir, $plugin_slug );
$target = isset( $argv[1] ) ? $argv[1] : $target_default;

/**
 * Parse .distignore patterns.
 *
 * @return string[]
 */
function get_ignore_patterns( string $file ): array {
	if ( ! is_readable( $file ) ) {
		return [];
	}

	$patterns = [];

	foreach ( file( $file, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES ) as $line ) {
		$line = trim( $line );

		if ( '' !== $line && 0 !== strpos( $line, '#' ) ) {
			$patterns[] = $line;
		}
	}

	return $patterns;
}

/**
 * Match a gitignore-style pattern against a relative path.
 */
function pattern_matches( string $pattern, string $path ): bool {
	$anchored = ( 0 === strpos( $pattern, '/' ) );
	$dir_only = ( '/' === substr( $pattern, -1 ) );

	$pattern = trim( $pattern, '/' );

	if ( '' === $pattern ) {
		return false;
	}

	// Patterns without a slash match against any path segment.
	if ( ! $anchored && false === strpos( $pattern, '/' ) ) {
		foreach ( explode( '/', $path ) as $segment ) {
			if ( fnmatch( $pattern, $segment ) ) {
				return true;
			}
		}

		return false;
	}

	// Anchored or multi-segment patterns match from the root.
	$regex = preg_quote( $pattern, '#' );
	$regex = str_replace( [ '\*\*', '\*', '\?' ], [ '.*', '[^/]*', '[^/]' ], $regex );

	if ( $dir_only ) {
		$regex .= '(/|$)';
	} else {
		$regex .= '$';
	}

	return (bool) preg_match( '#^' . $regex . '#i', $path );
}

/**
 * Check if a relative path is excluded by .distignore.
 */
function is_ignored( string $path, array $patterns ): bool {
	foreach ( $patterns as $pattern ) {
		if ( pattern_matches( $pattern, $path ) ) {
			return true;
		}
	}

	return false;
}

/**
 * Get the plugin version from the main plugin file header.
 */
function get_plugin_version( string $plugin_file ): string {
	$source = file_get_contents( $plugin_file );

	if ( preg_match( '/Version:\s*(.+)$/mi', $source, $match ) ) {
		return trim( $match[1] );
	}

	return '0.0.0';
}

/**
 * Render readme.txt.md into the WP.org readme.txt format.
 */
function render_readme( string $template_file, string $version ): string {
	$content = file_get_contents( $template_file );

	$templates = [
		'version' => $version,
	];

	foreach ( $templates as $key => $value ) {
		$content = str_replace(
			sprintf( '{{ %s }}', $key ),
			$value,
			$content
		);
	}

	// Markdown headings to WP.org headings.
	$content = preg_replace( '/^#\s(.+)$/m', '=== $1 ===', $content );
	$content = preg_replace( '/^##\s(.+)$/m', '== $1 ==', $content );
	$content = preg_replace( '/^#{3,}\s(.+)$/m', '= $1 =', $content );

	return $content;
}

$patterns = get_ignore_patterns( $root_dir . '/.distignore' );
$version = get_plugin_version( $root_dir . '/' . $plugin_slug . '.php' );

if ( ! is_dir( dirname( $target ) ) ) {
	mkdir( dirname( $target ), 0777, true );
}

$zip = new ZipArchive();

if ( true !== $zip->open( $target, ZipArchive::CREATE | ZipArchive::OVERWRITE ) ) {
	trigger_error( sprintf( 'Failed to create %s', $target ), E_USER_ERROR );
}

$iterator = new RecursiveIteratorIterator(
	new RecursiveDirectoryIterator( $root_dir, FilesystemIterator::SKIP_DOTS | FilesystemIterator::CURRENT_AS_PATHNAME )
);

$count = 0;

foreach ( $iterator as $path ) {
	$relative = substr( $path, strlen( $root_dir ) + 1 );

	if ( ! is_ignored( $relative, $patterns ) ) {
		$zip->addFile( $path, $plugin_slug . '/' . $relative );
		$count++;
	}
}

$readme_template = $root_dir . '/readme.txt.md';

if ( is_readable( $readme_template ) ) {
	$zip->addFromString( $plugin_slug . '/readme.txt', render_readme( $readme_template, $version ) );
	$count++;
}

$zip->close();

printf(
	"Created %s (%d files, %.1f KB, version %s)\n",
	$target,
	$count,
	filesize( $target ) / 1024,
	$version
);
