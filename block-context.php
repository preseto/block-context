<?php
/**
 * Plugin Name: Block Context
 * Plugin URI: https://blockcontext.com
 * Description: Hide Gutenberg editor blocks in context.
 * Version: 0.1.0
 * Author: Kaspars Dambis
 * Author URI: https://kaspars.net
 * Text Domain: block-context
 */

namespace Preseto\BlockContext;

// Support for site-level autoloading.
if ( file_exists( __DIR__ . '/vendor/autoload.php' ) ) {
	require_once __DIR__ . '/vendor/autoload.php';
}

$block_context_plugin = new BlockContextPlugin( new Plugin( __FILE__ ) );

add_action( 'plugins_loaded', [ $block_context_plugin, 'init' ] );
