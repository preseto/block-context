<?php

namespace Preseto\BlockContextTests;

use Preseto\BlockContext\Block;
use Preseto\BlockContext\BlockContext;
use Preseto\BlockContext\BlockContextPlugin;
use Preseto\BlockContext\Contexts\Context;
use Preseto\BlockContext\Contexts\ContextRule;
use Preseto\BlockContext\Contexts\UserLoggedIn;
use Preseto\BlockContext\Plugin;

class BlockContextTest extends \WP_UnitTestCase {

	/**
	 * Get a context instance with a custom ID.
	 */
	protected function context_with_id( string $id ): Context {
		return new class( $id ) extends Context {

			private string $id;

			public function __construct( string $id ) {
				$this->id = $id;
			}

			public function id() {
				return $this->id;
			}

			public function match( $state ) {
				return null;
			}
		};
	}

	public function test_attribute_key_prefixes_and_strips_separators() {
		$block_context = new BlockContext(
			new Block( [] ),
			$this->context_with_id( 'context-id' )
		);

		$this->assertSame(
			'blockContextContextid',
			$block_context->attribute_key(),
			'context id is prefixed and stripped of separators'
		);
	}

	public function test_context_value_read_from_block_attributes() {
		$block = new Block(
			[
				'attrs' => [
					'blockContextContextRule' => 'show',
				],
			]
		);

		$block_context = new BlockContext( $block, new ContextRule() );

		$this->assertSame(
			'show',
			$block_context->value(),
			'context value is read from the block attribute matching the context id'
		);
	}

	public function test_context_value_null_when_attribute_missing() {
		$block_context = new BlockContext( new Block( [] ), new ContextRule() );

		$this->assertNull(
			$block_context->value(),
			'missing block attribute returns null'
		);
	}

	public function test_matches_false_without_context_value() {
		$block_context = new BlockContext( new Block( [] ), new UserLoggedIn() );

		$this->assertFalse(
			$block_context->matches(),
			'block without the context attribute never matches'
		);
	}

	public function test_user_logged_in_context_matches_logged_out_visitor() {
		wp_set_current_user( 0 );

		$block = new Block(
			[
				'attrs' => [
					'blockContextUserLoginState' => 'logged-out',
				],
			]
		);

		$block_context = new BlockContext( $block, new UserLoggedIn() );

		$this->assertTrue(
			$block_context->matches(),
			'logged-out visitor matches the logged-out context'
		);
	}

	public function test_user_logged_in_context_matches_logged_in_user() {
		wp_set_current_user( self::factory()->user->create( [ 'role' => 'subscriber' ] ) );

		$block = new Block(
			[
				'attrs' => [
					'blockContextUserLoginState' => 'logged-in',
				],
			]
		);

		$block_context = new BlockContext( $block, new UserLoggedIn() );

		$this->assertTrue(
			$block_context->matches(),
			'logged-in user matches the logged-in context'
		);
	}

	public function test_block_hidden_when_show_rule_does_not_match() {
		wp_set_current_user( 0 );

		$plugin = new BlockContextPlugin( new Plugin( dirname( __DIR__, 2 ) . '/block-context.php' ) );

		$block = new Block(
			[
				'attrs' => [
					'blockContextContextRule' => 'show',
					'blockContextUserLoginState' => 'logged-in',
				],
			]
		);

		$this->assertFalse(
			$plugin->block_is_visible( $block ),
			'block set to show for logged-in users is hidden from logged-out visitors'
		);
	}

	public function test_block_visible_when_hide_rule_does_not_match() {
		wp_set_current_user( 0 );

		$plugin = new BlockContextPlugin( new Plugin( dirname( __DIR__, 2 ) . '/block-context.php' ) );

		$block = new Block(
			[
				'attrs' => [
					'blockContextContextRule' => 'hide',
					'blockContextUserLoginState' => 'logged-in',
				],
			]
		);

		$this->assertTrue(
			$plugin->block_is_visible( $block ),
			'block set to hide for logged-in users is visible to logged-out visitors'
		);
	}

	public function test_block_visible_without_context_rule() {
		$plugin = new BlockContextPlugin( new Plugin( dirname( __DIR__, 2 ) . '/block-context.php' ) );

		$this->assertTrue(
			$plugin->block_is_visible( new Block( [] ) ),
			'block without any context settings is always visible'
		);
	}
}
