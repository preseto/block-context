<?php

namespace Preseto\BlockContext;

class BlockContext {

    protected $block;

    public function __construct( $block ) {
        $this->block = $block;
    }

    public function block_id() {
        return $this->block->id();
    }

    public function post_id() {
        return $this->block->post_id();
    }

    public function serialize() {
        return []; // TODO: Replace with the actual context data.
    }

}
