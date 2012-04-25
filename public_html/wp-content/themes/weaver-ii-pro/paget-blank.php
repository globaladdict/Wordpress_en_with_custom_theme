<?php
/**
 * Template Name: Blank
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages
 * and that other 'pages' on your WordPress site will use a
 * different template.
 *
 * @package WordPress
 * @subpackage Weaver II
 * @since Weaver II 1.0
 */

weaverii_get_header('page-blank');
if ( weaverii_getopt('wii_infobar_location') == 'top' ) get_template_part('infobar');
weaverii_inject_area('premain');
echo("\t<div id=\"main\">\n");
weaverii_trace_template(__FILE__);
weaverii_get_sidebar_left('page-blank');
?>
		<div id="container_wrap"<?php weaverii_get_page_class('page'); ?>>
<?php		if (weaverii_getopt('wii_infobar_location') == 'content') get_template_part('infobar');
		weaverii_inject_area('precontent'); ?>
		<div id="container">
<?php		weaverii_get_sidebar_top('page'); ?>

			<div id="content" role="main">

				<?php weaverii_post_count_clear(); the_post(); ?>

				<?php get_template_part( 'content', 'blank' ); ?>

				<?php comments_template( '', true ); ?>

			</div><!-- #content -->
<?php		weaverii_get_sidebar_bottom('page-blank'); ?>
		</div><!-- #container -->
		</div><!-- #container_wrap -->

<?php	weaverii_get_sidebar_right('page-blank');
	weaverii_get_footer('page-blank');
?>
