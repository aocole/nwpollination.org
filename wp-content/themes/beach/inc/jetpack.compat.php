<?php
/**
 * Compatibility settings and functions for Jetpack from Automattic
 * See http://jetpack.me/support/infinite-scroll/
 *
 * @package Beach
 */


/**
 * Add theme support for infinity scroll
 */
function beach_infinite_scroll_init() {
	add_theme_support( 'infinite-scroll', array(
		'container' => 'content',
		'footer'    => 'primary',
	) );
}
add_action( 'init', 'beach_infinite_scroll_init' );