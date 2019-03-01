<?php

namespace Preseto\BlockContext;

class Block {

	protected $block;

	public function __construct( $block ) {
		$this->block = $block;
	}

	public function attributes() {
		return $this->block['attrs'];
	}

	public function attribute( $key ) {
		$attributes = $this->attributes();

		if ( isset( $attributes[ $key ] ) ) {
			return $attributes[ $key ];
		}

		return null;
	}

}
