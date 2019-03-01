<?php

namespace Preseto\BlockContext;

class BlockContexts {

	const CONTEXT_ID_PREFIX = 'blockContext';

	protected $contexts = [];

	public function __construct( $contexts = [] ) {
		if ( ! empty( $contexts ) ) {
			foreach ( $contexts as $context ) {
				$this->add( $context );
			}
		}
	}

	public function add( $context ) {
		$this->contexts[ $context->id() ] = $context;
	}

	public function match( $attributes ) {
		foreach ( $this->contexts as $context ) {
			$context_attributes = $this->attributes_for_context( $context, $attributes );

			if ( null !== $context_attributes && $context->match( $context_attributes ) ) {
				return true;
			}
		}

		return false;
	}

	protected function attributes_for_context( $context, $attributes ) {
		$id_prefixed = $this->context_id_prefixed( $context->id() );

		if ( isset( $attributes[ $id_prefixed ] ) ) {
			return $attributes[ $id_prefixed ];
		}

		return null;
	}

	protected function context_id_prefixed( $id ) {
		$id = str_replace( [ '-', '_' ], '', $id );

		return sprintf(
			'%s%s',
			self::CONTEXT_ID_PREFIX,
			ucwords( $id )
		);
	}

}
