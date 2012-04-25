<?php
// This file is included from functions.php. It will be loaded only when the wp_head action is called from WordPress.

if ( ! function_exists( 'weaverii_generate_wphead()' ) ) :	/* Allow child to override this */
function weaverii_generate_wphead() {
    /* this guy does ALL the work for generating theme look - it writes out the over-rides to the standard style.css */
    global $weaverii_main_options, $weaverii_cur_page_ID;

    global $post;
    $weaverii_cur_page_ID = 0;	// need this for 404 page when this is not valid
    if (is_object($post))
	$weaverii_cur_page_ID = get_the_ID();	// we're on a page now, so set the post id for the rest of the session

    printf("\n<!-- This site is using %s %s (%s) subtheme: %s -->\n",WEAVERII_THEMENAME, WEAVERII_VERSION, weaverii_getopt('wii_style_version'), weaverii_getopt('wii_subtheme'));

    if (!weaverii_getopt('_wii_hide_metainfo'))
	echo(weaverii_getopt('_wii_metainfo')."\n");

    // handle 3 stylesheet situations
    //	default: used weaver-style.css
    //	no weaver-style.css: when first installed, there will not be a weaver-style.css, so use inline instead
    //	force inline: user wants inline css

    if (weaverii_use_inline_css( weaverii_get_css_filename() )) { // generate inline CSS
	    require_once('generatecss.php'); 	// include only now at runtime.
	    echo('<style type="text/css">'."\n");
	    $output = weaverii_f_open('php://output','w+');
	    weaverii_output_style($output);
	    echo("</style> <!-- end of main options style section -->\n");
    }

    if (weaverii_dev_mode() && weaverii_getopt_checked('_wii_diag_borders')) {
?>
<style type="text/css">
#content,#colophon,#branding,.widget,#infobar,.widget-area {border: 1px solid #F00 !important;}
#wrapper,#container,#main{border: 1px solid blue;}
</style>
<?php
    }

   /* now head options */
    echo(weaverii_getopt('wii_theme_head_opts'));
    echo(weaverii_getopt('wii_head_opts'));		/* let the user have the last word! */

    $per_page_code = weaverii_get_per_page_value('page-head-code');
    if (!empty($per_page_code)) {
	echo($per_page_code);
    }

    weaverii_mobile_style();

    weaverii_fix_IE();

    echo("\n<!-- End of Weaver II options -->\n");

}
endif;

function weaverii_mobile_style() {
    global $weaverii_mobile;
     if (!$weaverii_mobile)
	return;				// not mobile
    if (!weaverii_use_mobile('any')) {	// must be in full screen mode
?>
<style type="text/css" media="screen">
<?php
    $themew = weaverii_getopt('wii_theme_width_int');
    if (!$themew) $themew = 940;	// just must have this value!
      	echo (sprintf("#wrapper{width:%dpx;}\n",$themew));	// let mobile browser see full site
?>
</style>
<?php
        return;
    }
?>
<!-- mobile options -->
<style type="text/css" media="screen">
<?php
    switch (weaverii_get_mobile_browser()) {
	case 'WeaverMobile':
	case 'WeaverMobileFlat':
	    echo ("#wrapper {width:320px !important;border:1px dotted #888;}\n");	// generic QVGA resolution
	    break;
	case 'WeaverMobileSmallTablet':
	    echo ("#wrapper {width:600px !important;border:1px dotted #888;}\n");	// small tablet
	    break;
	case 'WeaverMobileTablet':
	    echo ("#wrapper {width:768px !important;border:1px dotted #888;}\n");	// iPad1, iPad2
	    break;
	default:
	    break;
    }
/*
text_color = 0.213 * this.rgb[0] +
	    0.715 * this.rgb[1] +
	    0.072 * this.rgb[2]
	    < 0.5 ? '#FFF' : '#000';
*/
    if (!weaverii_getopt_checked('wii_use_superfish') )	// add alt-arrows for browser
    {
	$arrows = weaverii_getopt('wii_superfish_arrows');
	if ($arrows) {	/* user provided an alternative */
	    $url = weaverii_relative_url('js/superfish/images/arrows-' . $arrows . '.png');
	    echo ".sf-sub-indicator {background: url($url) no-repeat -10px -100px;}\n";
	}
    }
    if (weaverii_use_mobile('phone') || weaverii_use_mobile('smalltablet')) {
?>
body {font-size:13px;padding:0px;}
<?php
// settable options
	if (($opt = weaverii_getopt_color('wii_mobile_title_color'))) {
	echo "#site-title a{color:$opt;}\n";
	}
	if (!weaverii_getopt_checked('wii_mobile_nounderline')) {
?>
#main a, #mobile-widget-area a,.sidebar_top a, .sidebar_bottom a,.sidebar_extra a{text-decoration:underline !important;}
<?php
	}
    if (($opt = weaverii_getopt('_wii_mobile_css')))
	echo $opt;

    }	// touch or mobile
    if ($weaverii_mobile['type'] == 'tablet') {
?>

<?php
if (!weaverii_getopt_checked('wii_mobile_keep_site_margins')) {
?>
body {padding:0px;}
#wrapper {padding: 4px;}
<?php
}
if (!weaverii_getopt_checked('wii_mobile_tablet_nounderline')) {
?>
#main a, #mobile-widget-area a,.sidebar_top a, .sidebar_bottom a,.sidebar_extra a{text-decoration:underline !important;}
<?php
	}
    }
?>
</style>
<?php
}

function weaverii_fix_IE() {
    $add_PIE = (weaverii_getopt('wii_rounded_corners') || weaverii_getopt('wii_rounded_corners_content') || weaverii_getopt('wii_wrap_shadow')) && !weaverii_getopt('_wii_hide_PIE');
    echo("\n");
    if ($add_PIE) { ?>
<!--[if lte IE 8]>
<style type="text/css" media="screen">
<?php  weaverii_bake_PIE(); ?>
</style>
<![endif]-->
<?php
    }
}

function weaverii_bake_PIE() {
/**
* Attach CSS3PIE behavior to elements
* Add elements here that need PIE applied
*/
   $pie_loc = get_template_directory_uri() . '/js/PIE/PIE.php';

    echo("#wrapper, #branding, #colophon, #content, #content .post,  #sidebar_primary,#sidebar_right,#sidebar_left,.sidebar_top,.sidebar_bottom,.sidebar_extra,#first,#second,#third,#fourth {
  behavior: url($pie_loc) !important; position:relative; }\n");
}
?>
