<?php
/**
 * Plugin Name: Parse Gutenberg CLI
 * Plugin URI: https://www.listekconsulting.com/
 * Description: A set of WP-CLI commands to parse Gutenberg blocks
 * Version: 0.1
 * Author: Adam Listek
 * Author URI: https://www.listekconsulting.com/
 * Text Domain: parse-gutenberg-cli
 *
*/

// Only load this plugin once and bail if WP CLI is not present
if (  ! defined( 'WP_CLI' ) ) {
	return;
}

define( 'PARSE_GUTENBERG_CLI_COMMANDS_PATH', 'inc/commands/' );

require_once( PARSE_GUTENBERG_CLI_COMMANDS_PATH . 'class-parse.php' );