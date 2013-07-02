<?php
/**
 * Compatibility settings and functions for Jetpack.
 * See http://jetpack.me/support/infinite-scroll/
 *
 * @package Next_Saturday
 */

/**
 * Add theme support for infinity scroll.
 */
function next_saturday_infinite_scroll_init() {
	add_theme_support( 'infinite-scroll', array(
		'container' => 'content',
		'footer'    => 'wrapper',
	) );
}
add_action( 'init', 'next_saturday_infinite_scroll_init' );