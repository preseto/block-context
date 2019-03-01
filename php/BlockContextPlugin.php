<?php

namespace Preseto\BlockContext;

/**
 * Plugin runner.
 */
class BlockContextPlugin {

	const BLOCK_CONTEXT_BLOCK_ID = 'preseto/block-context-block';

	const BLOCK_CONTEXT_SCRIPT_ID = 'preseto-block-context-block';

	/**
	 * Plugin interface.
	 *
	 * @var \Preseto\BlockContext\Plugin
	 */
	protected $plugin;

	protected $contexts;

	protected $context_enable;

	/**
	 * Setup the plugin instance.
	 *
	 * @param \Preseto\BlockContext\Plugin $plugin Instance of the plugin abstraction.
	 */
	public function __construct( $plugin ) {
		$this->plugin = $plugin;

		$this->context_enable = new Contexts\ContextEnable();

		$this->contexts = new BlockContexts();
	}

	/**
	 * Hook into WP.
	 *
	 * @return void
	 */
	public function init() {
		$this->contexts->add( new Contexts\UserLoggedIn() );

		add_action( 'init', [ $this, 'register_blocks' ] );
		add_action( 'enqueue_block_editor_assets', [ $this, 'enqueue_editor_assets' ] );
		add_filter( 'render_block', [ $this, 'maybe_hide_block' ], 5, 2 );
	}

	/**
	 * Disable block output if context enabled and matches.
	 *
	 * @param  string $rendered Rendered block output.
	 * @param  array  $block    Block meta data.
	 *
	 * @return string
	 */
	public function maybe_hide_block( $rendered, $block ) {
		$block_context = new Block( $block );

		if ( $this->block_context_enabled( $block_context ) && $this->block_is_hidden( $block_context ) ) {
			return '';
		}

		return $rendered;
	}

	/**
	 * If a block has context enabled.
	 *
	 * @param  Preseto\BlockContext\Block $block Instance of a block.
	 *
	 * @return boolean
	 */
	public function block_context_enabled( $block ) {
		return $this->contexts->matches( $block, [ $this->context_enable ] );
	}

	/**
	 * Check if a block should be hidden according to the context rules.
	 *
	 * @param  Preseto\BlockContext\Block $block Instance of a block.
	 *
	 * @return boolean
	 */
	public function block_is_hidden( $block ) {
		return ( ! $this->contexts->matches( $block ) );
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
			self::BLOCK_CONTEXT_SCRIPT_ID,
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
			self::BLOCK_CONTEXT_SCRIPT_ID,
			$this->plugin->asset_url( 'js/src/styles/block-context-block.css' ),
			[
				'wp-edit-blocks',
			],
			$this->plugin->asset_version()
		);

		register_block_type(
			self::BLOCK_CONTEXT_BLOCK_ID,
			[
				//'editor_script' => self::BLOCK_SCRIPT_ID,
				'editor_style' => self::BLOCK_CONTEXT_SCRIPT_ID,
			]
		);
	}

}
