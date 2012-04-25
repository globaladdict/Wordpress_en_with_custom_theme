<?php
/**
 * Template Name: Sitemap
 *
 * This is the template that displays all pages by default.
 * Please note that this is the wordpress construct of pages
 * and that other 'pages' on your wordpress site will use a
 * different template.
 */
weaverii_get_header('sitemap');
if ( weaverii_getopt('wii_infobar_location') == 'top' ) get_template_part('infobar');
weaverii_inject_area('premain');
echo("\t<div id=\"main\">\n");
weaverii_trace_template(__FILE__);
weaverii_get_sidebar_left('sitemap');
?>
	<div id="container_wrap"<?php weaverii_get_page_class('sitemap'); ?>>
<?php	if (weaverii_getopt('wii_infobar_location') == 'content') get_template_part('infobar');
	weaverii_inject_area('precontent'); ?>
	    <div id="container">
<?php	    weaverii_get_sidebar_top('sitemap'); ?>

		<div id="content" role="main">
<?php		weaverii_post_count_clear();
		the_post();
		get_template_part( 'content', 'sitemap' );
		comments_template( '', true ); ?>

		</div><!-- #content -->
<?php	    weaverii_get_sidebar_bottom('sitemap'); ?>
	    </div><!-- #container -->
	</div><!-- #container_wrap -->

<?php	weaverii_get_sidebar_right('sitemap');
	weaverii_get_footer('sitemap');
?>
