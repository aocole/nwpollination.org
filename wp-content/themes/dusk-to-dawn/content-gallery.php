<?php
/**
 * @package Dusk_To_Dawn
 */
?>
<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<header class="entry-header">
		<?php if ( 'post' == get_post_type() ) : ?>
		<div class="entry-meta">
			<span class="entry-format"><a href="<?php echo esc_url( get_post_format_link( get_post_format() ) ); ?>" title="<?php echo esc_attr( sprintf( __( 'All %s posts', 'dusktodawn' ), get_post_format_string( get_post_format() ) ) ); ?>"><?php echo get_post_format_string( get_post_format() ); ?></a></span>

			<?php if ( ! is_singular() && is_sticky() ) : ?>
				<?php _e( 'Featured', 'dusktodawn' ); ?>
			<?php else : ?>
				<?php dusktodawn_posted_on(); ?>
			<?php endif; ?>
		</div><!-- .entry-meta -->
		<?php endif; ?>

		<h1 class="entry-title">
			<?php if ( is_single() ) : ?>
				<?php the_title(); ?>
			<?php else : ?>
				<a href="<?php the_permalink(); ?>" rel="bookmark"><?php the_title(); ?></a>
			<?php endif; ?>
		</h1>
	</header><!-- .entry-header -->

	<?php if ( is_search() ) : // Only display Excerpts for search pages ?>
	<div class="entry-summary">
		<?php the_excerpt(); ?>
	</div><!-- .entry-summary -->
	<?php else : ?>
	<div class="entry-content">
		<?php if ( post_password_required() || is_singular() ) : ?>
			<?php the_content( __( 'Continue reading <span class="meta-nav">&rarr;</span>', 'dusktodawn' ) ); ?>
		<?php else : ?>
			<?php
				$pattern = get_shortcode_regex();
				preg_match( "/$pattern/s", get_the_content(), $match );
				$atts    = isset( $match[3] ) ? shortcode_parse_atts( $match[3] ) : array();
				$images  = isset( $atts['ids'] ) ? explode( ',', $atts['ids'] ) : false;

				if ( ! $images ) :
					$images = get_posts( array(
						'post_parent'      => get_the_ID(),
						'fields'           => 'ids',
						'post_type'        => 'attachment',
						'post_mime_type'   => 'image',
						'orderby'          => 'menu_order',
						'order'            => 'ASC',
						'numberposts'      => 999,
						'suppress_filters' => false
					) );
				endif;

				if ( $images ) :
					$total_images  = count( $images );
					$image         = array_shift( $images );
					$image_img_tag = wp_get_attachment_image( $image, 'dusktodawn-featured-image' );
			?>
			<figure class="gallery-thumb">
				<a href="<?php the_permalink(); ?>"><?php echo $image_img_tag; ?></a>
			</figure><!-- .gallery-thumb -->

			<p><em><?php printf( _n( 'This gallery contains <a %1$s>%2$s photo</a>.', 'This gallery contains <a %1$s>%2$s photos</a>.', $total_images, 'dusktodawn' ),
					'href="' . get_permalink() . '" title="' . esc_attr( sprintf( __( 'Permalink to %s', 'dusktodawn' ), the_title_attribute( 'echo=0' ) ) ) . '" rel="bookmark"',
					number_format_i18n( $total_images )
				); ?></em></p>
			<?php endif; ?>
			<?php the_excerpt(); ?>
		<?php endif; ?>
		<?php wp_link_pages( array( 'before' => '<div class="page-link">' . __( 'Pages:', 'dusktodawn' ), 'after' => '</div>' ) ); ?>
	</div><!-- .entry-content -->
	<?php endif; ?>

	<footer class="entry-meta">
		<?php dusktodawn_post_meta(); ?>

		<?php if ( comments_open() || ( '0' != get_comments_number() && ! comments_open() ) ) : ?>
			<span class="comments-link"><?php comments_popup_link( __( 'Leave a comment', 'dusktodawn' ), __( '1 Comment', 'dusktodawn' ), __( '% Comments', 'dusktodawn' ) ); ?></span><br />
		<?php endif; ?>

		<?php edit_post_link( __( 'Edit', 'dusktodawn' ), '<span class="edit-link">', '</span>' ); ?>
	</footer><!-- #entry-meta -->

	<?php dusktodawn_author_info(); ?>

</article><!-- #post-## -->