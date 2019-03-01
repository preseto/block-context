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

	public function matches( $block, $contexts = [] ) {
		if ( empty( $context ) ) {
			$context = $this->contexts;
		}

		foreach ( $this->contexts as $context ) {
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
		$id_prefixed = $this->context_id_prefixed( $context->id() );
		$attributes = $block->attributes();

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
