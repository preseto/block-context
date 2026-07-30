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
	protected array $contexts = [];

	/**
	 * Setup a repository.
	 *
	 * @param array $contexts Contexts to include by default.
	 */
	public function __construct( array $contexts = [] ) {
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
	public function all(): array {
		return $this->contexts;
	}

	/**
	 * Add a context.
	 *
	 * @param \Preseto\BlockContext\Contexts\Context $context Block Context to add.
	 */
	public function add( Contexts\Context $context ): void {
		$this->contexts[ $context->id() ] = $context;
	}

	/**
	 * Get context by ID.
	 *
	 * @param  string $id Block context ID.
	 *
	 * @return \Preseto\BlockContext\Contexts\Context|null
	 */
	public function get( string $id ): ?Contexts\Context {
		if ( isset( $this->contexts[ $id ] ) ) {
			return $this->contexts[ $id ];
		}

		return null;
	}
}
