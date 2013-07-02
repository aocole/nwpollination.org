<?php
/**
 * Sample implementation of the Custom Header feature
 * http://codex.wordpress.org/Custom_Headers
 *
 * You can add an optional custom header image to header.php like so ...

	<?php $header_image = get_header_image();
	if ( ! empty( $header_image ) ) { ?>
		<a href="<?php echo esc_url( home_url( '/' ) ); ?>" title="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>" rel="home">
			<img src="<?php header_image(); ?>" width="<?php echo get_custom_header()->width; ?>" height="<?php echo get_custom_header()->height; ?>" alt="" />
		</a>
	<?php } // if ( ! empty( $header_image ) ) ?>

 *
 * @package Next_Saturday
 */

/**
 * Setup the WordPress core custom header feature.
 *
 * Use add_theme_support to register support for WordPress 3.4+
 * as well as provide backward compatibility for previous versions.
 * Use feature detection of wp_get_theme() which was introduced
 * in WordPress 3.4.
 *
 * @todo Rework this function to remove WordPress 3.4 support when WordPress 3.6 is released.
 *
 * @uses next_saturday_header_style()
 * @uses next_saturday_admin_header_style()
 * @uses next_saturday_admin_header_image()
 *
 * @package Next Saturday
 */
function next_saturday_custom_header_setup() {
	$args = array(
		'default-image'          => '',
		'default-text-color'     => 'f3d769',
		'width'                  => 615,
		'height'                 => 85,
		'wp-head-callback'       => 'next_saturday_header_style',
		'admin-head-callback'    => 'next_saturday_admin_header_style',
		'admin-preview-callback' => '',
	);

	$args = apply_filters( 'next_saturday_custom_header_args', $args );

	if ( function_exists( 'wp_get_theme' ) ) {
		add_theme_support( 'custom-header', $args );
	} else {
		// Compat: Versions of WordPress prior to 3.4.
		define( 'HEADER_TEXTCOLOR',    $args['default-text-color'] );
		define( 'HEADER_IMAGE',        $args['default-image'] );
		define( 'HEADER_IMAGE_WIDTH',  $args['width'] );
		define( 'HEADER_IMAGE_HEIGHT', $args['height'] );
		add_custom_image_header( $args['wp-head-callback'], $args['admin-head-callback'], $args['admin-preview-callback'] );
	}
}
add_action( 'after_setup_theme', 'next_saturday_custom_header_setup' );

if ( ! function_exists( 'next_saturday_header_style' ) ) :
/**
 * Styles the header image and text displayed on the blog
 *
 * @see next_saturday_custom_header_setup().
 */
function next_saturday_header_style() {
	$header_text_color = get_header_textcolor();

	// If no custom options for text are set, let's bail
	// get_header_textcolor() options: HEADER_TEXTCOLOR is default, hide text (returns 'blank') or any hex value
	if ( HEADER_TEXTCOLOR == $header_text_color && '' == get_header_image() )
		return;

	// If we get this far, we have custom styles. Let's do this.
	?>
	<style type="text/css">
	<?php // Do we have a custom header image?
		if ( '' != get_header_image() ) :
	?>
		#site-title {
			margin: 0;
		}
		#title-wrapper {
			background: url(<?php header_image(); ?>) no-repeat;
			min-height: 85px;
			margin: auto 0;
			padding: 25px 0 0 10px;
			width: 615px;
		}
		<?php if ( is_rtl() ) { ?>
		#title-wrapper {
			padding-left: 0;
			text-align: center;
		}
		<?php }

		endif; // Has header image?

		// Has the text been hidden?
		if ( 'blank' == $header_text_color ) :
	?>
		#site-title {
			position: absolute !important;
			clip: rect(1px 1px 1px 1px); /* IE6, IE7 */
			clip: rect(1px, 1px, 1px, 1px);
		}
	<?php
		// If the user has set a custom color for the text use that
		else :
	?>
		#site-title a {
			background: none !important;
			border: 0 !important;
			color: #<?php echo $header_text_color; ?> !important;
		}
	<?php endif; ?>
	</style>
	<?php
}
endif; // next_saturday_header_style

if ( ! function_exists( 'next_saturday_admin_header_style' ) ) :
/**
 * Styles the header image displayed on the Appearance > Header admin panel.
 *
 * @see next_saturday_custom_header_setup().
 */
function next_saturday_admin_header_style() {
	$header_text_color = get_header_textcolor();
?>
	<style type="text/css">
		.appearance_page_custom-header #headimg {
			background-color: #6ab690;
			border: none;
			height: auto !important;
			text-align: left;

		}
		#headimg h1 {
			font-family: Verdana, sans-serif;
			line-height: 69px;
			min-height: 85px;
			padding: 25px 0 25px 10px;
			width: 615px;
		}
		#headimg h1 a {
			color: #f3d769;
			display: block;
			font-size: 64px;
			font-weight: bold;
			text-decoration: none;
			text-shadow: 0 1px 0 #4d8c6d;
		}
		#desc {
			display: none;
		}
		<?php
			// If the user has set a custom color for the text use that
			if ( HEADER_TEXTCOLOR != $header_text_color ) :
		?>
			#site-title a {
				color: #<?php echo $header_text_color; ?>;
			}
		<?php endif; ?>
	</style>
<?php
}
endif; // next_saturday_admin_header_style
