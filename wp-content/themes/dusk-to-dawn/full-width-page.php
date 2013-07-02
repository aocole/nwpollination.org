<?php
/**
 * Template Name: Full-width, no sidebar
 * @package Dusk_To_Dawn
 */
get_header(); ?>

<div id="primary" class="full-width">
	<div id="content" role="main">

		<?php while ( have_posts() ) : the_post(); ?>

			<?php get_template_part( 'content', 'page' ); ?>

			<?php comments_template(); ?>

		<?php endwhile; ?>

	</div><!-- #content -->
</div><!-- #primary -->

<?php get_footer(); ?>