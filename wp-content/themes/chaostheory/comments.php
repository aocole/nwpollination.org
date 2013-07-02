<?php
/**
 * @package ChaosTheory
 */

if ( post_password_required() )
	return;
?>

<div class="comments">
	<?php
	if ( have_comments() ) :

	// Numbers of comments and pings.
	$comment_count = count( $comments_by_type['comment'] );
	$pings_count   = count( $comments_by_type['pings'] );

	if ( $comment_count ) : ?>

	<h3 class="comment-header" id="numcomments"><?php
		printf( _n( 'One Comment', '%1$s Comments', $comment_count, 'chaostheory' ),
			number_format_i18n( $comment_count )
		);
	?></h3>

	<ol id="comments" class="commentlist">
		<?php wp_list_comments(array( 'callback'=>'chaostheory_comment', 'avatar_size'=>16, 'type'=>'comment' ) ); ?>
	</ol>

	<div class="navigation">
		<div class="alignleft"><?php previous_comments_link(); ?></div>
		<div class="alignright"><?php next_comments_link(); ?></div>
	</div>
	<br />

	<?php endif; /* if ( $comment_count ) */ ?>

	<?php if ( $pings_count && get_comment_pages_count( $comments_by_type['pings'] ) >= get_query_var( 'cpage' ) ) : ?>

	<h3 class="comment-header" id="numpingbacks"><?php
		printf( _n( 'One Trackback/Pingback', '%1$s Trackbacks/Pingbacks', $pings_count, 'chaostheory' ),
			number_format_i18n( $pings_count )
		);
	?></h3>
	<ol id="pingbacks" class="commentlist">
		<?php wp_list_comments(array( 'callback'=>'chaostheory_ping', 'type'=>'pings' ) ); ?>
	</ol>

	<?php endif /* if ( $pings_count ) */ ?>

	<?php endif /* if ( have_comments() ) */ ?>

	<?php if ( ! comments_open() && get_comments_number() ) : ?>
	<p class="no-comments"><?php _e( 'Comments are closed.' , 'chaostheory' ); ?></p>
	<?php endif; ?>

	<?php comment_form(); ?>

</div>
