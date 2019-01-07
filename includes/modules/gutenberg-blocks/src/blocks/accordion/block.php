<?php

/**
 * Enqueue frontend script for content toggle block
 *
 * @return void
 */
function gutenberg_blocks_content_toggle_add_frontend_assets() {
	wp_enqueue_script(
		'gutenberg-blocks-content-toggle-front-script',
		plugins_url( 'accordion/front.js', dirname( __FILE__ ) ),
		array( 'jquery' ),
		'1.0',
		true
	);
}

add_action( 'wp_enqueue_scripts', 'gutenberg_blocks_content_toggle_add_frontend_assets' );
