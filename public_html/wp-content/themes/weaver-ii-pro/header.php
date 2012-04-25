<?php
/**
 * The Header for our theme.
 *
 * Displays all of the <head> section and everything up till < div id="main" >
 *
 * @package WordPress
 * @subpackage Weaver II
 * @since Weaver II 1.0
 */
weaverii_setup_mobile();
?><!DOCTYPE html>
<!--[if IE 6]>
<html id="ie6" <?php language_attributes(); ?>>
<![endif]-->
<!--[if IE 7]>
<html id="ie7" <?php language_attributes(); ?>>
<![endif]-->
<!--[if IE 8]>
<html id="ie8" <?php language_attributes(); ?>>
<![endif]-->
<!--[if IE 9]>
<html id="ie9" <?php language_attributes(); ?>>
<![endif]-->
<!--[if !(IE 6) | !(IE 7) | !(IE 8) ] | !(IE 9) ><!-->
<html <?php language_attributes(); ?>>
<!--<![endif]-->
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>" />
<meta name='viewport' content='width=device-width, initial-scale=1.0, maximum-scale=2.0, user-scalable=yes' />
<title><?php		// ++++++ HEAD TITLE ++++++
    wp_title('');		// the title - will run through our filter
?></title>

<link rel="profile" href="http://gmpg.org/xfn/11" />
<?php
if (($custom = weaverii_getopt('wii_custom_style')) != '')	// set which style sheet we are using
    $sheet = $custom;
else if (weaverii_getopt_checked('wii_minimial_style'))
    $sheet = weaverii_relative_url('style-minimal.css');
else
    $sheet = get_bloginfo( 'stylesheet_url' );
?>
<link rel="stylesheet" type="text/css" media="all" href="<?php echo $sheet; ?>" />
<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>" />
<!--[if lt IE 9]>
<script src="<?php echo get_template_directory_uri(); ?>/js/html5.js" type="text/javascript"></script>
<![endif]-->

<?php			// ++++ CSS AND CUSTOM SCRIPTS ++++
    $icon = weaverii_getopt('_wii_favicon_url');
    if ($icon != '') {
	$url = parse_url($icon,PHP_URL_PATH);
	echo "<link rel=\"shortcut icon\"  href=\"$url\" />\n";
    }
    $icon = weaverii_getopt('_wii_apple_touch_icon_url');
    if ($icon != '') {
	$url = parse_url($icon,PHP_URL_PATH);
	echo "<link rel=\"apple-touch-icon\"  href=\"$url\" />\n";
    }
    weaverii_facebook_meta();

    if (WEAVERII_FORCE_RTL) {
	wp_register_style('weaverii-rtl-style-sheet',weaverii_relative_url('rtl.css'));
	wp_enqueue_style('weaverii-rtl-style-sheet');
    }

    if (!weaverii_use_inline_css(weaverii_get_css_filename())) { // don't generate inline CSS
	$vers = weaverii_getopt('wii_style_version');
	if (!$vers) $vers = '1';
	else $vers = sprintf("%d",$vers);
	wp_register_style('weaverii-style-sheet',weaverii_get_css_url(),array(),$vers);
	wp_enqueue_style('weaverii-style-sheet');
    }

    weaverii_pro_wp_head();	// anything needed for Pro Version

    wp_head();

    // follow are runtime scripts that can't be called with enqueue_script

    if (weaverii_getopt('wii_use_superfish') || weaverii_mobile_usesf()) {
	if (!weaverii_mobile_usesf())
	echo("<script type=\"text/javascript\">
jQuery(function(){jQuery('ul.sf-menu').superfish({animation: {opacity:'show',height:'show' }, speed: 300});});
	</script>\n");
	else	// need different stuff for mobile - works better on more browsers
	echo("<script type=\"text/javascript\">
jQuery(function(){jQuery('ul.sf-menu').superfish({ disableHI:true, speed:200, dropshadows:false});});
</script>\n");
    }
    if (weaverii_getopt_checked('wvr_flow_to_bottom')) {
?>
<script type="text/javascript">
jQuery(window).load(function() {
	jQuery(".equal_height").equalHeights();
});
</script>
<?php
    }
    if (weaverii_getopt('wii_hide_tooltip')) {
?>
<script type="text/javascript">
jQuery(document).ready(function() {
jQuery('a[title]').mouseover(function(e) {
var tip = jQuery(this).attr('title');
jQuery(this).attr('title','');
}).mouseout(function() {
jQuery(this).attr('title',jQuery('.tipBody').html());
});
});
</script>
<?php

    }
?>
</head>

<body <?php body_class(); ?>>
<?php
    weaverii_trace_template(__FILE__);
    weaverii_trace_mobile();
    weaverii_inject_area('prewrapper');

    if (!weaverii_getopt_checked('wii_header_first'))	// put the header before the wrapper?
        echo "<div id=\"wrapper\" class=\"hfeed\">\n";

    weaverii_inject_area('preheader');

    if (!weaverii_is_checked_page_opt('ttw-hide-header')) {
?>
	<header id="branding" role="banner">
<?php
	    /* ======== SITE LOGO and TITLE ======== */
	    $title = (weaverii_getopt('_wii_mobile_site_title') && weaverii_use_mobile('mobile') )
		? esc_html(weaverii_getopt('_wii_mobile_site_title')) : esc_attr( get_bloginfo( 'name', 'display' ) );
?>
	    <div id="site-logo"<?php weaverii_hide_site_title();?>></div>
	    <div id="site-logo-link" onclick="location.href='<?php echo home_url( '/' ); ?>';" style="cursor:pointer;"<?php weaverii_hide_site_title();?>></div>
	    <hgroup class="title-description">
	    	<h1 id="site-title"<?php echo weaverii_hide_site_title();?>><span><a href="<?php echo esc_url( home_url( '/' ) ); ?>" title="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>" rel="home"<?php weaverii_hide_site_title();?>><?php echo $title; ?></a></span></h1>
			<h2 id="site-description"<?php weaverii_hide_site_title();?>><?php bloginfo( 'description' ); ?></h2>
	    </hgroup>

<?php	    /* ======== TOP MENU ======== */
	    get_template_part('nav','top');
	    weaverii_mobile_toggle('header');	// display toggle button
	    weaverii_inject_area('header');	// inject header HTML

	    get_sidebar('header');

	    weaveriip_header_insert();			// add W-II Pro injection

	    /* The Dynamic Headers shows headers on a per page basis - will also optionally add site link */
	    if (function_exists('show_media_header'))
		show_media_header(); 			// Plugin support: **Dynamic Headers**

	    /* ======== HEADER IMAGE ======== */

	    if (!(weaverii_is_checked_page_opt('ttw-hide-header-image') && !is_search())
		&& !(weaverii_getopt_checked('wii_normal_hide_header_image') && !weaverii_use_mobile('mobile'))
		&& !(weaverii_getopt_checked('wii_mobile_hide_header_image') && weaverii_use_mobile('mobile')) ) {
		if (!weaverii_getopt_checked('wii_hide_header_image') && !(weaverii_getopt('wii_hide_header_image_front') && is_front_page() )) {
		    echo("\t\t<div id=\"header_image\">\n");
		    if (weaverii_getopt('wii_link_site_image')) {
?>
		    <a href="<?php echo home_url( '/' ); ?>" title="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>" rel="home">
<?php
		    }
		    /* Check if this is a post or page, if it has a thumbnail,  and if it's a big one */
		    if ( is_singular() && !weaverii_getopt('wii_hide_featured_header')
		    && has_post_thumbnail( $post->ID )
		    && ($image = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'post-thumbnail' ) )  /* $src, $width, $height */
		    && $image[1] >= HEADER_IMAGE_WIDTH) {
			echo get_the_post_thumbnail( $post->ID, 'post-thumbnail' );
		    } else {
			if (weaverii_use_mobile('mobile') && weaverii_getopt('_wii_mobile_header_url')) {
			    echo '<img src="' . esc_attr(weaverii_getopt('_wii_mobile_header_url')) .
				'" alt="' . esc_attr( get_bloginfo( 'name', 'display' ) ) . '" />' . "\n";
			} else if (weaverii_use_mobile('tablet') && weaverii_getopt('_wii_mobile_tablet_header_url')) {
			    echo '<img src="' . esc_attr(weaverii_getopt('_wii_mobile_tablet_header_url')) .
				'" alt="' . esc_attr( get_bloginfo( 'name', 'display' ) ) . '" />' . "\n";
			} else {
			    $hdr = get_header_image();
			    if ($hdr) {
?>
			<img src="<?php echo $hdr ?>" width="<?php echo HEADER_IMAGE_WIDTH; ?>" height="<?php echo HEADER_IMAGE_HEIGHT; ?>" alt="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>" />
<?php			    } else {	// don't include alt on empty header images
?>
			<img src="" width="<?php echo HEADER_IMAGE_WIDTH; ?>" height="<?php echo HEADER_IMAGE_HEIGHT; ?>" />
<?php			    }
			}
		    }
		    if (weaverii_getopt('wii_link_site_image')) echo("</a>\n");	/* need to close link */
			echo("\t\t</div><!-- #header_image -->\n");
		} /* closes header > 0 */
	    } /* end wii_hide-header-image */

	    /* ======== BOTTOM MENU ======== */

	     get_template_part('nav','bottom');

?>
	</header><!-- #branding -->
<?php
    }	// end hide-header

    if (weaverii_getopt_checked('wii_header_first')) echo "<div id=\"wrapper\" class=\"hfeed\">\n";
?>
