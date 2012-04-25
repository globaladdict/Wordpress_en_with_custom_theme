<?php
/**
 * The template for displaying posts in the Aside Post Format on index and archive pages
 *
 * Learn more: http://codex.wordpress.org/Post_Formats
 *
 * @package WordPress
 * @subpackage Weaver II
 * @since Weaver II 1.0
 */
weaverii_trace_template(__FILE__);
global $weaverii_cur_post_id;
$weaverii_cur_post_id = get_the_ID();
weaverii_per_post_style();
?>

	<article id="post-<?php the_ID(); ?>" <?php post_class('content-aside post-format ' . weaverii_post_count_class()); ?>>
		<header class="entry-header">
<?php 		weaverii_entry_header(__( 'Aside','weaver-ii'));
		weaverii_comments_popup_link();
?>
		</header><!-- .entry-header -->

		<?php
		if (weaverii_show_only_title()) {
			echo("\t</article><!-- #post -->\n");
			return;
		}
		if ( weaverii_do_excerpt() ) : // Only display Excerpts for Search ?>
		<div class="entry-summary">
			<?php weaverii_the_excerpt_featured(); ?>
		</div><!-- .entry-summary -->
		<?php else : ?>
		<div class="entry-content">
			<?php weaverii_the_contnt_featured(); ?>
			<?php wp_link_pages( array( 'before' => '<div class="page-link"><span>' . __( 'Pages:','weaver-ii') . '</span>', 'after' => '</div>' ) ); ?>
		</div><!-- .entry-content -->
		<?php endif;
		weaverii_format_posted_on_footer('aside');
?>

<?php		    weaverii_inject_area('postpostcontent');	// inject post comment body ?>
	</article><!-- #post-<?php the_ID(); ?> -->
