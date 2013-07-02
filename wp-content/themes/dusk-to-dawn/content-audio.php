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

	<?php if ( has_post_thumbnail() ) : the_post_thumbnail( 'dusktodawn-featured-image', array( 'class' => 'featured-image' ) ); endif; ?>

	<div class="entry-content">
		<?php $audio = dusktodawn_audio_grabber( get_the_ID() ); ?>
		<?php if ( ! empty( $audio ) ) : ?>
			<?php $url = wp_get_attachment_url( $audio->ID ); ?>
			<?php if ( dusktodawn_has_shortcode( 'audio' ) ) : ?>
				<?php echo do_shortcode( '[audio ' . esc_url( $url ) . ']' ); ?>
			<?php else : ?>
				<div class="player<?php echo esc_attr( dusktodawn_audio_player_class( $audio->ID ) ); ?>">
					<audio controls preload="auto" autobuffer id="audio-player-<?php the_ID(); ?>" src="<?php echo esc_url( $url ); ?>">
						<source src="<?php echo esc_url( $url ); ?>" type="<?php echo esc_attr( get_post_mime_type( $audio->ID ) ); ?>" />
					</audio>
					<p class="audio-file-link"><?php printf( __( 'Download: %1$s', 'dusktodawn' ), '<a href="' . esc_url( $url ) . '">' . get_the_title( $audio->ID ) . '</a>' ); ?></p>
				</div>
			<?php endif; ?>
		<?php endif; ?>
		<?php the_content( __( 'Continue reading <span class="meta-nav">&rarr;</span>', 'dusktodawn' ) ); ?>
		<?php wp_link_pages( array( 'before' => '<div class="page-link">' . __( 'Pages:', 'dusktodawn' ), 'after' => '</div>' ) ); ?>
	</div><!-- .entry-content -->

	<footer class="entry-meta">
		<?php dusktodawn_post_meta(); ?>

		<?php if ( comments_open() || ( '0' != get_comments_number() && ! comments_open() ) ) : ?>
			<span class="comments-link"><?php comments_popup_link( __( 'Leave a comment', 'dusktodawn' ), __( '1 Comment', 'dusktodawn' ), __( '% Comments', 'dusktodawn' ) ); ?></span><br />
		<?php endif; ?>

		<?php edit_post_link( __( 'Edit', 'dusktodawn' ), '<span class="edit-link">', '</span>' ); ?>
	</footer><!-- #entry-meta -->

	<?php dusktodawn_author_info(); ?>

</article><!-- #post-## -->