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
	public function id() {
		return 'ContextRule';
	}

	/**
	 * If the current request matches the rule.
	 *
	 * @param  string $state Context setting.
	 *
	 * @return null
	 */
	public function match( $state ) {
		return null;
	}

}
