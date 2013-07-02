<?php
/**
 * @package Duster
 */

/**
 * Set the content width based on the theme's design and stylesheet.
 */
if ( ! isset( $content_width ) )
	$content_width = 584;

if ( ! function_exists( 'duster_setup' ) ) :
/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which runs
 * before the init hook. The init hook is too late for some features, such as indicating
 * support post thumbnails.
 */
function duster_setup() {

	/**
	 * Make theme available for translation
	 * Translations can be filed in the /languages/ directory
	 * If you're building a theme based on Duster, use a find and replace
	 * to change 'duster' to the name of your theme in all the template files
	 */
	load_theme_textdomain( 'duster', get_template_directory() . '/languages' );

	/**
	 * Add default posts and comments RSS feed links to head
	 */
	add_theme_support( 'automatic-feed-links' );

	/**
	 * Enable support for Post Thumbnails on posts and pages
	 *
	 * @link http://codex.wordpress.org/Function_Reference/add_theme_support#Post_Thumbnails
	 */
	add_theme_support( 'post-thumbnails' );

	// We'll be using post thumbnails for custom header images on posts and pages.
	// We want them to be 940 pixels wide by 198 pixels tall.
	// Larger images will be auto-cropped to fit, smaller ones will be ignored. See header.php.
	set_post_thumbnail_size( get_custom_header()->width, get_custom_header()->height, true );

	/**
	 * Add Duster's custom image sizes
	 */
	add_image_size( 'large-feature', get_custom_header()->width, 500, true ); // Used for large feature images
	add_image_size( 'small-feature', 500, 500 ); // Used for featured posts if a large-feature doesn't exist

	/**
	 * This theme uses wp_nav_menu() in one location.
	 */
	register_nav_menus( array(
		'primary' => __( 'Primary Menu', 'duster' ),
	) );

	/**
	 * Enable support for Post Formats
	 */
	add_theme_support( 'post-formats', array( 'aside', 'link', 'gallery', 'status', 'quote' ) );
}
endif; // duster_setup
add_action( 'after_setup_theme', 'duster_setup' );

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
function duster_register_custom_background() {
	$args = array(
		'default-color' => '',
		'default-image' => '',
	);

	$args = apply_filters( 'duster_custom_background_args', $args );

	if ( function_exists( 'wp_get_theme' ) ) {
		add_theme_support( 'custom-background', $args );
	} else {
		define( 'BACKGROUND_COLOR', $args['default-color'] );
		define( 'BACKGROUND_IMAGE', $args['default-image'] );
		add_custom_background();
	}
}
add_action( 'after_setup_theme', 'duster_register_custom_background' );

/**
 * Enqueue scripts and styles
 */
function duster_scripts() {
	wp_enqueue_style( 'duster', get_stylesheet_uri() );

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) )
		wp_enqueue_script( 'comment-reply' );
}
add_action( 'wp_enqueue_scripts', 'duster_scripts' );

/**
 * Sets the post excerpt length to 40 characters.
 *
 * To override this length in a child theme, remove the filter and add your own
 * function tied to the excerpt_length filter hook.
 */
function duster_excerpt_length( $length ) {
	return 40;
}
add_filter( 'excerpt_length', 'duster_excerpt_length' );

/**
 * Returns a "Continue Reading" link for excerpts
 */
function duster_continue_reading_link() {
	return ' <a href="'. get_permalink() . '">' . __( 'Continue reading <span class="meta-nav">&rarr;</span>', 'duster' ) . '</a>';
}

/**
 * Replaces "[...]" (appended to automatically generated excerpts) with an ellipsis and duster_continue_reading_link().
 *
 * To override this in a child theme, remove the filter and add your own
 * function tied to the excerpt_more filter hook.
 */
function duster_auto_excerpt_more( $more ) {
	return ' &hellip;' . duster_continue_reading_link();
}
add_filter( 'excerpt_more', 'duster_auto_excerpt_more' );

/**
 * Adds a pretty "Continue Reading" link to custom post excerpts.
 *
 * To override this link in a child theme, remove the filter and add your own
 * function tied to the get_the_excerpt filter hook.
 */
function duster_custom_excerpt_more( $output ) {
	if ( has_excerpt() && ! is_attachment() ) {
		$output .= duster_continue_reading_link();
	}
	return $output;
}
add_filter( 'get_the_excerpt', 'duster_custom_excerpt_more' );

/**
 * Add custom body classes
 */
function duster_body_class($classes) {
	if ( is_singular() && ! is_home() && ! is_page_template( 'showcase.php' ) )
		$classes[] = 'singular';

	return $classes;
}
add_filter( 'body_class', 'duster_body_class' );

/**
 * Get our wp_nav_menu() fallback, wp_page_menu(), to show a home link.
 */
function duster_page_menu_args( $args ) {
	$args['show_home'] = true;
	return $args;
}
add_filter( 'wp_page_menu_args', 'duster_page_menu_args' );

/**
 * Register widgetized area and update sidebar with default widgets
 */
function duster_widgets_init() {
	register_sidebar( array(
		'name'          => __( 'Main Sidebar', 'duster' ),
		'id'            => 'sidebar-1',
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h1 class="widget-title">',
		'after_title'   => '</h1>',
	) );

	register_sidebar( array(
		'name'          => __( 'Showcase Sidebar', 'duster' ),
		'id'            => 'sidebar-2',
		'description'   => __( 'The sidebar for the optional Showcase Template', 'duster' ),
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h1 class="widget-title">',
		'after_title'   => '</h1>',
	) );

	register_sidebar( array(
		'name'          => __( 'Footer Area One', 'duster' ),
		'id'            => 'sidebar-3',
		'description'   => __( 'An optional widget area for your site footer', 'duster' ),
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h1 class="widget-title">',
		'after_title'   => '</h1>',
	) );

	register_sidebar( array(
		'name'          => __( 'Footer Area Two', 'duster' ),
		'id'            => 'sidebar-4',
		'description'   => __( 'An optional widget area for your site footer', 'duster' ),
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h1 class="widget-title">',
		'after_title'   => '</h1>',
	) );

	register_sidebar( array(
		'name'          => __( 'Footer Area Three', 'duster' ),
		'id'            => 'sidebar-5',
		'description'   => __( 'An optional widget area for your site footer', 'duster' ),
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h1 class="widget-title">',
		'after_title'   => '</h1>',
	) );

}
add_action( 'init', 'duster_widgets_init' );

/**
 * Display navigation to next/previous pages when applicable
 */
function duster_content_nav($nav_id) {
	global $wp_query;

	if ( $wp_query->max_num_pages > 1 ) : ?>
		<nav id="<?php echo $nav_id; ?>">
			<h1 class="section-heading"><?php _e( 'Post navigation', 'duster' ); ?></h1>
			<div class="nav-previous"><?php next_posts_link( __( '<span class="meta-nav">&larr;</span> Older posts', 'duster' ) ); ?></div>
			<div class="nav-next"><?php previous_posts_link( __( 'Newer posts <span class="meta-nav">&rarr;</span>', 'duster' ) ); ?></div>
		</nav><!-- #nav-above -->
	<?php endif;
}

/**
 * Grab the first URL from a Link post
 */
function duster_url_grabber() {
	$first_url = '';

	ob_start();
	ob_end_clean();

	$output = preg_match_all('/<a.+href=[\'"]([^\'"]+)[\'"].*>/i', get_the_content(), $matches);

	$first_url = $matches [1][0];

	if ( empty( $first_url ) )
		return false;

	return $first_url;
}

/**
 * Count the number of footer sidebars to enable dynamic classes for the footer
 */
function duster_footer_sidebar_class() {
	$count = 0;

	if ( is_active_sidebar( 'sidebar-3' ) )
		$count++;

	if ( is_active_sidebar( 'sidebar-4' ) )
		$count++;

	if ( is_active_sidebar( 'sidebar-5' ) )
		$count++;

	switch ( $count ) {
		case '1':
			$class = 'one';
			break;

		case '2':
			$class = 'two';
			break;

		case '3':
			$class = 'three';
			break;

		default:
			$class = '';
			break;
	}

	if ( '' != $class )
		echo 'class="' . $class . '"';
}

if ( ! function_exists( 'duster_comment' ) ) :
/**
 * Template for comments and pingbacks.
 *
 * To override this walker in a child theme without modifying the comments template
 * simply create your own duster_comment(), and that function will be used instead.
 *
 * Used as a callback by wp_list_comments() for displaying the comments.
 *
 * @since Duster 0.4
 */
function duster_comment( $comment, $args, $depth ) {
	$GLOBALS['comment'] = $comment;
	switch ( $comment->comment_type ) :
		case '' :
	?>
	<li <?php comment_class(); ?> id="li-comment-<?php comment_ID(); ?>">
		<article id="comment-<?php comment_ID(); ?>" class="comment">
			<footer class="comment-meta">
				<div class="comment-author vcard">
					<?php
						$avatar_size = 68;
						if ( '0' != $comment->comment_parent )
							$avatar_size = 39;

						echo get_avatar( $comment, $avatar_size );

						printf( __( '%1$s on %2$s%3$s at %4$s%5$s <span class="says">said:</span>', 'duster' ),
							sprintf( '<cite class="fn">%s</cite>', get_comment_author_link() ),
							'<a href="' . esc_url( get_comment_link( $comment->comment_ID ) ) . '"><time pubdate datetime="' . get_comment_time( 'c' ) . '">',
							get_comment_date(),
							get_comment_time(),
							'</time></a>'
						);
					?>

					<?php edit_comment_link( __( '[Edit]', 'duster' ), ' ' ); ?>
				</div><!-- .comment-author .vcard -->

				<?php if ( $comment->comment_approved == '0' ) : ?>
					<em><?php _e( 'Your comment is awaiting moderation.', 'duster' ); ?></em>
					<br />
				<?php endif; ?>

			</footer>

			<div class="comment-content"><?php comment_text(); ?></div>

			<div class="reply">
				<?php comment_reply_link( array_merge( $args, array( 'reply_text' => __( 'Reply &darr;', 'duster' ), 'depth' => $depth, 'max_depth' => $args['max_depth'] ) ) ); ?>
			</div><!-- .reply -->
		</article><!-- #comment-## -->

	<?php
			break;
		case 'pingback' :
		case 'trackback' :
	?>
	<li class="post pingback">
		<p><?php _e( 'Pingback:', 'duster' ); ?> <?php comment_author_link(); ?><?php edit_comment_link( __( '(Edit)', 'duster' ), ' ' ); ?></p>
	<?php
			break;
	endswitch;
}
endif; // ends check for duster_comment()

/**
 * Filters wp_title to print a neat <title> tag based on what is being viewed.
 *
 * @since Duster 1.1
 */
function duster_wp_title( $title, $sep ) {
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
		$title .= " $sep " . sprintf( __( 'Page %s', 'duster' ), max( $paged, $page ) );

	return $title;
}
add_filter( 'wp_title', 'duster_wp_title', 10, 2 );

/**
 * Grab Duster's Custom Widgets
 */
require get_template_directory() . '/inc/widgets.php';

/**
 * Implement the Custom Header feature.
 */
require get_template_directory() . '/inc/custom-header.php';

/**
 * Load Jetpack compatibility file.
 */
require get_template_directory() . '/inc/jetpack.compat.php';

/**
 * Load wp.com compatibility file.
 */
if ( file_exists( get_template_directory() . '/inc/wpcom.php' ) )
	require get_template_directory() . '/inc/wpcom.php';

/**
 * This theme was built with PHP, Semantic HTML, CSS, love, and a Toolbox.
 */