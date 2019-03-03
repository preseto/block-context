<?php

namespace Preseto\BlockContextTests\Unit;

use Mockery;
use Preseto\BlockContext\BlockContext;

class BlockContextTest extends TestCase {

	/**
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

}
