<?php
/**
 * @package Beach
 */

get_header(); ?>

<section id="primary">
	<div id="content" role="main">

		<header class="page-header">
			<h1 class="page-title">
				<?php
					if ( is_category() ) :
						printf( __( 'Category Archives: %s', 'beach' ), '<span>' . single_cat_title( '', false ) . '</span>' );

					elseif ( is_tag() ) :
						printf( __( 'Tag Archives: %s', 'beach' ), '<span>' . single_tag_title( '', false ) . '</span>' );

					elseif ( is_author() ) :
						/* Queue the first post, that way we know
						 * what author we're dealing with (if that is the case).
						*/
						the_post();
						printf( __( 'Author Archives: %s', 'beach' ), '<span class="vcard"><a class="url fn n" href="' . esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ) . '" title="' . esc_attr( get_the_author() ) . '" rel="me">' . get_the_author() . '</a></span>' );
						/* Since we called the_post() above, we need to
						 * rewind the loop back to the beginning that way
						 * we can run the loop properly, in full.
						 */
						rewind_posts();

					elseif ( is_day() ) :
						printf( __( 'Daily Archives: %s', 'beach' ), '<span>' . get_the_date() . '</span>' );

					elseif ( is_month() ) :
						printf( __( 'Monthly Archives: %s', 'beach' ), '<span>' . get_the_date( 'F Y' ) . '</span>' );

					elseif ( is_year() ) :
						printf( __( 'Yearly Archives: %s', 'beach' ), '<span>' . get_the_date( 'Y' ) . '</span>' );

					elseif ( is_tax( 'post_format', 'post-format-aside' ) ) :
						_e( 'Asides', 'beach' );

					elseif ( is_tax( 'post_format', 'post-format-image' ) ) :
						_e( 'Images', 'beach');

					elseif ( is_tax( 'post_format', 'post-format-video' ) ) :
						_e( 'Videos', 'beach' );

					elseif ( is_tax( 'post_format', 'post-format-quote' ) ) :
						_e( 'Quotes', 'beach' );

					elseif ( is_tax( 'post_format', 'post-format-link' ) ) :
						_e( 'Links', 'beach' );

					else :
						_e( 'Archives', 'beach' );

					endif;
				?>
			</h1>
		</header>

		<?php rewind_posts(); ?>

		<?php beach_content_nav( 'nav-above' ); ?>

		<?php /* Start the Loop */ ?>
		<?php while ( have_posts() ) : the_post(); ?>

			<?php get_template_part( 'content', get_post_format() ); ?>

		<?php endwhile; ?>

		<?php beach_content_nav( 'nav-below' ); ?>

	</div><!-- #content -->

	<?php get_sidebar(); ?>
</section><!-- #primary -->

<?php get_footer(); ?>