<?php
/**
 * @package Pink Touch 2
 */
?><!DOCTYPE html>
<!--[if IE 7]>
<html id="ie7" <?php language_attributes(); ?>>
<![endif]-->
<!--[if IE 8]>
<html id="ie8" <?php language_attributes(); ?>>
<![endif]-->
<!--[if IE 9]>
<html id="ie9" <?php language_attributes(); ?>>
<![endif]-->
<!--[if !(IE 7) | !(IE 8) | !(IE 9)  ]><!-->
<html <?php language_attributes(); ?>>
<!--<![endif]-->
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>" />
<title><?php wp_title( '|', true, 'right' ); ?></title>
<link rel="profile" href="http://gmpg.org/xfn/11" />
<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>" />
<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
	<div id="wrapper">
		<div id="navigation">
			<div class="wrapper clearfix">
				<?php wp_nav_menu( array( 'theme_location' => 'primary', 'fallback_cb' => '', 'container_id' => 'nav-menu' ) ); ?>
				<?php get_search_form(); ?>
			</div>
		</div><!-- /#navigation -->
		<div id="navigation-frill"></div>

		<div id="header">
			<h1><a href="<?php echo home_url( '/' ); ?>" title="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></h1>

			<div id="description">
				<p><?php bloginfo( 'description' ); ?></p>
			</div>
		</div><!-- /#header -->

		<div id="content">