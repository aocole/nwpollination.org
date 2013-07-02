<?php
/**
 * @package Next_Saturday
 */
?>

				</div><!-- #main -->

			</div><!-- #primary -->
		</div><!-- #primary-wrapper -->

		<?php get_sidebar(); ?>

		<footer id="colophon" role="contentinfo">
			<div id="site-generator">
				<?php do_action( 'next_saturday_credits' ); ?>
				<a href="http://wordpress.org/" title="<?php esc_attr_e( 'A Semantic Personal Publishing Platform', 'next_saturday' ); ?>" rel="generator"><?php printf( __( 'Proudly powered by %s', 'next_saturday' ), 'WordPress' ); ?></a>
				<span class="sep"> | </span>
				<?php printf( __( 'Theme: %1$s by %2$s.', 'next-saturday' ), 'Next Saturday', '<a href="http://www.ianmintz" rel="designer">Ian Mintz</a>' ); ?>
			</div>
		</footer><!-- #colophon -->

</div><!-- #wrapper-->

<?php wp_footer(); ?>

</body>
</html>