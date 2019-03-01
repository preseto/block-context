<?php

namespace Preseto\BlockContext\Contexts;

class ContextRule extends Context {

	public function id() {
		return 'ContextRule';
	}

	public function match( $state ) {
		return null;
	}

}
