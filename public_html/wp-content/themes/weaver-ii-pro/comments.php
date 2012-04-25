<?php
/**
 * The template for displaying Comments.
 *
 * The area of the page that contains both current comments
 * and the comment form. The actual display of comments is
 * handled by a callback to weaverii_comment() which is
 * located in the functions.php file.
 *
 * @package WordPress
 * @subpackage Weaver II
 * @since Weaver II 1.0
 */
weaverii_trace_template(__FILE__);
    weaverii_inject_area('precomments');
?>
    <div id="comments">
<?php	if ( post_password_required() ) { ?>
		<p class="nopassword"><?php _e( 'This post is password protected. Enter the password to view any comments.','weaver-ii'); ?></p>
	</div><!-- #comments -->
<?php
	/* Stop the rest of comments.php from being processed,
	 * but don't kill the script entirely -- we still have
	 * to fully load the template.
	 */
	    return;
	}
?>

<?php // You can start editing here -- including this comment!
    if (comments_open()) {
	echo("\t\t<hr class='comments-hr'>\n");
    }

    if ( have_comments() ) {
?>
	    <header id="comments-title">
	    <h3><?php echo weaverii_trans('w_21_trans', __('Comments','weaver-ii')); ?></h3>
	    	    <h4>
<?php		printf("<em>%s</em> &#8212; ",get_the_title()); comments_number(); /* em-dash */ ?>
	    </h4>
	    </header>

		<?php if ( get_comment_pages_count() > 1 && get_option( 'page_comments' ) ) : // are there comments to navigate through ?>
		<nav id="comment-nav-above">
			<h1 class="assistive-text"><?php _e( 'Comment navigation','weaver-ii'); ?></h1>
			<div class="nav-previous"><?php previous_comments_link( weaverii_trans('w_22_trans', __( '&larr; Older Comments','weaver-ii')) ); ?></div>
			<div class="nav-next"><?php next_comments_link( weaverii_trans('w_23_trans', __( 'Newer Comments &rarr;','weaver-ii')) ); ?></div>
		</nav>
		<?php endif; // check for comment navigation ?>

		<ol class="commentlist">
			<?php
				/* Loop through and list the comments. Tell wp_list_comments()
				 * to use weaverii_comment() to format the comments.
				 * If you want to overload this in a child theme then you can
				 * define weaverii_comment() and that will be used instead.
				 * See weaverii_comment() in weaver-ii/functions.php for more.
				 */
				wp_list_comments( array( 'callback' => 'weaverii_comment' ) );
			?>
		</ol>

		<?php if ( get_comment_pages_count() > 1 && get_option( 'page_comments' ) ) : // are there comments to navigate through ?>
		<nav id="comment-nav-below">
			<h1 class="assistive-text"><?php _e( 'Comment navigation','weaver-ii'); ?></h1>
			<div class="nav-previous"><?php previous_comments_link( weaverii_trans('w_22_trans', __( '&larr; Older Comments','weaver-ii')) ); ?></div>
			<div class="nav-next"><?php next_comments_link( weaverii_trans('w_23_trans', __( 'Newer Comments &rarr;','weaver-ii')) ); ?></div>
		</nav>
		<?php endif; // check for comment navigation ?>

	<?php
		/* If there are no comments and comments are closed, let's leave a little note, shall we?
		 * But we don't want the note on pages or post types that do not support comments.
		 */
    } elseif ( ! comments_open() && ! is_page() && post_type_supports( get_post_type(), 'comments' ) ) {
	?>
		<p class="nocomments"><?php echo weaverii_trans('w_24_trans', __( 'Comments are closed.','weaver-ii')); ?></p>
<?php
    }
    comment_form();
?>
</div><!-- #comments -->
<?php
    weaverii_inject_area('postcomments');
?>
