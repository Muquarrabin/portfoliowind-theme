<?php
/**
 * The template for displaying comments
 *
 * @package PortfolioWind
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( post_password_required() ) {
	return;
}
?>

<div id="comments" class="comments-area mt-20 pt-12 border-t border-slate-200/80 dark:border-slate-800 text-left">

	<!-- Comments Section Header -->
	<div class="mb-8 text-left">
		<span class="inline-block px-3 py-1 rounded-full text-xs font-semibold bg-primary/10 text-primary mb-3">
			<?php esc_html_e( 'Discussion', 'portfoliowind' ); ?>
		</span>
		<h3 class="text-2xl sm:text-3xl font-extrabold text-slate-900 dark:text-white flex items-center gap-3">
			<span><?php esc_html_e( 'Comments', 'portfoliowind' ); ?></span>
			<?php if ( get_comments_number() > 0 ) : ?>
				<span class="text-sm font-semibold px-2.5 py-0.5 rounded-full bg-primary/10 text-primary">
					<?php echo esc_html( get_comments_number() ); ?>
				</span>
			<?php endif; ?>
		</h3>
	</div>

	<?php if ( have_comments() ) : ?>

		<ol class="comment-list mb-12">
			<?php
			wp_list_comments(
				array(
					'style'       => 'ol',
					'short_ping'  => true,
					'avatar_size' => 48,
				)
			);
			?>
		</ol>

		<?php
		the_comments_navigation(
			array(
				'prev_text' => '&larr; ' . esc_html__( 'Older Comments', 'portfoliowind' ),
				'next_text' => esc_html__( 'Newer Comments', 'portfoliowind' ) . ' &rarr;',
			)
		);
		?>

		<?php if ( ! comments_open() ) : ?>
			<p class="no-comments text-sm text-slate-500 italic mt-6"><?php esc_html_e( 'Comments are closed for this article.', 'portfoliowind' ); ?></p>
		<?php endif; ?>

	<?php else : ?>

		<!-- No Comments State -->
		<div class="p-6 mb-10 rounded-2xl bg-white dark:bg-slate-900 border border-slate-200/80 dark:border-slate-800 text-slate-600 dark:text-slate-400 text-sm">
			<p><?php esc_html_e( 'No comments to show. Be the first to leave a comment below!', 'portfoliowind' ); ?></p>
		</div>

	<?php endif; ?>

	<?php
	$commenter = wp_get_current_commenter();
	$req       = get_option( 'require_name_email' );
	$aria_req  = ( $req ? " aria-required='true'" : '' );

	$comment_args = array(
		'title_reply'          => esc_html__( 'Leave a Reply', 'portfoliowind' ),
		'title_reply_to'       => esc_html__( 'Leave a Reply to %s', 'portfoliowind' ),
		'title_reply_before'   => '<h3 id="reply-title" class="comment-reply-title">',
		'title_reply_after'    => '</h3>',
		'cancel_reply_link'    => esc_html__( 'Cancel Reply', 'portfoliowind' ) . ' &times;',
		'cancel_reply_before'  => ' <span class="cancel-reply-wrap">',
		'cancel_reply_after'   => '</span>',
		'comment_notes_before' => '<p class="comment-notes text-xs text-slate-500 mb-4">' . esc_html__( 'Your email address will not be published. Required fields are marked *', 'portfoliowind' ) . '</p>',
		'comment_field'        => '<div class="comment-form-comment mb-4"><label for="comment">' . esc_html__( 'Comment', 'portfoliowind' ) . ' <span class="required text-rose-500">*</span></label><textarea id="comment" name="comment" cols="45" rows="5" required class="portfolio-form-input" placeholder="' . esc_attr__( 'Write your thoughts or feedback...', 'portfoliowind' ) . '"></textarea></div>',
		'class_submit'         => 'theme-btn-primary',
		'submit_button'        => '<button name="%1$s" type="submit" id="%2$s" class="%3$s"><span>%4$s</span><svg class="w-4 h-4 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg></button>',
		'label_submit'         => esc_html__( 'Post Comment', 'portfoliowind' ),
	);

	comment_form( $comment_args );
	?>

</div>

