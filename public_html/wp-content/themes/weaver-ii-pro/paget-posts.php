<?php
/**
 * Template Name: Page With Posts
 * Description: A Page Template that will show posts - pretty much like index
 *
 * inject-infobar won't work right on the page-navi until we restart the loop, so...
 *
 * We create the breadcrumbs part for the page.
 * We buffer the output from the inject-prmain up to the end of the page content
 * We create the page-navi part of the infobar after we restart the loop
 * Then output the infobar with the page breadcrumbs and the posts page-navi and the page buffer
 * Finally, start the new loop.
 */

weaverii_get_header('pwp');
// build infobar front part - replace get_template_part('infobar'); with local code
// we need to build it in a buffer
global $weaverii_crumbs;
$weaverii_crumbs = false;	// this is ugly, I know, but it lets us keep keep the inject-info in just one code base

if (!weaverii_getopt_checked('wii_infobar_hide') && !weaverii_is_checked_page_opt('wvr-hide-page-infobar')) { // let's really not include it rather than display:none.

    if (!weaverii_getopt_checked('wii_info_hide_breadcrumbs'))
	$weaverii_crumbs = weaverii_breadcrumb(false);
}
ob_start();		// now build the page part of the PwP
weaverii_inject_area('premain');
echo("\t<div id=\"main\">\n");
weaverii_trace_template(__FILE__);
weaverii_get_sidebar_left('pwp');
$paged = weaverii_get_page();
?>
	    <div id="container_wrap"<?php weaverii_get_page_class('page'); ?>>

<?php	    $page_part1 = ob_get_clean(); // need to split to handle infobar location
	    ob_start();
	    weaverii_inject_area('precontent'); ?>
	    <div id="container" class="page-with-posts">
<?php		weaverii_get_sidebar_top('pwp'); ?>

		<div id="content" role="main">
<?php 		weaverii_post_count_clear(); the_post();
		if ($paged == 1) {	// only show on the first page
		// If we have content for this page, let's display it.
		if (get_the_content() != '' || (get_the_title() != '' && !weaverii_is_checked_page_opt('ttw-hide-page-title')))
		    get_template_part( 'content', 'pwp' );
		}

	$page_part2 = ob_get_clean();

	// Now, the posts
	global $wp_query;
	$old_query = $wp_query;

	$args = array(
	    'orderby' => 'date',
	    'order' => 'DESC',
	    'paged' => $paged
	);
	$args = weaverii_setup_post_args($args);	// setup custom fields for this page
	$wp_query = new WP_Query($args);		// reuse $wp_query to make paging work

	// now, put the infobar
	if ( weaverii_getopt('wii_infobar_location') == 'top' )
	    get_template_part('infobar');	// This will use the global $weaverii_crumbs instead of "current" version
	$weaverii_crumbs = false;		// IMPORTANT - need to clear the global now for the rest of the world
	echo $page_part1;	// and now the page post
	if ( weaverii_getopt('wii_infobar_location') == 'content' )
	    get_template_part('infobar');	// This will use the global $weaverii_crumbs instead of "current" version
	echo $page_part2;	// and now the page post

	if ( have_posts() ) {				// same loop as index.php

	    weaverii_content_nav( 'nav-above' );

	    /* Start the Loop */
	    $col = 0;
	    $num_cols = weaverii_getopt('wii_blog_cols'); // default
	    $pp = weaverii_get_per_page_value('wvr_pwp_cols');
	    if ($pp) $num_cols = $pp;
	    if (weaverii_use_mobile('mobile')) $num_cols = 1;
	    if (!$num_cols || $num_cols > 3) $num_cols = 1;

	    weaverii_post_count_clear();
	    while ( have_posts() ) {
		the_post();
		weaverii_post_count_bump();
		    switch ($num_cols) {
			case 1:
			    get_template_part( 'content', get_post_format() );
			    break;
			case 2:
			    if ($col == 0) {
				echo ('<div class="content-2-col-left">' . "\n");
				get_template_part( 'content', get_post_format() );
				echo ("</div> <!-- left -->\n");
				$col = 1;
			    } else {
				echo ('<div class="content-2-col-right">' . "\n");
				get_template_part( 'content', get_post_format() );
				echo("</div> <!--right--> <div class=\"clear-cols\"></div>\n");
				$col = 0;
			    }
			    break;
			case 3:
			    if ($col < 2) {
				echo ('<div class="content-3-col-left">' . "\n");
				get_template_part( 'content', get_post_format() );
				echo ("</div> <!-- left -->\n");
				$col++;
			    } else {
				echo ('<div class="content-3-col-right">' . "\n");
				get_template_part( 'content', get_post_format() );
				echo("</div> <!--right--> <div class=\"clear-cols\"></div>\n");
				$col = 0;
			    }
			    break;
			default:
			    get_template_part( 'content', get_post_format() );
		    }
	    }
	    if ($num_cols > 1)
		echo("<div class=\"clear-cols\"></div>");

	    weaverii_content_nav( 'nav-below' );
	} else { ?>

	    <article id="post-0" class="post no-results not-found">
		<header class="entry-header">
		    <h1 class="entry-title"><?php _e( 'Nothing Found','weaver-ii'); ?></h1>
		</header><!-- .entry-header -->

		<div class="entry-content">
		    <p><?php _e( 'Apologies, but no results were found for the requested archive. Perhaps searching will help find a related post.','weaver-ii'); ?></p>
		    <?php get_search_form(); ?>
		</div><!-- .entry-content -->
	    </article><!-- #post-0 -->
<?php 	}
		// every thing done, so allow comments?
		// comments_template( '', true );
?>

		</div><!-- #content -->
<?php
		weaverii_get_sidebar_bottom('pwp');
		$wp_query = $old_query; wp_reset_postdata();	// need these so extra-menus work in rightsidebar and footer
?>
	    </div><!-- #container -->
	    </div><!-- #container_wrap -->

<?php	weaverii_get_sidebar_right('pwp');
	weaverii_get_footer('pwp');
?>
