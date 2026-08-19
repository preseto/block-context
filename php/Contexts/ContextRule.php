<?php

namespace Preseto\BlockContext\Contexts;

/**
 * The core visibility rule.
 */
class ContextRule extends Context {

	/**
	 * Context ID.
	 *
	 * @return string
	 */
	public function id(): string {
		return 'ContextRule';
	}

	/**
	 * If the current request matches the rule.
	 *
	 * @param  string $state Context setting.
	 *
	 * @return null
	 */
	public function match( string $state ): ?bool {
		return null;
	}
}
