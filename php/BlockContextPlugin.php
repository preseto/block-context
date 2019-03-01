<?php

namespace Preseto\BlockContext;

/**
 * Plugin runner.
 */
class BlockContextPlugin {

	const BLOCK_SCRIPT_ID = 'preseto-block-context-block';

	/**
	 * Plugin interface.
	 *
	 * @var \Preseto\BlockContext\Plugin
	 */
	protected $plugin;

	/**
	 * Setup the plugin instance.
	 *
	 * @param \Preseto\BlockContext\Plugin $plugin Instance of the plugin abstraction.
	 */
	public function __construct( $plugin ) {
		$this->plugin = $plugin;
	}

	/**
	 * Hook into WP.
	 *
	 * @return void
	 */
	public function init() {
		add_action( 'init', [ $this, 'register_blocks' ] );
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

	public function register_blocks() {
		wp_register_script(
			self::BLOCK_SCRIPT_ID,
			$this->plugin->asset_url( 'js/dist/block.js' ),
			[
				'wp-compose',
				'wp-element',
				'wp-editor',
				'wp-components',
				'lodash',
			],
			$this->plugin->asset_version()
		);

		wp_register_style(
			self::BLOCK_SCRIPT_ID,
			$this->plugin->asset_url( 'js/src/styles/block-context-block.css' ),
			[
				'wp-edit-blocks',
			],
			$this->plugin->asset_version()
		);

		register_block_type(
			'preseto/block-context-block',
			[
				//'editor_script' => self::BLOCK_SCRIPT_ID,
				'editor_style' => self::BLOCK_SCRIPT_ID,
			]
		);
	}

}
