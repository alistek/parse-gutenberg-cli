<?php

namespace ParseGutenbergCLI\Commands;

use WP_CLI;

class Parse extends \WP_CLI_Command {

	/**
	 * Attempts to parse a Gutenberg Block into a table format for viewing
	 *
	 * ## OPTIONS
	 *
	 * <ids>
	 * : (optional) A list of post IDs
	 *
	 * ## EXAMPLES
	 *
	 *   wp gutenberg parse --ids=1,2,3
	 *
	 * @synopsis [--ids=<post_ids>]
	 *
	 * @param array $args
	 * @param array $assoc_args
	 */

	public function __invoke( $args = array(), $assoc_args = array() ) {
		$count = 0;

		if ( isset( $assoc_args['ids'] ) ) {
			$post_ids = array_map('intval', explode(',', $assoc_args['ids'] ) );
		} else {
			$all_posts = new \WP_Query(
				array(
					'post_type'      => 'post',
					'post_status'    => 'publish',
					'fields'         => 'ids',
					'posts_per_page' => -1,
				)
			);

			$post_ids = $all_posts->posts;
		}

		$formatted = Array();

		foreach( $post_ids as $post_id ) {
			$post    = get_post( $post_id );
			$content = apply_filters( 'the_content', $post->post_content );
			$parsed  = parse_blocks( $content );

			foreach ( $parsed[0] as $block ) {
				$list = Array();

				foreach ($block[0]->attrs as $key => $value) {
					$list[] = "$key ($value)";
				}

				$object = array(
					"Name"       => $block[0]->block_name,
					"Attributes" => implode(', ',$list)
				);

				$formatted[] = $object;
			}
		}

		WP_CLI\Utils\format_items( 'table', $formatted, array( 'Name', 'Attributes' ) );
	}
}

WP_CLI::add_command( 'gutenberg parse', __NAMESPACE__ . '\\Parse' );