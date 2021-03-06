<?php

namespace Preseto\BlockContextTests\Unit;

use Mockery;
use Preseto\BlockContext\BlockContext;

/**
 * Core block and context related tests.
 */
class BlockContextTest extends TestCase {

	/**
	 * Can extract context attribute value.
	 *
	 * @covers Preseto\BlockContext\BlockContext::value
	 */
	public function test_context_value() {
		$block = Mockery::mock( 'block' );
		$block->shouldReceive( 'attribute' )
			->once()
			->andReturn( 'block-context-value' );

		$context = Mockery::mock( 'context' );
		$context->shouldReceive( 'id' )
			->once()
			->andReturn( 'block-context-id' );

		$block_context = new BlockContext( $block, $context );

		$this->assertEquals( 'block-context-value', $block_context->value() );
	}

	/**
	 * Can format context attribute ID.
	 *
	 * @covers Preseto\BlockContext\BlockContext::attribute_key
	 */
	public function test_attribute_key() {
		$context = Mockery::mock( 'context' );
		$context->shouldReceive( 'id' )
			->once()
			->andReturn( 'context-id' );

		$block = Mockery::mock( 'block' );

		$block_context = new BlockContext( $block, $context );

		$this->assertEquals( 'blockContextContextid', $block_context->attribute_key() );
	}

}
