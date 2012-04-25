<?php
/**
 * The main template file.
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * E.g., it puts together the home page when no home.php file exists.
 * Learn more: http://codex.wordpress.org/Template_Hierarchy
 *
 * @package WordPress
 * @subpackage Weaver II
 */

weaverii_get_header('index');
if ( weaverii_getopt('wii_infobar_location') == 'top' ) get_template_part('infobar');
weaverii_inject_area('premain');
echo("\t<div id=\"main\">\n");
weaverii_trace_template(__FILE__);
weaverii_get_sidebar_left('index');
?>
		<div id="container_wrap"<?php weaverii_get_page_class('index'); ?>>
<?php		if ( weaverii_getopt('wii_infobar_location') == 'content' ) get_template_part('infobar');
		weaverii_inject_area('precontent'); ?>
		<div id="container" class="index-posts">
<?php		weaverii_get_sidebar_top('index'); ?>
		    <div id="content" role="main">

			<?php if ( have_posts() ) {

			    weaverii_content_nav( 'nav-above' );
			    $col = 0;
			    $num_cols = weaverii_use_mobile('mobile') ? 1 : weaverii_getopt('wii_blog_cols');
			    if (!$num_cols || $num_cols > 3) $num_cols = 1;

			    /* Start the Loop */
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
				}   // end switch num cols
			    }	// end while have posts

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
<?php 			} ?>

		    </div><!-- #content -->
<?php		weaverii_get_sidebar_bottom('index'); ?>
		</div><!-- #container -->
		</div><!-- #container_wrap -->

<?php 	weaverii_get_sidebar_right('index');
	weaverii_get_footer('index');
?>
