<?php
/**
 * Can't use /wordpress-phpunit/wp-tests-config.php from wp-env since it is
 * specific to the wp-env setup.
 */

function get_env( string $name, $default_value = null ) {
	$value = getenv( $name );

	if ( false !== $value ) {
		return $value;
	}

	return $default_value;
}

define( 'WP_PHP_BINARY', 'php' );
define( 'WP_TESTS_EMAIL', 'admin@example.org' );
define( 'WP_TESTS_TITLE', 'Test Blog' );
define( 'WP_TESTS_DOMAIN', 'example.org' );
define( 'WP_TESTS_MULTISITE', get_env( 'WP_TESTS_MULTISITE', false ) );

define( 'DB_NAME', get_env( 'WORDPRESS_DB_NAME' ) );
define( 'DB_USER', get_env( 'WORDPRESS_DB_USER' ) );
define( 'DB_PASSWORD', get_env( 'WORDPRESS_DB_PASSWORD' ) );
define( 'DB_HOST', get_env( 'WORDPRESS_DB_HOST', 'mysql' ) );
define( 'DB_CHARSET', get_env( 'WORDPRESS_DB_CHARSET', 'utf8' ) );
define( 'DB_COLLATE', get_env( 'WORDPRESS_DB_COLLATE' ) );

define( 'WP_DEBUG_LOG', true );
define( 'WP_DEBUG_DISPLAY', true );
define( 'WP_DEBUG', true );
define( 'SCRIPT_DEBUG', true );

if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', '/var/www/html/' );
}
