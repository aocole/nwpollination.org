<?php
/**
 * @package Next_Saturday
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class( 'post' ); ?>>

	<?php next_saturday_entry_date(); ?>

	<div class="entry-container">

		<header class="entry-header">
			<h1 class="post-title">
				<?php if ( ! is_single() ) : ?>
					<a href="<?php the_permalink(); ?>" rel="bookmark"><?php the_title(); ?></a>
				<?php else : ?>
					<?php the_title(); ?>
				<?php endif; ?>
			</h1>
		</header><!-- .entry-header -->

		<div class="entry-content">
			<?php if ( is_single() ) : ?>
				<?php the_content( __( 'Read more <span class="meta-nav">&rarr;</span>', 'next-saturday' ) ); ?>
			<?php else : ?>
				<?php
					$pattern = get_shortcode_regex();
					preg_match( "/$pattern/s", get_the_content(), $match );
					$atts    = shortcode_parse_atts( $match[3] );
					$images  = isset( $atts['ids'] ) ? explode( ',', $atts['ids'] ) : false;

					if ( ! $images ) :
						$images = get_posts( array(
							'post_parent'    => get_the_ID(),
							'fields'         => 'ids',
							'post_type'      => 'attachment',
							'post_mime_type' => 'image',
							'orderby'        => 'menu_order',
							'order'          => 'ASC',
							'numberposts'    => 999,
							'suppress_filters' => false
						) );
					endif;

					if ( $images ) :
						$total_images  = count( $images );
						$image         = array_shift( $images );
						$image_img_tag = wp_get_attachment_image( $image, 'large' );
				?>

				<div class="gallery-thumb">
					<a href="<?php the_permalink(); ?>"><?php echo $image_img_tag; ?></a>
				</div><!-- .gallery-thumb -->

				<p><span class="gallery-summary"><?php printf( _n( 'This gallery contains <a href="%1$s" rel="bookmark">%2$s photo</a>.', 'This gallery contains <a href="%1$s" rel="bookmark">%2$s photos</a>.', $total_images, 'next-saturday' ),
						esc_url( get_permalink() ),
						number_format_i18n( $total_images )
					); ?></span></p>
				<?php endif; ?>
				<?php the_excerpt(); ?>
			<?php endif; ?>
			<?php wp_link_pages( array( 'before' => '<div class="page-link"><span>' . __( 'Pages:', 'next-saturday' ) . '</span>', 'after' => '</div>' ) ); ?>
		</div><!-- .entry-content -->

		<div class="entry-meta-wrap">
			<div class="entry-meta">
				<span class="comments-num"><?php comments_popup_link( __( 'Leave a comment', 'next-saturday' ), __( '1 Comment', 'next-saturday' ), __( '% Comments', 'next-saturday' ) ); ?></span>
				<?php edit_post_link( __( 'Edit this Entry', 'next-saturday' ), '<span class="edit-link">', '</span>' ); ?>
			</div>
		</div>

	</div><!-- .entry-container -->
</article><!-- #post-## -->