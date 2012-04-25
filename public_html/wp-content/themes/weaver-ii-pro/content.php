<?php
/**
 * The default template for displaying content
 *
 * This will display blog posts from main blog page and archive-type pages
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

	<article id="post-<?php the_ID(); ?>" <?php post_class('content-default ' . weaverii_post_count_class() ); ?>>
		<header class="entry-header">
<?php 		if (is_sticky() ) {
			weaverii_entry_header(''); ?>
<?php 		} else {
			weaverii_post_title('<hgroup class="entry-hdr"><h2 class="entry-title">', "</h2></hgroup>\n");
		}

		if ( 'page' != get_post_type() ) { ?>
			<div class="entry-meta">
				<?php weaverii_post_top_info(); ?>
			</div><!-- .entry-meta -->
<?php 		}
		weaverii_comments_popup_link(); ?>
		</header><!-- .entry-header -->

<?php		if (weaverii_show_only_title()) {
			echo("\t</article><!-- #post -->\n");
			return;
		}
		if ( weaverii_do_excerpt()) { // Only display Excerpts for Search ?>
		<div class="entry-summary">
<?php 			weaverii_the_excerpt_featured(); ?>
		</div><!-- .entry-summary -->
<?php 		} else { ?>
		<div class="entry-content">
<?php 			weaverii_the_contnt_featured();
 			wp_link_pages( array( 'before' => '<div class="page-link"><span>' . __( 'Pages:','weaver-ii') . '</span>', 'after' => '</div>' ) ); ?>
		</div><!-- .entry-content -->
<?php 		} ?>

		<footer class="entry-utility">
<?php		weaverii_post_bottom_info(); ?>
		</footer><!-- #entry-utility -->
<?php		    weaverii_inject_area('postpostcontent');	// inject post comment body ?>
	</article><!-- #post-<?php the_ID(); ?> -->
