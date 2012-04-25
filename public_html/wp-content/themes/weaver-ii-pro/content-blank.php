<?php
/**
 * The default template for displaying content
 *
 * Displays content from blank page template - just the content...
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

	<div id="post-<?php the_ID(); ?>" <?php post_class('content-blank ' . weaverii_post_count_class()); ?>>
<?php 	weaverii_the_contnt_featured();
 	wp_link_pages( array( 'before' => '<div class="page-link"><span>' . __( 'Pages:','weaver-ii') . '</span>', 'after' => '</div>' ) ); ?>
	</div><!-- #post-<?php the_ID(); ?> -->
