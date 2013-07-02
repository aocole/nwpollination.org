<?php
/**
 * @package Dusk_To_Dawn
 */

if ( ! function_exists( 'dusktodawn_url_grabber' ) ) {
/**
 * Return the URL for the first link found in this post.
 *
 * @param string the_content Post content, falls back to current post content if empty.
 * @return string|bool URL or false when no link is present.
 */
function dusktodawn_url_grabber( $the_content = '' ) {
	if ( empty( $the_content ) )
		$the_content = get_the_content();
	if ( ! preg_match( '/<a\s[^>]*?href=[\'"](.+?)[\'"]/is', $the_content, $matches ) )
		return false;

	return esc_url_raw( $matches[1] );
}
} // if ( ! function_exists( 'dusktodawn_url_grabber' ) )

if ( ! function_exists( 'dusktodawn_audio_grabber' ) ) {
/**
 * Return the first audio file found for a post.
 *
 * @param int post_id ID for parent post
 * @return boolean|string Path to audio file
 */
function dusktodawn_audio_grabber( $post_id ) {
	$audio_attachments = get_children( array(
		'post_parent'    => $post_id,
		'post_status'    => 'inherit',
		'post_type'      => 'attachment',
		'post_mime_type' => 'audio',
		'order'          => 'ASC',
		'orderby'        => 'menu_order ID'
	) );

	if ( is_array( $audio_attachments ) )
		return current( $audio_attachments );

	return false;
}
} // if ( ! function_exists( 'dusktodawn_audio_grabber' ) )
