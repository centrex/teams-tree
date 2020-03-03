<?php
require_once __DIR__ . '/../class-teams-plugin.php';

class Teams_Plugin_Test extends WP_UnitTestCase {
	public function test_ui_is_given_default_tree_when_option_is_missing() {
		$plugin = new TEams_Plugin();
		$plugin->scripts_in_footer();
		$tree_json_prefix = '{"id":1,"name":"National League","emoji":"\u26be","parent_id":null,"children":[';
		$this->expectOutputContains( $tree_json_prefix );
	}

	public function test_ui_uses_tree_from_option() {
		$plugin = new Teams_Plugin();
		// WordPress automatically resets all database changes we make, so we don't need to undo them
		update_option( $plugin::OPTION_NAME, [ [ 'id' => 1, 'name' => 'National League', 'emoji' => '⚾', 'parent_id' => null ] ] );
		$plugin->scripts_in_footer();
		$tree_json_prefix = '{"id":1,"name":"National League","emoji":"\u26be","parent_id":null,"children":[';
		$this->expectOutputContains( $tree_json_prefix );
	}

	private function expectOutputContains( $substring ) {
		$this->expectOutputRegex( '/' . preg_quote( $substring ) . '/' );
	}
}
