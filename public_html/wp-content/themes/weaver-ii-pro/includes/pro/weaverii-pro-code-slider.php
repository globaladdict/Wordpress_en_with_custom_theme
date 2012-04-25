<?php
/*
Weaver II Pro Slider - Version 1.0

CODE

This code is Copyright 2011 by Bruce Wampler, all rights reserved.
This code is licensed under the terms of the accompanying license file: license.html.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.

*/
global $weaveriip_slider_opts;
    $weaveriip_slider_opts = array('_number_images',  '_vertical', '_hidetext', '_img_height', '_img_width', '_menu_width',
			 '_text_font', '_borders', '_vert_compress','_note', '_noeffects', '_menu');

define('WEAVERII_TEXT_FONT', 'font-weight:bold; font-size:24px; font-family:Arial,sans-serif; color:white; line-height:1.5em; text-decoration:none;  text-align:left; text-indent:10px; text-shadow:3px 3px 4px #000;');

define('WEAVERII_BORDERS', 'padding-top:3px; padding-bottom:3px; border-top:1px solid black; border-bottom:1px solid black;');

function weaveriip_has_slider() {return true;}

function weaveriip_slider_init() {
    global $weaveriip_slider_opts;

    if (!weaverii_pro_isset('slider_enable')) weaverii_pro_setopt('slider_enable', false);
    if (!weaverii_pro_isset('slider_number_sliders')) weaverii_pro_setopt('slider_number_sliders', 1);


    for ($i = 1 ; $i <= weaverii_pro_getopt('slider_number_sliders') ; $i++) {	// init opts for each slider
	$sname = 'slider' . $i;
	$stitle = 'Slider ' . $i;

	foreach ($weaveriip_slider_opts as $curopt) {
	    if (!weaverii_pro_isset($sname . $curopt)) {		// set to default values
		switch ($curopt) {
		case '_number_images':
		    weaverii_pro_setopt($sname . $curopt, '7');
		    break;
		case '_noeffects':
		    weaverii_pro_setopt($sname . $curopt, false);
		    break;
		case '_vertical':
		    weaverii_pro_setopt($sname . $curopt, false);
		    break;
		case '_vert_compress':
		    weaverii_pro_setopt($sname . $curopt, '50');
		    break;
		case '_hidetext':
		    weaverii_pro_setopt($sname . $curopt, false);
		    break;
		case '_img_height':
		    weaverii_pro_setopt($sname . $curopt, '200');
		    break;
		case '_note':
		    weaverii_pro_setopt($sname . $curopt, 'Enter a useful note about this slider.');
		    break;
		case '_menu_width':
		    weaverii_pro_setopt($sname . $curopt, weaveriip_default_int(weaverii_getopt('wii_header_image_width'),20,2048,940));
		    break;
		case '_img_width':
		    weaverii_pro_setopt($sname . $curopt, '320');
		    break;
		case '_text_font':
		    weaverii_pro_setopt($sname . $curopt, WEAVERII_TEXT_FONT);
		    break;
		case '_borders':
		    weaverii_pro_setopt($sname . $curopt, WEAVERII_BORDERS);
		    break;

		default:
		    weaverii_pro_setopt($sname . $curopt, false);
		}
	    }
	}
	for ($j = 1 ; $j <= 8 ; $j++ ) {
	    if (!weaverii_pro_isset($sname . '_img' . $j))
		weaverii_pro_setopt($sname . '_img' . $j, '');
	}
    }
    weaverii_pro_update_options('slider_init1');
}

function weaveriip_save_slider() {
    /* save options */
    global $weaveriip_slider_opts;

    if (!weaverii_pro_isset('slider_number_sliders')) weaveriip_slider_init();

    if (isset($_POST['slider_enable'])) { weaverii_pro_setopt('slider_enable', 'checked');  }
    else { weaverii_pro_setopt('slider_enable', false); }
    if (isset($_POST['slider_number_sliders'])) { weaverii_pro_setopt('slider_number_sliders', weaveriip_default_int($_POST['slider_number_sliders'], 1, 10, 1));  }
    else { weaverii_pro_setopt('slider_number_sliders', 1); }

    weaverii_pro_update_options('slider save slider2');	// need the slider_number_sliders
    weaveriip_slider_init();	// need to do this every time because might be increasing # of sliders

    $limit = weaverii_pro_getopt('slider_number_sliders');
    for ($i = 1 ; $i <= $limit ; $i++) {	// save opts for each slider
	$sname = 'slider' . $i;

	foreach ($weaveriip_slider_opts as $curopt) {
	    if (isset($_POST[$sname . $curopt])) {		// set to default values
		switch ($curopt) {
		case '_number_images':
		    weaverii_pro_setopt($sname . $curopt, weaveriip_default_int($_POST[$sname . $curopt], 2, 8, 7));
		    break;
		case '_noeffects':
		    weaverii_pro_setopt($sname . $curopt, 'checked');
		    break;
		case '_vertical':
		    weaverii_pro_setopt($sname . $curopt, 'checked');
		    break;
		case '_hidetext':
		    weaverii_pro_setopt($sname . $curopt, 'checked');
		    break;
                case '_menu':
                    weaverii_pro_setopt($sname . $curopt, $_POST[$sname . $curopt]);
		    break;
		case '_vert_compress':
		    weaverii_pro_setopt($sname . $curopt, weaveriip_default_int($_POST[$sname . $curopt], 10, 500, 50));
		    break;
		case '_img_height':
		    weaverii_pro_setopt($sname . $curopt, weaveriip_default_int($_POST[$sname . $curopt], 32, 1024, 200));
		    break;
		case '_img_width':
		    weaverii_pro_setopt($sname . $curopt, weaveriip_default_int($_POST[$sname . $curopt], 32, 1024, 320));
		    break;
		case '_menu_width':
		    weaverii_pro_setopt($sname . $curopt, weaveriip_default_int($_POST[$sname . $curopt],20,2048,940));
		    break;
		case '_note':
		    weaverii_pro_setopt($sname . $curopt, weaverii_filter_textarea($_POST[$sname . $curopt]));
		    break;
		case '_text_font':
		    weaverii_pro_setopt($sname . $curopt, weaverii_filter_textarea($_POST[$sname . $curopt]));
		    if (weaverii_pro_getopt($sname . $curopt) == '')
			weaverii_pro_setopt($sname . $curopt, WEAVERII_TEXT_FONT);
		    break;
		case '_borders':
		    weaverii_pro_setopt($sname . $curopt, weaverii_filter_textarea($_POST[$sname . $curopt]));
		    if (weaverii_pro_getopt($sname . $curopt) == '')
			weaverii_pro_setopt($sname . $curopt, WEAVERII_BORDERS);
		    break;

		default:
		    weaverii_pro_setopt($sname . $curopt, false);
		}
	    } else {		// for checkboxes
		switch ($curopt) {
		case '_noeffects':
		    weaverii_pro_setopt($sname . $curopt, false);
		    break;
		case '_vertical':
		    weaverii_pro_setopt($sname . $curopt, false);
		    break;
		case '_hidetext':
		    weaverii_pro_setopt($sname . $curopt, false);
		    break;
		}
	    }
	}
	for ($j = 1 ; $j <= 8 ; $j++ ) {
	    if (isset($_POST[$sname . '_img' . $j]) ) {
		weaverii_pro_setopt($sname . '_img' . $j, weaverii_filter_textarea($_POST[$sname . '_img' . $j]));
	    }
	}

    }

    weaverii_pro_update_options('slider 3');

    /* and let the user know something happened */
    echo '<div id="message" class="updated fade"><p><strong>Weaver Slider Options Saved</strong></p></div>';
}

function weaveriip_slider_scripts() {
    // Use wp_enqueue_script to add scripts - called from header.php
    if (!weaverii_pro_getopt('slider_enable') ) return;

    $url =  trailingslashit(get_template_directory_uri());
    wp_enqueue_script('weaverMooTools', $url.'includes/pro/slider-js/mootools-core-yc.js');
    wp_enqueue_script('weaverMooToolsMore', $url.'includes/pro/slider-js/mootools-more-min.js');
    wp_enqueue_script('weaverBySliderMenu', $url.'includes/pro/slider-js/byslidemenu-min.js');
}

function weaveriip_slider_header_insert() {
    /* This is called from header.php, and will insert code into the #branding div of the header.
    */
}

function weaveriip_slider_output_style($sout) {

    if (!weaverii_pro_isset('slider_number_sliders')) weaveriip_slider_init();
    if (!weaverii_pro_getopt('slider_enable') ) return;

    weaverii_f_write($sout,"/* Weaver II Pro Slider CSS */\n");

    for ($i = 1 ; $i <= weaverii_pro_getopt('slider_number_sliders') ; $i++) { // build CSS for each slider
	$sname = 'slider' . $i;
	$iheight = weaverii_pro_getopt($sname.'_img_height');
	$iwidth = weaverii_pro_getopt($sname.'_img_width');
	weaverii_f_write($sout,sprintf("#weaver-%s img {margin:0;max-width:%dpx;}\n",$sname,$iwidth));
	weaverii_f_write($sout,sprintf("#weaver-%s {clear:both;width:%dpx;%s}\n",$sname,weaverii_pro_getopt($sname.'_menu_width'),weaverii_pro_getopt($sname.'_borders')));
	// !importants needed to make work right in sidebar
	weaverii_f_write($sout,sprintf("#weaver-%s ul {position:relative;overflow:hidden;margin:0px !important;padding:0px !important;list-style-type:none !important;}\n",
	    $sname));
	weaverii_f_write($sout,sprintf(".weaver-link-%s {position:absolute;%s}\n",$sname,weaverii_pro_getopt($sname . '_text_font')));
	if (weaverii_pro_getopt($sname . '_noeffects')) {
	    if (weaverii_pro_getopt($sname . '_vertical')) {
		weaverii_f_write($sout,sprintf("#weaver-%s li {position:relative !important; width:%dpx;height: %dpx;}\n",
		    $sname,$iwidth,$iheight));
	    } else {
		weaverii_f_write($sout,sprintf("#weaver-%s li {position:relative; width:%dpx;height: %dpx;clear:both !important;display:inline !important;}\n",
		    $sname,$iwidth,$iheight));
	    }
	} else {
	    weaverii_f_write($sout,sprintf("#weaver-%s li {position:absolute; width:%dpx;height: %dpx;}\n",
		$sname,$iwidth,$iheight));
	}
    }
}

function weaveriip_slider_shortcode($args='') {
    extract(shortcode_atts(array(
	'id' => '1'
    ), $args));

    if (!weaverii_pro_getopt('slider_enable')) {
	return "<strong>[weaver_slider] shortcode used, but option not enabled.</strong>";
    }
    $sname = 'slider' . $id;
    if (!weaverii_pro_isset($sname.'_menu'))
    {
	return "<strong>[weaver_slider id=$id] shortcode used, but Slider $id not defined.</strong>";
    }

    $out = "<!-- Weaver Slider Shortcode -->\n";
    $out .= '<div id="weaver-slider' . $id . "\" class=\"weaver-slider\">\n";

    if ( weaverii_pro_getopt($sname.'_menu') != '' ) {
	$menu_items = wp_get_nav_menu_items(weaverii_pro_getopt($sname.'_menu'));
	$menu_list = '<ul id="menu-' . $sname . '">';
	$img_num = 1;
	foreach ( (array) $menu_items as $key => $menu_item ) {
	    $title = $menu_item->title;
	    $url = $menu_item->url;
	    $img_url = weaverii_pro_getopt($sname . '_img' . $img_num);
	    if ($img_url == '') {
		if (weaverii_pro_getopt($sname . '_vertical'))
		    $img_url = weaverii_relative_url('includes/pro/images/' . $img_num . '-v.jpg');
		else
		    $img_url = weaverii_relative_url('includes/pro/images/' . $img_num . '.jpg');
	    }
	    $menu_list .= '<li>';
	    if (!weaverii_pro_getopt($sname . '_hidetext'))
		$menu_text = '<span class="weaver-link-' . $sname . '">' . $title . '</span>';
	    else
		$menu_text = '';

	    $menu_list .= '<a href="' . $url . '" title="' . $title . '" style="text-decoration:none;">'
	        . $menu_text . '<img src="' . $img_url . '" /></a></li>' . "\n";

	    $img_num++;
	    if ($img_num > weaverii_pro_getopt($sname . '_number_images'))
		break;
	}
	for (; $img_num <= weaverii_pro_getopt($sname . '_number_images') ; $img_num++) {
	    $img_url = weaverii_pro_getopt($sname . '_img' . $img_num);
	    if ($img_url == '') {
		if (weaverii_pro_getopt($sname . '_vertical'))
		    $img_url = weaverii_relative_url('includes/pro/images/' . $img_num . '-v.jpg');
		else
		    $img_url = weaverii_relative_url('includes/pro/images/' . $img_num . '.jpg');
	    }
	    $menu_list .= '<li><img src="' . $img_url . '" /></li>' . "\n";
	}

	$menu_list .= '</ul>';
    } else {
	$menu_list = "<h3>[weaver_slider id=$id]: Menu not yet selected or defined.</h3>\n";
    }
    // $menu_list now ready to output

    $out .= $menu_list;

    $out .= "\n" . '</div> <!-- #weaver-slider' . $id . " -->\n";
    //$out .= '<div style="clear:both;"></div>' . "\n";

    /* compressSize = (MenuWidth-ImageWidth) / (NumImages-1)  (just for horizontal - use 50 for vertical) */
    $compressSize = (weaverii_pro_getopt($sname . '_menu_width') - weaverii_pro_getopt($sname . '_img_width')) / (weaverii_pro_getopt($sname . '_number_images') - 1);
    $vertical = 'false';
    if (weaverii_pro_getopt($sname . '_vertical')) {
	$compressSize = weaverii_pro_getopt($sname . '_vert_compress');
	$vertical = 'true';
    }
    if (!weaverii_pro_getopt($sname . '_noeffects')) {	// no js for this menu
$out .= "<script type=\"text/javascript\">window.addEvent('load', function(){
new BySlideMenu({
'container' : 'menu-$sname',
'selector' : 'li',
'compressSize' : $compressSize,
'vertical' : $vertical
}); });</script>\n";
    }

    return $out;
}

add_shortcode('weaver_slider','weaveriip_slider_shortcode');
?>
