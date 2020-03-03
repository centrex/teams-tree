<?php
require_once __DIR__ . '/../class-teams-tree.php';

class Teams_Tree_Test extends WP_UnitTestCase {

	public function test_empty_list_returns_null() {
		$this->assertEquals( null, ( new Teams_Tree( [] ) )->get_nested_tree() );
	}

	public function test_only_root_returns_single_node() {
		$only_root = [ [ 'id' => 1, 'name' => 'root', 'parent_id' => null ] ];
		$expected = array_merge( $only_root[0], [ 'children' => [] ] );
		$this->assertEquals( $expected, ( new Teams_Tree( $only_root ) )->get_nested_tree() );
	}

	public function test_three_levels_deep_structure() {
		$list_of_teams = [
		[ 'id' => 1, 'name' => 'National League', 'emoji' => '⚾' ,'parent_id' => null ],
		[ 'id' => 2, 'name' => 'Cincinnati Reds', 'emoji' => '⚾',  'parent_id' => 1 ],
		[ 'id' => 3, 'name' => 'St. Louis Cardinals', 'emoji' => '⚾', 'parent_id' => 1 ],
// Reds Players
		[ 'id' => 4, 'name' => 'Tejay Antone', 'position' => 'Pitcher', 'number' => 70, 'emoji' => '⛹️', 'parent_id' => 2 ],
		[ 'id' => 5, 'name' => 'Trevor Bauer', 'position' => 'Pitcher', 'number' => 27, 'emoji' => '⛹️', 'parent_id' => 2 ],
		[ 'id' => 6, 'name' => 'Tucker Barnhart', 'position' => 'Catcher', 'number' => 16, 'emoji' => '⛹️', 'parent_id' => 2 ],
// Cardinals Players
		[ 'id' => 7, 'name' => 'John Brebbia', 'position' => 'Pitcher', 'number' => 60, 'emoji' => '⛹️', 'parent_id' => 3 ],
		[ 'id' => 8, 'name' => 'Genesis Cabrera', 'position' => 'Pitcher', 'number' => 92, 'emoji' => '⛹️', 'parent_id' => 3 ],
		[ 'id' => 9, 'name' => 'Andrew Knizner', 'position' => 'Catcher', 'number' => 7, 'emoji' => '⛹️', 'parent_id' => 3 ],
	];
		$expected = [ 'id' => 1, 'name' => 'National League', 'emoji' => '⚾' ,'parent_id' => null, 'children' => [
			[ 'id' => 2, 'name' => 'Cincinnati Reds', 'emoji' => '⚾',  'parent_id' => 1, 'children' => [	
				[ 'id' => 4, 'name' => 'Tejay Antone', 'position' => 'Pitcher', 'number' => 70, 'emoji' => '⛹️', 'parent_id' => 2, 'children' => [] ],
				[ 'id' => 5, 'name' => 'Trevor Bauer', 'position' => 'Pitcher', 'number' => 27, 'emoji' => '⛹️', 'parent_id' => 2, 'children' => [] ],
				[ 'id' => 6, 'name' => 'Tucker Barnhart', 'position' => 'Catcher', 'number' => 16, 'emoji' => '⛹️', 'parent_id' => 2, 'children' => [] ],
			] ],
			[ 'id' => 3, 'name' => 'St. Louis Cardinals', 'emoji' => '⚾', 'parent_id' => 1, 'children' => [
				[ 'id' => 7, 'name' => 'John Brebbia', 'position' => 'Pitcher', 'number' => 60, 'emoji' => '⛹️', 'parent_id' => 3, 'children' => [] ],
				[ 'id' => 8, 'name' => 'Genesis Cabrera', 'position' => 'Pitcher', 'number' => 92, 'emoji' => '⛹️', 'parent_id' => 3, 'children' => [] ],
				[ 'id' => 9, 'name' => 'Andrew Knizner', 'position' => 'Catcher', 'number' => 7, 'emoji' => '⛹️', 'parent_id' => 3, 'children' => [] ],
			] ],
		] ];

		$this->assertEquals( $expected, ( new Teams_Tree( $list_of_teams ) )->get_nested_tree() );
	}
}
