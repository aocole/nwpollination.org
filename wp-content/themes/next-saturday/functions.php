<?php
/**
 * @package Next_Saturday
 */

/**
 * Set the maximum content width of the normal content column.
 * This prevents large images from overrunning the sides of the column.
 */
if ( ! isset( $content_width ) )
	$content_width = 510;


/**
 * Tell WordPress to run next_saturday_setup() when the 'after_setup_theme' hook is run.
 */
function next_saturday_setup() {

	// Add default posts and comments RSS feed links to head
	add_theme_support( 'automatic-feed-links' );

	// This theme supports post formats.
	add_theme_support( 'post-formats', array( 'aside', 'chat', 'audio', 'image', 'quote', 'gallery', 'video', 'link' ) );

	// Make theme available for translation
	// Translations can be filed in the /languages/ directory
	load_theme_textdomain( 'next-saturday', get_template_directory() . '/languages' );

	// This theme uses wp_nav_menu() in one location.
	register_nav_menus( array(
		'primary' => __( 'Primary Menu', 'next-saturday' ),
	) );
}
// Action hook to do all the major theme setup stuff
add_action( 'after_setup_theme', 'next_saturday_setup' );

 // Load scripts
function next_saturday_scripts() {
	wp_enqueue_style( 'next-saturday', get_stylesheet_uri() );

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) )
		wp_enqueue_script( 'comment-reply' );
}
add_action( 'wp_enqueue_scripts', 'next_saturday_scripts' );

/**
 * Audio helper script.
 *
 * If an audio shortcode exists we will enqueue javascript
 * that replaces all non-supported audio player instances
 * with text links.
 *
 * @uses shortcode_exists();
 */
function next_saturday_audio_script() {
	if ( shortcode_exists( 'audio' ) )
		return;

	if ( ! is_singular() || has_post_format( 'audio' ) )
		wp_enqueue_script( 'next-saturday-audio', get_template_directory_uri() . '/js/audio.js', array(), '20130521' );
}
add_action( 'wp_enqueue_scripts', 'next_saturday_audio_script' );

/**
 * Setup the WordPress core custom background feature.
 *
 * Use add_theme_support to register support for WordPress 3.4+
 * as well as provide backward compatibility for previous versions.
 * Use feature detection of wp_get_theme() which was introduced
 * in WordPress 3.4.
 *
 * Hooks into the after_setup_theme action.
 */
function next_saturday_custom_background() {
	$args = array(
		'default-color' => '',
		'default-image' => '',
	);

	$args = apply_filters( 'next_saturday_custom_background_args', $args );

	if ( function_exists( 'wp_get_theme' ) ) {
		add_theme_support( 'custom-background', $args );
	} else {
		define( 'BACKGROUND_COLOR', $args['default-color'] );
		define( 'BACKGROUND_IMAGE', $args['default-image'] );
		add_custom_background();
	}
}
add_action( 'after_setup_theme', 'next_saturday_custom_background' );

/**
 * Register widgetized area and update sidebar with default widgets
 */
function next_saturday_widgets_init() {
	register_sidebar( array (
		'name'          => __( 'Default sidebar', 'next-saturday' ),
		'id'            => 'sidebar-1',
		'description'   => __( 'The primary widget area.', 'next-saturday' ),
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h1 class="widget-title">',
		'after_title'   => '</h1>',
	) );
}
// We should actually hook into 'widgets_init', but don't for child theme compat.
add_action( 'init', 'next_saturday_widgets_init' );

/**
 * Removes the default styles that are packaged with the Recent Comments widget.
 */
function next_saturday_remove_recent_comments_style() {
	global $wp_widget_factory;
	remove_action( 'wp_head', array( $wp_widget_factory->widgets['WP_Widget_Recent_Comments'], 'recent_comments_style' ) );
}
add_action( 'widgets_init', 'next_saturday_remove_recent_comments_style' );

/**
 * Prints HTML with meta information for the fancy display of the current post's month and day
 */
function next_saturday_entry_date() {
	printf( __( '<div class="entry-date-wrapper"><div class="entry-date"><p class="entry-day"><a href="%1$s" class="entry-date-link" title="%2$s" rel="bookmark">%3$s</a></p><p class="entry-month"><a href="%1$s" class="entry-date-link" title="%2$s" rel="bookmark">%4$s. &rsquo;%5$s</a></p></div><div class="entry-date-bottom"></div><div class="entry-date-shadow"></div></div>', 'next-saturday' ),
		esc_url( get_permalink() ),
		esc_attr( get_the_time() ),
		esc_attr( get_the_time( 'd' ) ),
		esc_attr( get_the_time( 'M' ) ),
		esc_attr( get_the_time( 'y' ) )
	);
}

/**
 * Prints HTML with meta information for the current post (category, tags and permalink).
 */
function next_saturday_entry_meta() {
	$tag_list = get_the_tag_list( '', ', ' );
	if ( $tag_list ) {
		$posted_in = __( '<span class="by-author"> <span class="sep"> Posted by </span> <span class="author vcard"><a class="url fn n" href="%3$s" title="%4$s" rel="author">%5$s</a></span></span>. <span class="posted-in">Categories: %1$s. Tags: %2$s. </span>', 'next-saturday' );
	} elseif ( is_object_in_taxonomy( get_post_type(), 'category' ) ) {
		$posted_in = __( '<span class="by-author"> <span class="sep"> Posted by </span> <span class="author vcard"><a class="url fn n" href="%3$s" title="%4$s" rel="author">%5$s</a></span></span>. <span class="posted-in">Categories: %1$s.</span>', 'next-saturday' );
	}
	// Prints the string, replacing the placeholders.
	printf(
		$posted_in,
		get_the_category_list( ', ' ),
		$tag_list,
		esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ),
		esc_attr( sprintf( __( 'View all posts by %s', 'next-saturday' ), get_the_author() ) ),
		esc_html( get_the_author() )
	);
}

/**
 * Display navigation to next/previous pages when applicable
 */
function next_saturday_content_nav( $nav_id ) {
	global $wp_query;

	if ( $wp_query->max_num_pages > 1 ) : ?>
	<nav id="<?php echo $nav_id; ?>">
		<h3 class="assistive-text"><?php _e( 'Post navigation', 'next-saturday' ); ?></h3>
		<span class="nav-previous"><?php next_posts_link( __( '<span class="meta-nav">&larr;</span> Older <span>posts</span>', 'next-saturday' ) ); ?></span>
		<span class="nav-next"><?php previous_posts_link( __( 'Newer <span>posts</span> <span class="meta-nav">&rarr;</span>', 'next-saturday' ) ); ?></span>
	</nav><!-- #<?php echo $nav_id; ?> -->
	<?php endif;
}

/**
 * Template for comments and pingbacks.
 *
 * Used as a callback by wp_list_comments() for displaying the comments.
 *
 */
function next_saturday_comment( $comment, $args, $depth ) {
	$GLOBALS['comment'] = $comment;
	switch ( $comment->comment_type ) :
		case 'pingback' :
		case 'trackback' :
	?>
	<li class="pingback">
		<p><?php _e( 'Pingback:', 'next-saturday' ); ?> <?php comment_author_link(); ?><?php edit_comment_link( __( '(Edit)', 'next-saturday' ), ' ' ); ?></p>
	<?php
			break;
		default :
	?>
	<li <?php comment_class(); ?> id="li-comment-<?php comment_ID(); ?>">
		<article id="comment-<?php comment_ID(); ?>" class="comment">
			<footer class="comment-meta">
				<div class="comment-author vcard">
					<?php
						$avatar_size = 50;
						if ( '0' != $comment->comment_parent )
							$avatar_size = 39;

						echo get_avatar( $comment, $avatar_size );

						/* translators: 1: comment author, 2: date and time */
						printf( __( '%1$s on %2$s <span class="says">said:</span>', 'next-saturday' ),
							sprintf( '<span class="fn">%s</span>', get_comment_author_link() ),
							sprintf( '<a href="%1$s"><time pubdate datetime="%2$s">%3$s</time></a>',
								esc_url( get_comment_link( $comment->comment_ID ) ),
								get_comment_time( 'c' ),
								/* translators: 1: date, 2: time */
								sprintf( __( '%1$s at %2$s', 'next-saturday' ), get_comment_date(), get_comment_time() )
							)
						);
					?>

					<?php edit_comment_link( __( '[Edit]', 'next-saturday' ), ' ' ); ?>
				</div><!-- .comment-author .vcard -->

				<?php if ( $comment->comment_approved == '0' ) : ?>
					<em class="comment-awaiting-moderation"><?php _e( 'Your comment is awaiting moderation.', 'next-saturday' ); ?></em>
					<br />
				<?php endif; ?>

			</footer>

			<div class="comment-content"><?php comment_text(); ?></div>

			<div class="reply">
				<?php comment_reply_link( array_merge( $args, array( 'reply_text' => __( 'Reply &darr;', 'next-saturday' ), 'depth' => $depth, 'max_depth' => $args['max_depth'] ) ) ); ?>
			</div><!-- .reply -->
		</article><!-- #comment-## -->

	<?php
			break;
	endswitch;
}

/**
 * Filter the_content for post formats, and add extra presentational markup as needed.
 *
 * @param string the_content
 * @return string Updated content with extra markup.
 */
function next_saturday_the_content( $content ) {
	if ( has_post_format( 'image' ) ) {
		$first_image = next_saturday_image_grabber( get_the_ID(), $content, '<div class="image-wrapper">', '</div>' );
		if ( $first_image && defined( 'WPCOM_THEMES_IMAGE_REPLACE_REGEX' ) )
			$content = preg_replace( WPCOM_THEMES_IMAGE_REPLACE_REGEX, $first_image, $content, 1 );
	}

	return $content;
}
if ( ! is_admin() )
	add_filter( 'the_content', 'next_saturday_the_content', 11 );

/**
 * Get a short-form mime type for an audio file to display as a class attribute.
 *
 * @param int ID of an attachment
 * @return string A short representation of the file's mime type.
 */
function next_saturday_post_classes( $classes ) {
	if ( has_post_format( 'audio' ) ) {
		$audio = next_saturday_audio_grabber( get_the_ID() );

		if ( ! empty( $audio ) && is_object( $audio ) ) {
			$mime = str_replace( 'audio/', '', get_post_mime_type( $audio->ID ) );
			if ( in_array( $mime, array( 'mp3', 'ogg', 'wav', ) ) )
				$classes[] = $mime;
		}
	}
	return $classes;
}
add_filter( 'post_class', 'next_saturday_post_classes' );

if ( ! function_exists( 'the_post_format_audio' ) ) :
/**
 * Shiv for the_post_format_audio().
 *
 * the_post_format_audio() was introduced to WordPress in version 3.6. To
 * provide backward compatibility with previous versions, we will define our
 * own version of this function.
 *
 * @todo Remove this function when WordPress 3.8 is released.
 *
 * @param string $name The name of the shortcode.
 * @return bool True if shortcode exists; False otherwise.
 */
function the_post_format_audio() {
	$audio = next_saturday_audio_grabber( get_the_ID() );
	if ( ! empty( $audio ) && is_object( $audio ) ) :
		$url = wp_get_attachment_url( $audio->ID );
	?>
		<div class="player">
			<audio controls preload="auto" autobuffer id="audio-player-<?php the_ID(); ?>" src="<?php echo esc_url( $url ); ?>">
				<source src="<?php echo esc_url( $url ); ?>" type="<?php echo esc_attr( get_post_mime_type( $audio->ID ) ); ?>" />
			</audio>
			<p class="audio-file-link"><?php printf( __( 'Download: %1$s', 'next-saturday' ), sprintf( '<a href="%1$s">%2$s</a>', esc_url( $url ), get_the_title( $audio->ID ) ) ); ?></p>
		</div>
	<?php
	endif;
}
endif;

if ( ! function_exists( 'shortcode_exists' ) ) :
/**
 * Shiv for shortcode_exists().
 *
 * shortcode_exists() was introduced to WordPress in version 3.6. To
 * provide backward compatibility with previous versions, we will define our
 * own version of this function.
 *
 * @todo Remove this function when WordPress 3.8 is released.
 *
 * @param string $name The name of the shortcode.
 * @return bool True if shortcode exists; False otherwise.
 */
function shortcode_exists( $tag ) {
	global $shortcode_tags;
	return array_key_exists( $tag, $shortcode_tags );
}
endif;

/**
 * Deprecated.
 *
 * This function is kept just in case it has
 * been used in a child theme. It does nothing.
 *
 * @deprecated 1.2
 */
function next_saturday_add_audio_support() {
	_deprecated_function( __FUNCTION__, '1.2' );
}

/**
 * Filters wp_title to print a neat <title> tag based on what is being viewed.
 *
 * @since Next Saturday 1.1
 */
function next_saturday_wp_title( $title, $sep ) {
	global $page, $paged;

	if ( is_feed() )
		return $title;

	// Add the blog name
	$title .= get_bloginfo( 'name' );

	// Add the blog description for the home/front page.
	$site_description = get_bloginfo( 'description', 'display' );
	if ( $site_description && ( is_home() || is_front_page() ) )
		$title .= " $sep $site_description";

	// Add a page number if necessary:
	if ( $paged >= 2 || $page >= 2 )
		$title .= " $sep " . sprintf( __( 'Page %s', 'next-saturday' ), max( $paged, $page ) );

	return $title;
}
add_filter( 'wp_title', 'next_saturday_wp_title', 10, 2 );

/**
 * Implement the Custom Header feature.
 */
require( get_template_directory() . '/inc/custom-header.php' );

/**
 * Load up our functions for grabbing content from posts.
 */
require( get_template_directory() . '/content-grabbers.php' );

/**
 * Load Jetpack compatibility file.
 */
require( get_template_directory() . '/inc/jetpack.compat.php' );
