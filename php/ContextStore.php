<?php

namespace Preseto\BlockContext;

class ContextStore {

	/**
	 * Post meta key used for storing the block context.
	 */
	const KEY_CONTEXT_META = 'block_context';

	/**
	 * Post type string used for storing the block context.
	 *
	 * @var string
	 */
	protected $post_type;

	public function __construct( $post_type ) {
		$this->post_type = $post_type;
	}

	public function init() {
		return register_post_type(
			$this->post_type,
			[
				'public' => false,
				'show_in_rest' => true,
				'rest_controller_class' => __NAMESPACE__ . '\\ContextRestController',
			]
		);
	}

	public function object() {
		return get_post_type_object( $this->post_type );
	}

	protected function get_context_post_id( $block_id ) {
		$context_posts = get_posts(
			[
				'fields' => 'ids',
				'post_type' => $this->post_type,
				'post_name' => $block_id,
				'posts_per_page' => 1,
				'order' => 'ASC', // Show the first ever created context just in case.
			]
		);

		return array_pop( $context_posts );
	}

	protected function context_by_post_id( $post_id ) {
		if ( ! empty( $post_id ) ) {
			return get_post_meta( $post_id, self::KEY_CONTEXT_META, true );
		}

		return null;
	}

	public function get_post_block_contexts( $post_id ) {
		$contexts = [];

		$context_posts = get_posts(
			[
				'fields' => 'ids',
				'post_type' => $this->post_type,
				'parent' => intval( $post_id ),
			]
		);

		if ( $context_posts->have_posts() ) {
			foreach ( $context_posts->posts as $context_post_id ) {
				$contexts[ $context_post_id ] = $this->context_by_post_id( $context_post_id );
			}
		}

		return $contexts;
	}

	public function get( $block_id ) {
		$context_post_id = $this->get_context_post_id( $block_id );

		if ( ! empty( $context_post_id ) ) {
			return $this->context_by_post_id( $context_post_id );
		}

		return null;
	}

	public function add( $context ) {
		$post_id = $this->get_context_post_id( $context->block_id() );

		if ( empty( $post_id ) ) {
			$post_id = wp_insert_post(
				[
					'post_type' => $this->post_type,
					'post_name' => $context->block_id(),
					'post_parent' => $context->post_id(),
					'post_status' => 'publish',
				]
			);
		}

		return update_post_meta( $post_id, self::KEY_CONTEXT_META, $context->serialize() );
	}

}
