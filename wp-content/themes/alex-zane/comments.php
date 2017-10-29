<?php
/**
 * The template for displaying comments
 *
 * The area of the page that contains both current comments
 * and the comment form.
 */

/*
 * If the current post is protected by a password and
 * the visitor has not yet entered the password we will
 * return early without loading the comments.
 */
if ( post_password_required() ) {
	return;
}
?>

<div id="comments" class="post-comments col-sm-10 col-sm-push-1">
	<h3 class="comments-title">
		<?php
			printf( _nx( 'One Comment', '%1$s comments', get_comments_number(), 'comments title', 'alex-zane' ),
				number_format_i18n( get_comments_number() ) );
		?>
	</h3>

	<?php alex_zane_comment_nav(); ?>
	
	<ul class="comment-list">
		<?php
			wp_list_comments( array(
			  'style'             => 'ul',
			  'short_ping'        => true,
			  'max_depth'         => 4,
			  'avatar_size'       => 80,
			  'callback'          => 'alex_zane_comment',
			  'type'              => 'all',
			  'reply_text'        => esc_html__('reply','alex-zane'),
			  'page'              => '',
			  'per_page'          => '',
			  'reverse_top_level' => null,
			  'reverse_children'  => ''
			) );
		?>
	</ul><!-- .comment-list -->

	<?php //alex_zane_comment_nav(); ?>

	<?php
		// If comments are closed and there are comments, let's leave a little note, shall we?
		if ( ! comments_open() && get_comments_number() && post_type_supports( get_post_type(), 'comments' ) ) :
	?>
		<p class="no-comments"><?php esc_html_e( 'Comments are closed.', 'alex-zane' ); ?></p>
	<?php endif; ?>

</div>

<?php if (comments_open()) { ?>
	<div class="post-comment-respond col-sm-10 col-sm-push-1">
		<div class="reply-title col-sm-12">
  			<h3><?php esc_html_e( 'leave a comment','alex-zane');?></h3>
			</div>

		<?php
		//Custom Fields
		$commenter = wp_get_current_commenter();
		$fields =  array(
			'author'=> '<div class="form-group control-group col-sm-6">
                            <span class="icon"><i class="fa fa-user"></i></span>
                            <input class="form-control" id="comment-author"  type="text" value="' . esc_attr( $commenter['comment_author'] ) . '"  name="'  . esc_attr( 'author','alex-zane') . '" placeholder="'. esc_attr__( 'Name*', 'alex-zane' ).'" 	required="">
                        </div>',
			'email' => '<div class="form-group control-group col-sm-6">
							<span class="icon"><i class="fa fa-envelope-o"></i></span>
							<input class="form-control" id="comment-email"   type="email" name="email" value="' . esc_attr(  $commenter['comment_author_email'] ) . '" placeholder="'. esc_attr__( 'E-mail*', 'alex-zane' ).'"  required="">
						</div>',
		);

		$args = array(
			'fields' => $fields,
			'comment_field' => '<div class="form-group control-group col-sm-12">
								<span class="icon"><i class="fa fa-pencil"></i></span>
								<textarea id="comment" class="form-control" name="comment" placeholder="' . esc_attr__( 'Message', 'alex-zane' ) .  '" required=""></textarea>
								</div>',
			'must_log_in' => '',
			'logged_in_as' => '',
			'comment_notes_before' => '',
			'comment_notes_after' => '',
			'title_reply' => '',
			'title_reply_to' => esc_html__('Leave a Reply to %s', 'alex-zane'),
			'cancel_reply_link' => esc_html__('Cancel', 'alex-zane'),
			'label_submit' => esc_html__('post comment', 'alex-zane'),
			'submit_button'        =>  '<div class="form-button submit">
										<button class="btn center-block">
										<input name="%1$s" type="submit" id="%2$s" class="%3$s" value="%4$s" />
										<i class="fa fa-commenting-o"></i>
										</button>
										</div>',
			'class_submit' => 'form-submit',
		);
		?>
		<?php comment_form($args); ?>
	</div>
<?php }


