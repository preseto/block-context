<?php

namespace Preseto\BlockContext\Contexts;

/**
 * Abstract block context.
 */
abstract class Context {

	/**
	 * Block ID.
	 *
	 * @var string
	 */
	abstract public function id();

	/**
	 * If the current request matches the rule.
	 *
	 * @var boolean|null
	 */
	abstract public function match( $state );

}
