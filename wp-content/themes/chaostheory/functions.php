<?php
/**
 * @package ChaosTheory
 */

/**
 * Set the content width based on the theme's design and stylesheet.
 */
if ( ! isset( $content_width ) )
	$content_width = 510; /* pixels */

if ( ! function_exists( 'chaostheory_setup' ) ) :
/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which runs
 * before the init hook. The init hook is too late for some features, such as indicating
 * support post thumbnails.
 */
function chaostheory_setup() {

	/**
	 * Make theme available for translation
	 * Translations can be filed in the /languages/ directory
	 * If you're building a theme based on chaostheory, use a find and replace
	 * to change 'chaostheory' to the name of your theme in all the template files
	 */
	load_theme_textdomain( 'chaostheory', get_template_directory() . '/languages' );

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
	set_post_thumbnail_size( get_custom_header()->width, get_custom_header()->height, true );

	/**
	 * This theme uses wp_nav_menu() in one location.
	 */
	register_nav_menus( array(
		'primary' => __( 'Primary Navigation', 'chaostheory' ),
	) );
}
endif; // chaostheory_setup
add_action( 'after_setup_theme', 'chaostheory_setup' );

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
function chaostheory_custom_background() {
	$args = array(
		'default-color' => '',
		'default-image' => '',
	);

	$args = apply_filters( 'chaostheory_custom_background_args', $args );

	if ( function_exists( 'wp_get_theme' ) ) {
		add_theme_support( 'custom-background', $args );
	} else {
		define( 'BACKGROUND_COLOR', $args['default-color'] );
		define( 'BACKGROUND_IMAGE', $args['default-image'] );
		add_custom_background();
	}
}
add_action( 'after_setup_theme', 'chaostheory_custom_background' );

function chaostheory_widgets_init() {
	register_sidebars( 2, array(
		'before_title' => '<h3 class="widgettitle">',
		'after_title' => '</h3>',
	) );

	unregister_widget( 'WP_Widget_Search' );
	unregister_widget( 'WP_Widget_Links' );
	unregister_widget( 'WP_Widget_Meta' );

	wp_register_sidebar_widget( 'search', __( 'Search', 'chaostheory' ), 'widget_chaostheory_search' );
	wp_register_sidebar_widget( 'meta', __( 'Meta', 'chaostheory' ), 'widget_chaostheory_meta' );
	wp_register_sidebar_widget( 'links', __( 'Links', 'chaostheory' ), 'widget_chaostheory_links' );
	wp_register_sidebar_widget( 'home-link', __( 'Home Link', 'chaostheory' ), 'widget_sandbox_homelink' );
	wp_register_sidebar_widget( 'rss-links', __( 'RSS Links', 'chaostheory' ), 'widget_sandbox_rsslinks' );
}
add_action( 'widgets_init', 'chaostheory_widgets_init' );

/**
 * Enqueue scripts and styles
 */
function chaostheory_scripts() {
	wp_enqueue_style( 'chaostheory', get_stylesheet_uri() );

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) )
		wp_enqueue_script( 'comment-reply' );
}
add_action( 'wp_enqueue_scripts', 'chaostheory_scripts' );

// Nav fallback
function chaostheory_globalnav() {
?>
<div id="globalnav">
	<ul id="menu">
		<?php wp_list_pages( 'title_li=&sort_column=menu_order&depth=1' ); ?>
	</ul>
</div>
<?php
}

function chaostheory_comment($comment, $args, $depth) {
	$GLOBALS['comment'] = $comment;
	extract($args, EXTR_SKIP);
?>
<li id="comment-<?php comment_ID(); ?>" <?php comment_class(); ?>>
	<div id="div-comment-<?php comment_ID(); ?>">
	<ul class="comment-meta">
		<li class="comment-author vcard">
		<div class="comment-avatar"><?php if ( $args['avatar_size'] != 0 ) echo get_avatar( $comment, $args['avatar_size'] ); ?></div>
		<span class="fn"><?php comment_author_link(); ?></span></li>
		<?php printf( __( '<li>Posted %1$s at %2$s</li> <li><a href="%3$s" title="Permalink to this comment">Permalink</a></li>', 'chaostheory' ),
			get_comment_date(),
			get_comment_time(),
			'#comment-' . get_comment_ID() );
			?> <li><?php edit_comment_link( __( '(Edit)', 'chaostheory' ), ' ', '' ); ?> <?php comment_reply_link(array_merge( $args, array( 'add_below' => 'div-comment', 'depth' => $depth, 'max_depth' => $args['max_depth'])) ); ?></li>
	</ul>
	<div class="comment-content">
		<?php if ( $comment->comment_approved == '0' ) : ?><span class="unapproved"><?php _e( 'Your comment is awaiting moderation.', 'chaostheory' ); ?></span><?php endif; ?>
		<?php comment_text(); ?>
	</div>
	</div>
<?php
}

function chaostheory_ping($comment, $args, $depth) {
	$GLOBALS['comment'] = $comment;
	extract($args, EXTR_SKIP);
?>
<li id="comment-<?php comment_ID(); ?>" <?php comment_class(); ?>>
	<div id="div-comment-<?php comment_ID(); ?>">
	<div class="comment-meta">
		<?php printf( __( 'By %1$s on %2$s at %3$s', 'chaostheory' ),
			get_comment_author_link(),
			get_comment_date( 'd M Y' ),
			get_comment_time( 'g:i a' ));
		?>
		<?php edit_comment_link( __( '(Edit)', 'chaostheory' ), ' ', '' ); ?>
	</div>
	<div class="trackback-content">
	<div class="comment-mod"><?php if ( $comment->comment_approved == '0' ) _e( '<em>Your trackback/pingback is awaiting moderation.</em>', 'chaostheory' ); ?></div>
	<?php comment_text(); ?>
	</div>
	</div>
<?php
}

/**
 * Filters wp_title to print a neat <title> tag based on what is being viewed.
 *
 * @since ChaosTheory 1.0
 */
function chaostheory_wp_title( $title, $sep ) {
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
		$title .= " $sep " . sprintf( __( 'Page %s', 'chaostheory' ), max( $paged, $page ) );

	return $title;
}
add_filter( 'wp_title', 'chaostheory_wp_title', 10, 2 );

/**
 * Load custom widgets.
 */
require_once( get_template_directory() . '/inc/widgets.php' );

/**
 * Implement the Custom Header feature.
 */
require( get_template_directory() . '/inc/custom-header.php' );

/**
 * Load Jetpack compatibility file.
 */
require( get_template_directory() . '/inc/jetpack.compat.php' );

