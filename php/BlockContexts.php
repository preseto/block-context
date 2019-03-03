<?php

namespace Preseto\BlockContext;

/**
 * A repository of all block contexts.
 */
class BlockContexts {

	/**
	 * Store all contexts.
	 *
	 * @var array
	 */
	protected $contexts = [];

	/**
	 * Setup a repository.
	 *
	 * @param array $contexts Contexts to include by default.
	 */
	public function __construct( $contexts = [] ) {
		if ( ! empty( $contexts ) ) {
			foreach ( $contexts as $context ) {
				$this->add( $context );
			}
		}
	}

	/**
	 * Return all contexts.
	 *
	 * @return array
	 */
	public function all() {
		return $this->contexts;
	}

	/**
	 * Add a context.
	 *
	 * @param Preseto\BlockContext\BlockContext $context Block Context to add.
	 */
	public function add( $context ) {
		$this->contexts[ $context->id() ] = $context;
	}

	/**
	 * Get context by ID.
	 *
	 * @param  string $id Block context ID.
	 *
	 * @return Preseto\BlockContext\BlockContext|null
	 */
	public function get( $id ) {
		if ( isset( $this->contexts[ $id ] ) ) {
			return $this->contexts[ $id ];
		}

		return null;
	}

}
