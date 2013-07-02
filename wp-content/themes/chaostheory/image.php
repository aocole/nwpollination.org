<?php
/**
 * @package ChaosTheory
 */
?>
<?php get_header(); ?>

	<div id="container">
		<div id="content" class="hfeed">

			<?php while ( have_posts() ) : the_post(); ?>

				<div id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
					<div class="entry-meta">
						<h2 class="entry-title"><a href="<?php echo get_permalink( $post->post_parent ); ?>" rev="attachment"><?php echo get_the_title( $post->post_parent ); ?></a> &raquo; <?php the_title(); ?></h2>
					</div>
					<div class="entry-content">
						<p class="attachment"><a href="<?php echo wp_get_attachment_url( get_the_ID() ); ?>"><?php echo wp_get_attachment_image( get_the_ID(), 'auto' ); ?></a></p>
						<div class="caption"><?php the_excerpt(); ?></div>
						<div class="image-description"><?php the_content(); ?></div>

						<div class="navigation">
							<div class="alignleft"><?php previous_image_link(); ?></div>
							<div class="alignright"><?php next_image_link(); ?></div>
						</div>
					</div>
				</div><!-- .post -->

				<?php comments_template( '', true ); ?>

			<?php endwhile; // end of the loop. ?>

		</div><!-- #content .hfeed -->
	</div><!-- #container -->

<?php get_sidebar(); ?>
<?php get_footer(); ?>