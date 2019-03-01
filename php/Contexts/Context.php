<?php

namespace Preseto\BlockContext\Contexts;

abstract class Context {

	abstract public function id();

	abstract public function match( $state );

}
