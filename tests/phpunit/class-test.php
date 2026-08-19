<?php

namespace Preseto\BlockContextTests;

class Test extends \WP_UnitTestCase {

	public function test_wp_loaded() {
		$this->assertTrue( function_exists( 'add_action' ), 'wp core is loaded' );
	}

	public function test_plugin_classes_autoloaded() {
		$this->assertTrue( class_exists( \Preseto\BlockContext\BlockContextPlugin::class ), 'plugin classes are autoloaded' );
	}
}
