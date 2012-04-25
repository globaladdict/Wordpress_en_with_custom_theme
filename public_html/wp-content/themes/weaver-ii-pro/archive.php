<?php
/**
 * The template for displaying Archive pages.
 *
 * Used to display archive-type pages if nothing more specific matches a query.
 * For example, puts together date-based pages if no date.php file exists.
 *
 * Learn more: http://codex.wordpress.org/Template_Hierarchy
 *
 * @package WordPress
 * @subpackage Weaver II
 * @since Weaver II 1.0
 */

weaverii_get_header('archive');
if ( weaverii_getopt('wii_infobar_location') == 'top' ) get_template_part('infobar');
weaverii_inject_area('premain');
echo("\t<div id=\"main\">\n");
weaverii_trace_template(__FILE__);
weaverii_get_sidebar_left('archive');
?>
		<div id="container_wrap"<?php weaverii_get_page_class('archive'); ?>>
<?php		if (weaverii_getopt('wii_infobar_location') == 'content') get_template_part('infobar');
		weaverii_inject_area('precontent'); ?>
		<section id="container">
<?php		weaverii_get_sidebar_top('archive'); ?>
			<div id="content" role="main">

<?php 			if ( have_posts() ) { ?>

				<header class="page-header">
					<h1 class="page-title archive-title"><span class="archive-title-label">
<?php 						if ( is_day() ) {
 							printf( __( 'Daily Archives: %s','weaver-ii'), '</span><span>' . get_the_date() . '</span>' );
						} else if ( is_month() ) {
							printf( __( 'Monthly Archives: %s','weaver-ii'), '</span><span>' . get_the_date( 'F Y' ) . '</span>' );
						} else if ( is_year() ) {
							printf( __( 'Yearly Archives: %s','weaver-ii'), '</span><span>' . get_the_date( 'Y' ) . '</span>' );
						} else {
							_e( 'Blog Archives','weaver-ii'); echo('</span>');
						}
?>
					</h1>
				</header>

<?php 				weaverii_content_nav( 'nav-above' );
				/* Start the Loop */
				weaverii_post_count_clear();
				while ( have_posts() ) {
					the_post();
					weaverii_post_count_bump();

					/* Include the Post-Format-specific template for the content.
					 * If you want to overload this in a child theme then include a file
					 * called content-___.php (where ___ is the Post Format name) and that will be used instead.
					 */
					get_template_part( 'content', get_post_format() );
				}

				weaverii_content_nav( 'nav-below' );

			} else { ?>

				<article id="post-0" class="post no-results not-found">
					<header class="entry-header">
						<h1 class="entry-title"><?php _e( 'Nothing Found','weaver-ii'); ?></h1>
					</header><!-- .entry-header -->

					<div class="entry-content">
						<p><?php _e( 'Apologies, but no results were found for the requested archive. Perhaps searching will help find a related post.','weaver-ii'); ?></p>
<?php 						get_search_form(); ?>
					</div><!-- .entry-content -->
				</article><!-- #post-0 -->

<?php 			} ?>

			</div><!-- #content -->
<?php		weaverii_get_sidebar_bottom('archive'); ?>
		</section><!-- #container -->
		</div><!-- #container_wrap -->

<?php 	weaverii_get_sidebar_right('archive');
	weaverii_get_footer('archive');
?>
