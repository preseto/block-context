<?php

namespace Preseto\BlockContext;

class BlockContexts {

	protected $contexts = [];

	public function __construct( $contexts = [] ) {
		if ( ! empty( $contexts ) ) {
			foreach ( $contexts as $context ) {
				$this->add( $context );
			}
		}
	}

	public function all() {
		return $this->contexts;
	}

	public function add( $context ) {
		$this->contexts[ $context->id() ] = $context;
	}

	public function get( $id ) {
		if ( isset( $this->contexts[ $id ] ) ) {
			return $this->contexts[ $id ];
		}

		return null;
	}

}
