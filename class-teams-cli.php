<?php
require_once __DIR__ . '/class-teams-plugin.php';

class Teams_CLI {
	/**
	 * Sets the teams in the plugin to a pre-defined value.
	 *
	 * WARNING! This will permanently erase the current teams list!
	 *
	 * ## OPTIONS
	 * --type=<sample|big|custom>
	 * : What type of teams to install (sample, big, custom)
	 * • sample: the small teams list that is installed by default
	 * • big: automatically generated teams list with 3 sub-teams of each team and 9 levels great for performance tests
	 * • custom: configure number of sub-teams and levels with the options below
	 *
	 * [--levels]
	 * : How many levels deep should the custom teams list go
	 * [--sub-teams]
	 * : How many sub-teams should each team have in a custom teams list
	 */
	function set( $args, $assoc_args ) {
		switch( $assoc_args['type'] ) {
			case 'sample':
				$tree = $this->get_sample( $assoc_args );
				break;
			case 'big':
				$tree = $this->get_big( $assoc_args );
				break;
			case 'custom':
				$tree = $this->get_custom( $assoc_args );
				break;
			default:
				WP_CLI::error( 'Invalid teams list type "' . $assoc_args['type'] . '". Try sample, custom, or big.' );
		}
		if ( get_option( Teams_Plugin::OPTION_NAME ) ) {
			WP_CLI::log( 'Deleting the current etams list first…' );
			$deleted = delete_option( Teams_Plugin::OPTION_NAME );
			if ( ! $deleted ) {
				WP_CLI::error( 'Error setting the teams, delete_option failed' );
			}
		}
		WP_CLI::log( 'Setting the new teams list…' );
		$updated = update_option( Teams_Plugin::OPTION_NAME, $tree );
		if ( ! $updated ) {
			WP_CLI::error( 'Error setting the teams, update_option failed' );
		}
		WP_CLI::success( 'Done!' );
	}

	private function get_sample( $assoc_args ) {
		return Teams_Plugin::DEFAULT_TEAMS;
	}

	private function get_big( $assoc_args ) {
		return $this->get_custom( [ 'levels' => 9, 'sub-teams' => 3 ] );
	}

	private function get_custom( $assoc_args ) {
		if ( ! isset ( $assoc_args['levels'] ) || ! isset( $assoc_args[ 'sub-teams' ] ) ) {
			WP_CLI::error( 'Both --levels and --sub-teams must be specified for a custom teams' );
		}
		return $this->generate_teams( $assoc_args['levels'], $assoc_args['sub-teams'] );
	}

	private function generate_teams( $levels, $sub_teams ) {
		$flat_tree = [ 1 => [ 'id' => 1, 'parent_id' => null, 'emoji' => '⚾', 'name' => 'National League' ] ];
		$next_id = 2;
		$previous_level = [ 1 ];
		for( $level = 0; $level < $levels - 1; $level++ ) {
			$this_level = [];
			foreach( $previous_level as $parent_id ) {
				for ( $sub_team = 0; $sub_team < $sub_teams; $sub_team++ ) {
					$id = $next_id++;
					$flat_tree[$id] = [ 'id' => $id, 'parent_id' => $parent_id, 'emoji' => '⚾', 'name' => "American League ($id)" ];
					$this_level[] = $id;
				}
			}
			$previous_level = $this_level;
		}
		return $flat_tree;
	}
}

