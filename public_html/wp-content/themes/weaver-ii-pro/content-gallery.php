<?php
/**
 * The template for displaying posts in the Gallery Post Format on index and archive pages
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

<article id="post-<?php the_ID(); ?>" <?php post_class('content-gallery ' . weaverii_post_count_class()); ?>>
	<header class="entry-header">
<?php 	weaverii_entry_header(__( 'Gallery','weaver-ii')); ?>

		<div class="entry-meta">
			<?php weaverii_post_top_info(); ?>
		</div><!-- .entry-meta -->
	</header><!-- .entry-header -->

	<?php
	    if (weaverii_show_only_title()) {
		echo("\t</article><!-- #post -->\n");
		return;
	    }
	    if ( weaverii_do_excerpt() ) : // Only display Excerpts for search pages ?>
		<div class="entry-summary">
			<?php weaverii_the_excerpt_featured(); ?>
		</div><!-- .entry-summary -->
		<?php else : ?>
		<div class="entry-content">
			<?php if ( post_password_required() ) : ?>
				<?php weaverii_the_contnt_featured(); ?>

			<?php else : ?>
				<?php
					$images = get_children( array( 'post_parent' => $post->ID, 'post_type' => 'attachment', 'post_mime_type' => 'image', 'orderby' => 'menu_order', 'order' => 'ASC', 'numberposts' => 999 ) );
					if ( $images ) :
						$total_images = count( $images );
						$image = array_shift( $images );
						$image_img_tag = wp_get_attachment_image( $image->ID, 'thumbnail' );
				?>

				<figure class="gallery-thumb">
					<a href="<?php the_permalink(); ?>"><?php echo $image_img_tag; ?></a>
				</figure><!-- .gallery-thumb -->

				<p><em><?php printf( _n( 'This gallery contains <a %1$s>%2$s photo</a>.', 'This gallery contains <a %1$s>%2$s photos</a>.', $total_images,'weaver-ii'),
						'href="' . esc_url( get_permalink() ) . '" title="' . sprintf( esc_attr__( 'Permalink to %s','weaver-ii'), the_title_attribute( 'echo=0' ) ) . '" rel="bookmark"',
						number_format_i18n( $total_images )
					); ?></em></p>
			<?php endif; ?>
			<?php weaverii_the_excerpt_featured(); ?>
		<?php endif; ?>
		<?php wp_link_pages( array( 'before' => '<div class="page-link"><span>' . __( 'Pages:','weaver-ii') . '</span>', 'after' => '</div>' ) ); ?>
	</div><!-- .entry-content -->
	<?php endif; ?>

	<footer class="entry-utility">
	    <?php weaverii_post_bottom_info(); ?>
	</footer><!-- #entry-utility -->
<?php		    weaverii_inject_area('postpostcontent');	// inject post comment body ?>
</article><!-- #post-<?php the_ID(); ?> -->
