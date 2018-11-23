<?php

namespace Preseto\BlockContext;

/**
 * Plugin runner.
 */
class BlockContextPlugin {

	const CONTEXT_POST_TYPE = 'block_context';

	/**
	 * Plugin interface.
	 *
	 * @var \Preseto\BlockContext\Plugin
	 */
	protected $plugin;

	/**
	 * Context store interface.
	 *
	 * @var \Preseto\BlockContext\ContextStore
	 */
	protected $context_store;

	/**
	 * Setup the plugin instance.
	 *
	 * @param \Preseto\BlockContext\Plugin $plugin Instance of the plugin abstraction.
	 */
	public function __construct( $plugin ) {
		$this->plugin = $plugin;

		$this->context_store = new ContextStore( self::CONTEXT_POST_TYPE );
	}

	/**
	 * Hook into WP.
	 *
	 * @return void
	 */
	public function init() {
		add_action( 'init', [ $this->context_store, 'init' ] );
		add_action( 'enqueue_block_editor_assets', [ $this, 'enqueue_editor_assets' ] );
	}

	/**
	 * Load our block assets.
	 *
	 * @return void
	 */
	public function enqueue_editor_assets() {
		wp_enqueue_script(
			'preseto-block-context-editor-js',
			$this->plugin->asset_url( 'js/dist/editor.js' ),
			[
				'wp-compose',
				'wp-element',
				'wp-editor',
				'wp-components',
				'lodash',
			],
			$this->plugin->asset_version()
		);
	}

}
