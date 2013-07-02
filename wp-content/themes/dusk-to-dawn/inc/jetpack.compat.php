<?php
/**
 * Compatibility settings and functions for Jetpack from Automattic
 * See http://jetpack.me/support/infinite-scroll/
 *
 * @package Dusk to Dawn
 */


/**
 * Add support for Infinite Scroll.
 */
function dusktodawn_infinite_scroll_init() {
	add_theme_support( 'infinite-scroll', array(
		'container'      => 'content',
		'footer'         => 'main',
	) );
}
add_action( 'after_setup_theme', 'dusktodawn_infinite_scroll_init' );