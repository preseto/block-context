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
	abstract public function id(): string;

	/**
	 * If the current request matches the rule.
	 *
	 * @param string $state Current context rule state.
	 */
	abstract public function match( string $state ): ?bool;
}
