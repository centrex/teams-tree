<?php

require_once __DIR__ . '/class-teams-tree.php';
require_once __DIR__ . '/class-teams-sharing.php';

/**
 * Responsible for the WordPress plumbing -- getting the page running, output of JS
 */
class Teams_Plugin {

	public const OPTION_NAME = 'teams-tree';
	public const DEFAULT_TEAMS = [
		[ 'id' => 1, 'name' => 'National League', 'emoji' => '⚾' ,'parent_id' => null ],
		[ 'id' => 2, 'name' => 'Cincinnati Reds', 'emoji' => '⚾',  'parent_id' => 1 ],
		[ 'id' => 3, 'name' => 'St. Louis Cardinals', 'emoji' => '😌', 'parent_id' => 1 ],
// Reds Players
		[ 'id' => 4, 'name' => 'Tejay Antone', 'position' => 'Pitcher', 'number' => 70, 'emoji' => '⛹️', 'parent_id' => 2 ],
		[ 'id' => 5, 'name' => 'Trevor Bauer', 'position' => 'Pitcher', 'number' => 27, 'emoji' => '⛹️', 'parent_id' => 2 ],
		[ 'id' => 6, 'name' => 'Tucker Barnhart', 'position' => 'Catcher', 'number' => 16, 'emoji' => '⛹️', 'parent_id' => 2 ],
// Cardinals Players
		[ 'id' => 7, 'name' => 'John Brebbia', 'position' => 'Pitcher', 'number' => 60, 'emoji' => '⛹️', 'parent_id' => 3 ],
		[ 'id' => 8, 'name' => 'Genesis Cabrera', 'position' => 'Pitcher', 'number' => 92, 'emoji' => '⛹️', 'parent_id' => 3 ],
		[ 'id' => 9, 'name' => 'Andrew Knizner', 'position' => 'Catcher', 'number' => 7, 'emoji' => '⛹️', 'parent_id' => 3 ],
	];

	public function __construct() {
		$this->sharing = new Teams_Sharing();
	}

	/**
	 * Registers the initial hooks to get the plugin going.
	 */
	public function add_init_action() {
		add_action( 'init', array( $this, 'init' ) );
	}

	/**
	 * Executed on the "init" WordPress action -- initializes the bulk
	 * of our hooks
	 */
	public function init() {
		$page_hook_suffix = null;

		/* Registers the UI for "Teams" page linked from the main
		 */
		add_action( 'admin_menu', function() use ( &$page_hook_suffix ) {
			$position = 2; // this means the second one from the top
			$page_hook_suffix = add_menu_page( 'Teams List', 'Teams List', 'publish_posts', 'teams', array( $this, 'teams_controller' ), 'dashicons-networking', $position );
			add_action( "admin_footer-{$page_hook_suffix}", [ $this, 'scripts_in_footer' ] );
		} );

		/**
		 * Handles routing for the publicly shared page -- only triggered when
		 * we have the right arguments in the URL
		 */
		if ( $this->sharing->does_url_have_valid_key() ) {
			$this->teams_controller();
			$this->scripts_in_footer();
			exit;
		}
	}

	/**
	 * Outputs script tags right before closing </body> tag
	 */
	public function scripts_in_footer() {
		$tree = new Teams_Tree( get_option( self::OPTION_NAME, self::DEFAULT_TEAMS ) );
		$tree_js = $tree->get_nested_tree_js();
		$ui_js_url = plugins_url( 'ui.js', __FILE__ );
		$framework_js_url = plugins_url( 'framework.js', __FILE__ );
		$secret_url = $this->sharing->url();
		require __DIR__ . '/admin-page-inline-script.php';
	}

	/**
	 * Callback for add_menu_page() -- outputs the HTML for our teams UI
	 */
	public function teams_controller() {
		require __DIR__ . '/admin-page-template.php';
	}
}
