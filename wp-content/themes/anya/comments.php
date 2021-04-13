<?php
/**
 * The template for displaying comments
 *
 * This is the template that displays the area of the page that contains both the current comments
 * and the comment form.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package gns-theme
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

<div id="comments" class="comments order-num1">



		<h3 class="title--small">
			<?php comment_form_title() ?>
		</h3><!-- .comments-title -->
        <div class="comments__form">
        <?php comment_form([
                'fields' => [
                    'author' => '<label for="author">
                    <input id="author" name="author" placeholder="'. __( 'Name' ) . ( $req ? '*' : '' ) .'" type="text" value="' . esc_attr( $commenter['comment_author'] ) . '" size="30" /></label>',
                    'email'  => '<label for="email">
<input id="email" name="email" placeholder="' . __( 'Email' ) . ( $req ? '*' : '' ) .
                        '" type="text" value="' . esc_attr(  $commenter['comment_author_email'] ) . '" size="30" /></label>',
//                    'url'    => '<label for="url"><input id="url" name="url" placeholder="' . __( 'Website' ) . '" type="text" value="' . esc_attr( $commenter['comment_author_url'] ) . '" size="30" /></label>',
//                    'cookies' => ''
                ],
            'comment_field' => '<textarea id="comment" name="comment" cols="45" rows="8" aria-required="true" placeholder="' . _x( 'Comment', 'noun' ) . '"></textarea>',
            'submit_button' => '<input name="%1$s" type="submit" id="%2$s" class="%3$s button--secondary button--green text--14" value="%4$s" />',
            'title_reply' => ''
        ]);?>
        </div>
    <?php
    // You can start editing here -- including this comment!
    if ( have_comments() ) :?>
		<?php the_comments_navigation(); ?>
        <?php the_comments_pagination(); ?>
    <div class="comments__messages">
			<?php
			wp_list_comments( array(
				'style'      => 'div',
//				'short_ping' => true,
//                'per_page' => 1,
                'callback' => 'mytheme_comment'
			) );
			?>
    </div><!-- .comment-list -->
        <?php the_comments_pagination(); ?>
		<?php
		the_comments_navigation();

		// If comments are closed and there are comments, let's leave a little note, shall we?
		if ( ! comments_open() ) :
			?>
			<p class="no-comments"><?php esc_html_e( 'Comments are closed.', 'gns-theme' ); ?></p>
			<?php
		endif; ?>

	<?php endif; // Check for have_comments().
	?>

</div><!-- #comments -->
