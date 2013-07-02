<?php
/**
 * @package Beach
 */
?><!DOCTYPE html>
<!--[if IE 7 ]><html class="ie7" <?php language_attributes(); ?>><![endif]-->
<!--[if IE 8 ]><html class="ie8" <?php language_attributes(); ?>><![endif]-->
<!--[if (gt IE 9)|!(IE)]><!--><html <?php language_attributes(); ?>><!--<![endif]-->
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>" />
<title><?php wp_title( '|', true, 'right' ); ?></title>
<link rel="profile" href="http://gmpg.org/xfn/11" />
<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>" />
<!--[if lt IE 9]>
<script src="<?php echo get_template_directory_uri(); ?>/html5.js" type="text/javascript"></script>
<![endif]-->
<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<div id="page" class="hfeed">
	<header id="branding">
			<hgroup role="banner">
				<h1 id="site-title"><span><a href="<?php echo home_url( '/' ); ?>" title="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></span></h1>
				<h2 id="site-description"><?php bloginfo( 'description' ); ?></h2>
			</hgroup>

			<?php if ( has_nav_menu( 'secondary' ) ) : ?>
			<nav class="access" role="navigation">
				<h1 class="section-heading"><?php _e( 'Menu', 'beach' ); ?></h1>
				<div class="skip-link screen-reader-text"><a href="#content" title="<?php esc_attr_e( 'Skip to content', 'beach' ); ?>"><?php _e( 'Skip to content', 'beach' ); ?></a></div>

				<?php wp_nav_menu( array( 'theme_location' => 'secondary' ) ); ?>
			</nav><!-- #main .access -->
			<?php endif; ?>
	</header><!-- #branding -->


	<div id="main">
		<nav class="access" role="navigation">
			<h1 class="section-heading"><?php _e( 'Menu', 'beach' ); ?></h1>
			<div class="skip-link screen-reader-text"><a href="#content" title="<?php esc_attr_e( 'Skip to content', 'beach' ); ?>"><?php _e( 'Skip to content', 'beach' ); ?></a></div>

			<?php wp_nav_menu( array( 'theme_location' => 'primary' ) ); ?>
		</nav><!-- #main .access -->
