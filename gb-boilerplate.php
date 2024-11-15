<?php
/**
 * Plugin Name:       Gb Boilerplate
 * Description:       Example block scaffolded with Create Block tool.
 * Requires at least: 6.6
 * Requires PHP:      7.2
 * Version:           0.1.0
 * Author:            The WordPress Contributors
 * License:           GPL-2.0-or-later
 * License URI:       https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain:       gb-boilerplate
 *
 * @package CreateBlock
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Registers the block using the metadata loaded from the `block.json` file.
 * Behind the scenes, it registers also all assets so they can be enqueued
 * through the block editor in the corresponding context.
 *
 * @see https://developer.wordpress.org/reference/functions/register_block_type/
 */
function create_block_gb_boilerplate_block_init() {
	// Define the blocks directory path.
	$blocks_dir = __DIR__ . '/build/blocks';

	// Ensure the directory exists.
	if ( ! is_dir( $blocks_dir ) ) {
		return;
	}

	// Scan the directory for block folders.
	$block_folders = scandir( $blocks_dir );

	foreach ( $block_folders as $folder ) {
		// Skip if it's not a valid folder.
		if ( $folder === '.' || $folder === '..' || ! is_dir( $blocks_dir . '/' . $folder ) ) {
			continue;
		}

		// Register the block using the folder path.
		$block_path = $blocks_dir . '/' . $folder;
		register_block_type( $block_path );
	}
}
add_action( 'init', 'create_block_gb_boilerplate_block_init' );


/**
 * Add a custom category for GB Bloilerplate with a light-colored SVG icon.
 *
 * @param array $categories Existing block categories.
 * @return array Updated block categories.
 */
function gb_boilerplate_add_custom_block_category( $categories ) {
	// Inline SVG icon with light blue color (#5DADE2).
	$svg_icon = '
		<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="20" height="20" fill="currentColor">
			<rect x="3" y="3" width="18" height="18" rx="2" ry="2"/>
			<path d="M8 8h8v8H8z" fill="#fff"/>
		</svg>
	';

	$custom_category = array(
		'slug'  => 'gb-boilerplate',
		'title' => __( 'GB Boilerplate', 'gb-boilerplate' ),
		'icon'  => $svg_icon, // Add the SVG icon here.
	);

	// Add the custom category to the beginning of the list.
	array_unshift( $categories, $custom_category );

	return $categories;
}
add_filter( 'block_categories_all', 'gb_boilerplate_add_custom_block_category' );
