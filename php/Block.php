<?php

namespace Preseto\BlockContext;

class Block {

	protected $id;

	protected $post_id;

	public function __construct( $id, $post_id ) {
		$this->id = $id;
		$this->post_id = $post_id;
	}

	public function id() {
		return $this->id;
	}

	public function post_id() {
		return $this->post_id;
	}

}
