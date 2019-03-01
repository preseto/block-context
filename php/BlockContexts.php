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

	public function get( $id ) {
		if ( isset( $this->contexts[ $id ] ) ) {
			return $this->contexts[ $id ];
		}

		return null;
	}

	public function matches( $block, $contexts = [] ) {
		if ( empty( $contexts ) ) {
			$contexts = $this->contexts;
		}

		foreach ( $contexts as $context ) {
			if ( $this->matches_context( $block, $context ) ) {
				return true;
			}
		}

		return false;
	}

	protected function matches_context( $block, $context ) {
		$context_attributes = $this->attributes_for_context( $block, $context );

		if ( null !== $context_attributes && $context->match( $context_attributes ) ) {
			return true;
		}

		return false;
	}

	protected function attributes_for_context( $block, $context ) {
		$attribute_key = $this->context_attribute_key( $context->id() );

		return $block->attribute( $attribute_key );
	}

	protected function context_attribute_key( $id ) {
		$id = str_replace( [ '-', '_' ], '', $id );

		return sprintf(
			'%s%s',
			self::CONTEXT_ID_PREFIX,
			ucwords( $id )
		);
	}

}
