<?php
/**
 * @package Dusk_To_Dawn
 */
?>

				</div><!-- #main -->
			</div><!-- #page -->
			<footer id="colophon" role="contentinfo">
				<div id="site-generator">
					<?php do_action( 'dusk_to_dawn_credits' ); ?>
					<a href="http://wordpress.org/" title="<?php esc_attr_e( 'A Semantic Personal Publishing Platform', 'dusk_to_dawn' ); ?>" rel="generator"><?php printf( __( 'Proudly powered by %s', 'dusk_to_dawn' ), 'WordPress' ); ?></a>
					<span class="sep"> | </span>
					<?php printf( __( 'Theme: %1$s by %2$s.', 'dusk_to_dawn' ), 'Dusk To Dawn', '<a href="http://automattic.com/" rel="designer">Automattic</a>' ); ?>
				</div>
			</footer><!-- #colophon -->
		</div><!-- #wrapper -->
	</div><!-- #super-wrapper -->
</div><!-- #super-super-wrapper -->
<?php wp_footer(); ?>
</body>
</html>