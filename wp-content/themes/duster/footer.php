<?php
/**
 * @package Duster
 */
?>

	</div><!-- #main -->

	<footer id="colophon" role="contentinfo">

			<?php if ( is_active_sidebar( 'sidebar-3' ) || is_active_sidebar( 'sidebar-4' ) || is_active_sidebar( 'sidebar-5' ) ) : ?>
			<div id="supplementary" <?php duster_footer_sidebar_class(); ?>>
				<?php if ( is_active_sidebar( 'sidebar-3' ) ) : ?>
				<div id="first" class="widget-area" role="complementary">
					<?php dynamic_sidebar( 'sidebar-3' ); ?>
				</div><!-- #first .widget-area -->
				<?php endif; ?>

				<?php if ( is_active_sidebar( 'sidebar-4' ) ) : ?>
				<div id="second" class="widget-area" role="complementary">
					<?php dynamic_sidebar( 'sidebar-4' ); ?>
				</div><!-- #second .widget-area -->
				<?php endif; ?>

				<?php if ( is_active_sidebar( 'sidebar-5' ) ) : ?>
				<div id="third" class="widget-area" role="complementary">
					<?php dynamic_sidebar( 'sidebar-5' ); ?>
				</div><!-- #third .widget-area -->
				<?php endif; ?>
			</div><!-- #supplementary -->
			<?php endif; ?>

			<div id="site-generator">
				<?php do_action( 'dusk_to_dawn_credits' ); ?>
				<a href="http://wordpress.org/" title="<?php esc_attr_e( 'A Semantic Personal Publishing Platform', 'duster' ); ?>" rel="generator"><?php printf( __( 'Proudly powered by %s', 'duster' ), 'WordPress' ); ?></a>
				<span class="sep"> | </span>
				<?php printf( __( 'Theme: %1$s by %2$s.', 'duster' ), 'Duster', '<a href="http://automattic.com/" rel="designer">Automattic</a>' ); ?>
			</div>
	</footer><!-- #colophon -->
</div><!-- #page -->

<?php wp_footer(); ?>

</body>
</html>