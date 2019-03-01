<?php

namespace Preseto\BlockContext;

class BlockContext {

	const CONTEXT_ID_PREFIX = 'blockContext';

	public function __construct( $block, $context ) {
		$this->block = $block;
		$this->context = $context;
	}

	public function matches() {
		$value = $this->value();

		return ( null !== $value && $this->context->match( $value ) );
	}

	public function value() {
		return $this->block->attribute( $this->attribute_key() );
	}

	protected function attribute_key() {
		$id = str_replace( [ '-', '_' ], '', $this->context->id() );

		return sprintf(
			'%s%s',
			self::CONTEXT_ID_PREFIX,
			ucwords( $id )
		);
	}

}
