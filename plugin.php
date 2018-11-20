<?php
/**
 * Plugin Name: Block Context
 * Plugin URI: https://widgetcontext.com
 * Description: Show or hide Gutenberg blocks in context.
 * Version: 1.1.0
 * Author: Preseto
 * Author URI: https://preseto.com
 * Requires PHP: 5.3
 * Text Domain: block-context
 */

namespace Preseto\BlockContext;

require_once __DIR__ . '/vendor/autoload.php';

$block_context_plugin = new BlockContextPlugin( new Plugin( __FILE__ ) );
$block_context_plugin->init();
