<?php
/**
 * @package Dusk_To_Dawn
 */

// Load scripts.
function dusktodawn_scripts() {
	wp_enqueue_style( 'dusktodawn', get_stylesheet_uri() );

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) )
		wp_enqueue_script( 'comment-reply' );
}
add_action( 'wp_enqueue_scripts', 'dusktodawn_scripts' );

/**
 * Audio helper script.
 *
 * If an audio shortcode exists we will enqueue javascript
 * that replaces all non-supported audio player instances
 * with text links.
 *
 * @uses dusktodawn_has_shortcode();
 */
function dusktodawn_audio_script() {
	if ( dusktodawn_has_shortcode( 'audio' ) )
		return;

	if ( ! is_singular() ||  has_post_format( 'audio' ) )
		wp_enqueue_script( 'dusktodawn-audio', get_template_directory_uri() . '/js/audio.js', array(), '20120315' );
}
add_action( 'wp_enqueue_scripts', 'dusktodawn_audio_script' );

// Set the content width based on the theme's design and stylesheet.
if ( ! isset( $content_width ) )
	$content_width = 474;


if ( ! function_exists( 'dusktodawn_setup' ) ):
function dusktodawn_setup() {

	load_theme_textdomain( 'dusktodawn', get_template_directory() . '/languages' );

	// Add default posts and comments RSS feed links to head
	add_theme_support( 'automatic-feed-links' );

	// Enable Post Thumbnail and add two custom sizes
	add_theme_support( 'post-thumbnails' );
	add_image_size( 'dusktodawn-featured-image', 588, 9999, false );

	// This theme uses wp_nav_menu() in one location.
	register_nav_menus( array(
		'sidebar-menu' => __( 'Sidebar Menu', 'dusktodawn' ),
	) );

	// Add support for Post Formats
	add_theme_support( 'post-formats', array( 'aside', 'gallery', 'image', 'video', 'quote', 'link', 'chat', 'audio' ) );
}
endif; // dusktodawn_setup

// Tell WordPress to run dusktodawn_setup() when the 'after_setup_theme' hook is run.
add_action( 'after_setup_theme', 'dusktodawn_setup' );
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
function dusktodawn_register_custom_background() {
	$args = array(
		'default-color' => '',
		'default-image' => '',
	);

	$args = apply_filters( 'coraline_custom_background_args', $args );

	if ( function_exists( 'wp_get_theme' ) ) {
		add_theme_support( 'custom-background', $args );
	} else {
		define( 'BACKGROUND_COLOR', $args['default-color'] );
		define( 'BACKGROUND_IMAGE', $args['default-image'] );
		add_custom_background();
	}
}
add_action( 'after_setup_theme', 'dusktodawn_register_custom_background' );

function dusktodawn_custom_background() {
	if ( '' != get_background_image() ) : ?>
		<style type="text/css">
			#super-super-wrapper,
			#super-wrapper,
			#page,
			.right-sidebar #page {
				background: none;
				filter: progid:DXImageTransform.Microsoft.gradient(enabled=false);
			}
		</style>
	<?php elseif ( '' != get_background_color() ) : ?>
		<style type="text/css">
			#super-super-wrapper {
				background: none;
				filter: progid:DXImageTransform.Microsoft.gradient(enabled=false);
			}
		</style>
	<?php endif;
}
add_action( 'wp_head', 'dusktodawn_custom_background' );

// Get our wp_nav_menu() fallback, wp_page_menu(), to show a home link.
function dusktodawn_page_menu_args( $args ) {
	$args['show_home'] = true;
	return $args;
}
add_filter( 'wp_page_menu_args', 'dusktodawn_page_menu_args' );

// Register widgetized area and update sidebar with default widgets
function dusktodawn_widgets_init() {
	register_sidebar( array(
		'name'          => __( 'Sidebar 1', 'dusktodawn' ),
		'id'            => 'sidebar-1',
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h1 class="widget-title">',
		'after_title'   => '</h1>',
	) );
}
add_action( 'widgets_init', 'dusktodawn_widgets_init' );

// Display navigation to next/previous pages when applicable
function dusktodawn_content_nav( $nav_id ) {
	global $wp_query;

	?>
	<nav id="<?php echo $nav_id; ?>" class="clear-fix">
		<h1 class="assistive-text section-heading"><?php _e( 'Post navigation', 'dusktodawn' ); ?></h1>

	<?php if ( is_single() ) : // navigation links for single posts ?>
		<span class="nav-previous"><?php previous_post_link( '%link', __( '<span class="meta-nav">&larr;</span> Previous', 'dusktodawn' ) ); ?></span>
		<span class="nav-next"><?php next_post_link( '%link', __( 'Next <span class="meta-nav">&rarr;</span>', 'dusktodawn' ) ); ?></span>

	<?php elseif ( $wp_query->max_num_pages > 1 && ( is_home() || is_archive() || is_search() ) ) : // navigation links for home, archive, and search pages ?>

		<?php if ( get_next_posts_link() ) : ?>
		<span class="nav-previous"><?php next_posts_link( __( '<span class="meta-nav">&larr;</span> Older posts', 'dusktodawn' ) ); ?></span>
		<?php endif; ?>

		<?php if ( get_previous_posts_link() ) : ?>
		<span class="nav-next"><?php previous_posts_link( __( 'Newer posts <span class="meta-nav">&rarr;</span>', 'dusktodawn' ) ); ?></span>
		<?php endif; ?>

	<?php endif; ?>

	</nav><!-- #<?php echo $nav_id; ?> -->
	<?php
}

//Prints HTML with meta information for the current post-date/time and author.
function dusktodawn_posted_on() {
	printf( __( '<a href="%1$s" title="%2$s" rel="bookmark"><time class="entry-date" datetime="%3$s" pubdate>%4$s</time></a><span class="byline"> <span class="sep"> by </span> <span class="author vcard"><a class="url fn n" href="%5$s" title="%6$s" rel="author">%7$s</a></span></span>', 'dusktodawn' ),
		esc_url( get_permalink() ),
		esc_attr( get_the_time() ),
		esc_attr( get_the_date( 'c' ) ),
		esc_html( get_the_date() ),
		esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ),
		esc_attr( sprintf( __( 'View all posts by %s', 'dusktodawn' ), get_the_author() ) ),
		esc_html( get_the_author() )
	);
}

// Adds custom classes to the array of body classes.
function dusktodawn_body_classes( $classes ) {
	// Adds a class of single-author to blogs with only 1 published author
	if ( ! is_multi_author() ) {
		$classes[] = 'single-author';
	}

	return $classes;
}
add_filter( 'body_class', 'dusktodawn_body_classes' );

// Returns true if a blog has more than 1 category
function dusktodawn_categorized_blog() {
	if ( false === ( $all_the_cool_cats = get_transient( 'all_the_cool_cats' ) ) ) {
		// Create an array of all the categories that are attached to posts
		$all_the_cool_cats = get_categories( array(
			'hide_empty' => 1,
		) );

		// Count the number of categories that are attached to the posts
		$all_the_cool_cats = count( $all_the_cool_cats );

		set_transient( 'all_the_cool_cats', $all_the_cool_cats );
	}

	if ( '1' != $all_the_cool_cats ) {
		// This blog has more than 1 category so dusktodawn_categorized_blog should return true
		return true;
	} else {
		// This blog has only 1 category so dusktodawn_categorized_blog should return false
		return false;
	}
}

// Flush out the transients used in dusktodawn_categorized_blog
function dusktodawn_category_transient_flusher() {
	// Like, beat it. Dig?
	delete_transient( 'all_the_cool_cats' );
}
add_action( 'edit_category', 'dusktodawn_category_transient_flusher' );
add_action( 'save_post', 'dusktodawn_category_transient_flusher' );

function dusktodawn_post_meta() {
	if ( is_singular() ) :
		/* translators: used between list items, there is a space after the comma */
		$category_list = get_the_category_list( __( ', ', 'dusktodawn' ) );

		/* translators: used between list items, there is a space after the comma */
		$tag_list = get_the_tag_list( '', ', ' );

		if ( ! dusktodawn_categorized_blog() ) {
			// This blog only has 1 category so we just need to worry about tags in the meta text
			if ( '' != $tag_list ) {
				$meta_text = __( 'This entry was tagged %2$s.<br />Bookmark the <a href="%3$s" title="Permalink to %4$s" rel="bookmark">permalink</a>.<br />', 'dusktodawn' );
			} else {
				$meta_text = __( 'Bookmark the <a href="%3$s" title="Permalink to %4$s" rel="bookmark">permalink</a>.<br />', 'dusktodawn' );
			}

		} else {
			// But this blog has loads of categories so we should probably display them here
			if ( '' != $tag_list ) {
				$meta_text = __( 'This entry was posted in %1$s and tagged %2$s.<br />Bookmark the <a href="%3$s" title="Permalink to %4$s" rel="bookmark">permalink</a>.<br />', 'dusktodawn' );
			} else {
				$meta_text = __( 'This entry was posted in %1$s.<br />Bookmark the <a href="%3$s" title="Permalink to %4$s" rel="bookmark">permalink</a>.<br />', 'dusktodawn' );
			}

		} // end check for categories on this blog

		printf(
			$meta_text,
			$category_list,
			$tag_list,
			get_permalink(),
			the_title_attribute( 'echo=0' )
		);
	else :
		/* translators: used between list items, there is a space after the comma */
		$categories_list = get_the_category_list( __( ', ', 'dusktodawn' ) );
		if ( $categories_list && dusktodawn_categorized_blog() ) : ?>
			<span class="cat-links">
				<?php printf( __( 'Posted in %1$s', 'dusktodawn' ), $categories_list ); ?><br />
			</span>
		<?php endif; // End if categories ?>

		<?php /* translators: used between list items, there is a space after the comma */
		$tags_list = get_the_tag_list( '', __( ', ', 'dusktodawn' ) );
		if ( $tags_list ) : ?>

			<span class="tag-links">
				<?php printf( __( 'Tagged %1$s', 'dusktodawn' ), $tags_list ); ?><br />
			</span>
		<?php endif; // End if $tags_list
	endif;
}

// Author info box
function dusktodawn_author_info() {
	if ( is_singular() && get_the_author_meta( 'description' ) && is_multi_author() ) : ?>
		<div id="author-info">
			<div id="author-avatar">
				<?php echo get_avatar( get_the_author_meta( 'user_email' ), apply_filters( 'dusktodawn_author_bio_avatar_size', 50 ) ); ?>
			</div><!-- #author-avatar -->
			<div id="author-description">
				<h2><?php echo sprintf( __( 'About %s', 'dusktodawn' ), get_the_author() ); ?></h2>
				<?php the_author_meta( 'description' ); ?>
				<div id="author-link">
					<a href="<?php echo esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ); ?>" rel="author">
						<?php printf( __( 'View all posts by %s <span class="meta-nav">&rarr;</span>', 'dusktodawn' ), get_the_author() ); ?>
					</a>
				</div><!-- #author-link	-->
			</div><!-- #author-description -->
		</div><!-- #entry-author-info -->
	<?php endif;
}

// Filter in a link to a content ID attribute for the next/previous image links on image attachment pages
function dusktodawn_enhanced_image_navigation( $url ) {
	global $wp_rewrite;
	$post_parent = get_post()->post_parent;

	if ( wp_attachment_is_image() && ( $wp_rewrite->using_permalinks() && ( $post_parent > 0 ) && ( $post_parent != get_the_ID() ) ) )
		$url = $url . '#main';

	return $url;
}
add_filter( 'attachment_link', 'dusktodawn_enhanced_image_navigation' );

// Enqueue font styles.
function dusktodawn_fonts() {
	$protocol = is_ssl() ? 'https' : 'http';
	wp_enqueue_style( 'ubuntu', "$protocol://fonts.googleapis.com/css?family=Ubuntu:300,400,700" );
}
add_action( 'wp_enqueue_scripts', 'dusktodawn_fonts' );

/**
 * Appends post title to Aside and Quote posts
 *
 * @param string $content
 * @return string
 */
function dusktodawn_conditional_title( $content ) {

	if ( has_post_format( 'aside' ) || has_post_format( 'quote' ) ) {
		if ( ! is_singular() )
			$content .= the_title( '<h1 class="entry-title"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">', '</a></h1>', false );
		else
			$content .= the_title( '<h1 class="entry-title">', '</h1>', false );
	}

	return $content;
}
add_filter( 'the_content', 'dusktodawn_conditional_title', 0 );

/**
 * Filters wp_title to print a neat <title> tag based on what is being viewed.
 *
 * @since Dusk To Dawn 1.1
 */
function dusktodawn_wp_title( $title, $sep ) {
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
		$title .= " $sep " . sprintf( __( 'Page %s', 'dusktodawn' ), max( $paged, $page ) );

	return $title;
}
add_filter( 'wp_title', 'dusktodawn_wp_title', 10, 2 );

if ( ! function_exists( 'dusktodawn_audio_player_class' ) ) :
/**
 * Get a short-form mime type for an audio file to display as a class attribute.
 *
 * @param int ID of an attachment
 * @return string A short representation of the file's mime type.
 */
function dusktodawn_audio_player_class( $post_id ) {
	$mime = get_post_mime_type( $post_id );
	$short = array(
		'audio/mpeg' => 'mp3',
		'audio/ogg'  => 'ogg',
		'audio/wav'  => 'wav',
	);

	if ( isset( $short[ $mime ] ) )
		return ' ' . $short[ $mime ];

	return '';
}
endif;

if ( ! function_exists( 'dusktodawn_has_shortcode' ) ) :
/**
 * Check to see whether a given shortcode exists.
 *
 * @param string $name The name of the shortcode.
 * @return bool True if shortcode exists; false otherwise.
 */
function dusktodawn_has_shortcode( $name ) {
	global $shortcode_tags;

	return ( ! is_string( $name ) || ! isset( $shortcode_tags[ $name ] ) );
}
endif;

/**
 * Deprecated.
 *
 * This function is kept just in case it has
 * been used in a child theme. It does nothing.
 */
function dusktodawn_add_audio_support() {
	_deprecated_function( __FUNCTION__ , '1.2' );
}

/**
 * Load up our functions for grabbing content from posts.
 */
require( get_template_directory() . '/content-grabbers.php' );

/**
 * Implement the Custom Header feature.
 */
require get_template_directory() . '/inc/custom-header.php';

/**
 * Load theme options.
 */
require get_template_directory() . '/inc/theme-options.php';

/**
 * Load Jetpack compatibility file.
 */
require get_template_directory() . '/inc/jetpack.compat.php';

/**
 * Load WP.com specific functions.
 */
if ( defined( 'IS_WPCOM' ) && IS_WPCOM )
	require get_template_directory() . '/inc/wpcom.php';

/**
 * This theme was built with PHP, Semantic HTML, CSS, love, and a Toolbox.
 */