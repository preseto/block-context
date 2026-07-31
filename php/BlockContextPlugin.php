<?php

namespace Preseto\BlockContext;

/**
 * Plugin runner.
 */
class BlockContextPlugin {

	/**
	 * Plugin interface.
	 *
	 * @var \Preseto\BlockContext\Plugin
	 */
	protected Plugin $plugin;

	/**
	 * Block context store.
	 *
	 * @var \Preseto\BlockContext\BlockContexts
	 */
	protected BlockContexts $contexts;

	/**
	 * Context that enables the block context.
	 *
	 * @var \Preseto\BlockContext\Contexts\ContextRule
	 */
	protected Contexts\ContextRule $context_rule;

	/**
	 * Setup the plugin instance.
	 *
	 * @param \Preseto\BlockContext\Plugin $plugin Instance of the plugin abstraction.
	 */
	public function __construct( Plugin $plugin ) {
		$this->plugin = $plugin;

		$this->context_rule = new Contexts\ContextRule();

		$this->contexts = new BlockContexts();
	}

	/**
	 * Hook into WP.
	 *
	 * @return void
	 */
	public function init(): void {
		$this->contexts->add( new Contexts\UserLoggedIn() );

		add_action( 'enqueue_block_editor_assets', [ $this, 'enqueue_editor_assets' ] );
		add_filter( 'render_block', [ $this, 'maybe_hide_block' ], 5, 2 );
	}

	/**
	 * Load our block assets.
	 *
	 * @return void
	 */
	public function enqueue_editor_assets(): void {
		$asset = $this->plugin->asset_meta( 'build/editor.js' );

		wp_enqueue_script(
			'preseto-block-context-editor-js',
			$asset['url'],
			$asset['dependencies'],
			$asset['version'],
			true
		);
	}

	/**
	 * Disable block output if context enabled and matches.
	 *
	 * @param  string $rendered Rendered block output.
	 * @param  array  $block_data    Block meta data.
	 *
	 * @return string
	 */
	public function maybe_hide_block( string $rendered, array $block_data ): string {
		$block = new Block( $block_data );

		if ( ! $this->block_is_visible( $block ) ) {
			return '';
		}

		return $rendered;
	}

	/**
	 * Is block currently visible.
	 *
	 * @param  \Preseto\BlockContext\Block $block Block.
	 *
	 * @return boolean
	 */
	public function block_is_visible( Block $block ): bool {
		$block_context = new BlockContext( $block, $this->context_rule );

		$rule = $block_context->value();

		if ( ! empty( $rule ) ) {
			$matches_contexts = $this->block_matches_contexts( $block );

			if ( 'show' === $rule && $matches_contexts ) {
				return true;
			} elseif ( 'hide' === $rule && ! $matches_contexts ) {
				return true;
			}

			return false;
		}

		return true;
	}

	/**
	 * Check if a block matches any of the context rules.
	 *
	 * @param  \Preseto\BlockContext\Block $block Instance of a block.
	 *
	 * @return boolean
	 */
	public function block_matches_contexts( Block $block ): bool {
		foreach ( $this->contexts->all() as $context ) {
			$block_context = new BlockContext( $block, $context );

			if ( $block_context->matches() ) {
				return true;
			}
		}

		return false;
	}
}
