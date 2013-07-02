<?php
/**
 * @package Dusk_To_Dawn
 */
?><!DOCTYPE html>
<!--[if IE 8]>
<html id="ie8" <?php language_attributes(); ?>>
<![endif]-->
<!--[if !(IE 8)]><!-->
<html <?php language_attributes(); ?>>
<!--<![endif]-->
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>" />
<title><?php wp_title( '|', true, 'right' ); ?></title>
<link rel="profile" href="http://gmpg.org/xfn/11" />
<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>" />
<!--[if lt IE 9]>
<script src="<?php echo get_template_directory_uri(); ?>/js/html5.js" type="text/javascript"></script>
<![endif]-->
<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<div id="super-super-wrapper">
	<div id="super-wrapper">
		<div id="wrapper">
		<?php do_action( 'before' ); ?>
			<div id="page" class="hfeed">
				<header id="branding" role="banner">
					<hgroup>
						<h1 id="site-title"><a href="<?php echo home_url( '/' ); ?>" title="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></h1>
						<h2 id="site-description"><?php bloginfo( 'description' ); ?></h2>
					</hgroup>
				</header><!-- #branding -->

				<div id="main" class="clear-fix">
					<?php
						// Do we have a header image around?
						if ( '' != get_header_image() ) :
					?>
					<div id="header-image">
						<a href="<?php echo home_url( '/' ); ?>">
							<img src="<?php header_image(); ?>" width="<?php echo get_custom_header()->width; ?>" height="<?php echo get_custom_header()->height; ?>" alt="" />
						</a>
					</div>
					<?php endif; ?>