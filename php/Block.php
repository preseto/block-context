<?php

namespace Preseto\BlockContext;

/**
 * Editor block.
 */
class Block {

	/**
	 * Block settings from WP.
	 *
	 * @var array
	 */
	protected $block;

	/**
	 * Setup the block.
	 *
	 * @param array $block Block settings from WP.
	 */
	public function __construct( $block ) {
		$this->block = $block;
	}

	/**
	 * Get block attributes.
	 *
	 * @return array
	 */
	public function attributes() {
		if ( isset( $this->block['attrs'] ) && is_array( $this->block['attrs'] ) ) {
			return $this->block['attrs'];
		}

		return [];
	}

	/**
	 * Get a specific block attribute by key.
	 *
	 * @param  string $key Attribute key.
	 *
	 * @return mixed Return `null` if attribute not found.
	 */
	public function attribute( $key ) {
		$attributes = $this->attributes();

		if ( isset( $attributes[ $key ] ) ) {
			return $attributes[ $key ];
		}

		return null;
	}

}
