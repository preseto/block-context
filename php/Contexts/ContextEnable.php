<?php

namespace Preseto\BlockContext\Contexts;

class ContextEnable extends Context {

	public function id() {
		return 'Enable';
	}

	public function match( $state ) {
		return (bool) $state;
	}

}
