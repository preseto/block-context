<?php

namespace Preseto\BlockContext\Contexts;

/**
 * Abstract block context.
 */
abstract class Context {

	/**
	 * Block ID.
	 *
	 * @return string
	 */
	abstract public function id();

	/**
	 * If the current request matches the rule.
	 *
	 * @param mixed $state Current context rule state.
	 */
	abstract public function match( $state );

}
