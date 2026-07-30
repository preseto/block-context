<?php

namespace Preseto\BlockContext;

/**
 * Represents block in context.
 */
class BlockContext {

	/**
	 * Block attribute prefix.
	 *
	 * @var string
	 */
	const CONTEXT_ID_PREFIX = 'blockContext';

	/**
	 * Block instance.
	 *
	 * @var \Preseto\BlockContext\Block
	 */
	protected Block $block;

	/**
	 * Context rule instance.
	 *
	 * @var \Preseto\BlockContext\Contexts\Context
	 */
	protected Contexts\Context $context;

	/**
	 * Setup a block in context.
	 *
	 * @param \Preseto\BlockContext\Block            $block   Block.
	 * @param \Preseto\BlockContext\Contexts\Context $context Context rule.
	 */
	public function __construct( Block $block, Contexts\Context $context ) {
		$this->block = $block;
		$this->context = $context;
	}

	/**
	 * If the current request matches the context rule.
	 *
	 * @return boolean
	 */
	public function matches(): bool {
		$value = $this->value();

		return ( null !== $value && $this->context->match( $value ) );
	}

	/**
	 * Get the context setting.
	 *
	 * @return mixed
	 */
	public function value() {
		return $this->block->attribute( $this->attribute_key() );
	}

	/**
	 * Format the context attribute key.
	 *
	 * @return string
	 */
	public function attribute_key(): string {
		$id = str_replace( [ '-', '_' ], '', $this->context->id() );

		return sprintf(
			'%s%s',
			self::CONTEXT_ID_PREFIX,
			ucwords( $id )
		);
	}
}
