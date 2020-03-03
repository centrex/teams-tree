<?php
/*
 * Plugin Name: Teams
 * Description: Simple UI to help making sense of teams and players
 * Version: 0.1
 */

require_once __DIR__ . '/class-teams-plugin.php';

if ( defined( 'WP_CLI' ) && WP_CLI ) {
	require_once __DIR__  . '/class-teams-cli.php';
	WP_CLI::add_command( 'teams', 'Teams_CLI' );
}

( new Teams_Plugin() )->add_init_action();
