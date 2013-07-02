<?php
/**
 * Compatibility settings and functions for Jetpack.
 * See http://jetpack.me/support/infinite-scroll/
 *
 * @package Duster
 */

/**
 * Add theme support for infinity scroll.
 */
function duster_infinite_scroll_init() {
	add_theme_support( 'infinite-scroll', array(
		'container'      => 'content',
		'footer_widgets' => array( 'sidebar-3', 'sidebar-4', 'sidebar-5' ),
		'footer'         => 'page',
	) );
}
add_action( 'init', 'duster_infinite_scroll_init' );
