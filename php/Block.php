<?php

namespace Preseto\BlockContext;

class Block {

	const CONTEXT_ENABLE = 'blockContextEnable';

	protected $block;

	protected $contexts;

	public function __construct( $block, $contexts ) {
		$this->block = $block;
		$this->contexts = $contexts;
	}

	public function attributes() {
		return array_merge(
			[
				self::CONTEXT_ENABLE => false,
			],
			$this->block['attrs']
		);
	}

	public function attribute( $key ) {
		$attributes = $this->attributes();

		if ( isset( $attributes[ $key ] ) ) {
			return $attributes[ $key ];
		}

		return null;
	}

	public function is_context_enabled() {
		return ( ! empty( $this->attribute( self::CONTEXT_ENABLE ) ) );
	}

	public function is_hidden() {
		return ( $this->is_context_enabled() && $this->contexts->match( $this->attributes() ) );
	}

}
