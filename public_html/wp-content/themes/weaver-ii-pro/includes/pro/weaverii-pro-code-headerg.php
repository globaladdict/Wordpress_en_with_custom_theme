<?php
/*
Weaver II Pro Header Gadgets

This code is Copyright 2011 by Bruce Wampler, all rights reserved.
This code is licensed under the terms of the accompanying license file: license.html.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
*/

/* =========================== header gadgets code ========================== */
function weaveriip_has_header_gadgets() { return true; }

function weaveriip_header_init() {

    if (true || !weaverii_pro_isset('hdr_num_opts')) weaverii_pro_setopt('hdr_num_opts', 2);

    for ($i = 1 ; $i <= weaverii_pro_getopt('hdr_num_opts') ; $i++ ) {
	$base = 'hdr_' . $i . '_';
	if (!weaverii_pro_isset($base . 'x')) weaverii_pro_setopt($base . 'x', '');
	if (!weaverii_pro_isset($base . 'y')) weaverii_pro_setopt($base . 'y', '');
	if (!weaverii_pro_isset($base . 'page')) weaverii_pro_setopt($base . 'page', '');
	if (!weaverii_pro_isset($base . 'img')) weaverii_pro_setopt($base . 'img', '');
	if (!weaverii_pro_isset($base . 'imgalt')) weaverii_pro_setopt($base . 'imgalt', '');
	if (!weaverii_pro_isset($base . 'text')) weaverii_pro_setopt($base . 'text', '');
	if (!weaverii_pro_isset($base . 'textstyle')) weaverii_pro_setopt($base . 'textstyle', '');
	if (!weaverii_pro_isset($base . 'link')) weaverii_pro_setopt($base . 'link', '');
	if (!weaverii_pro_isset($base . 'linkalt')) weaverii_pro_setopt($base . 'linkalt', '');
	if (!weaverii_pro_isset($base . 'hidemobile')) weaverii_pro_setopt($base . 'hidemobile', false);
	if (!weaverii_pro_isset($base . 'hidetablet')) weaverii_pro_setopt($base . 'hidetablet', false);
    }

    weaverii_pro_update_options('header');
}

function weaveriip_save_header() {
    /* Save options from plus header: wvrx_plus_save_header */

    if (!weaverii_pro_isset('hdr_num_opts')) weaveriip_header_init();

    if (isset($_POST['hdr_num_opts'])) weaverii_pro_setopt('hdr_num_opts', weaveriip_default_int($_POST['hdr_num_opts'],1,32,2));
    if (isset($_POST['hdr_use_for_header'])) weaverii_pro_setopt('hdr_use_for_header',weaverii_filter_textarea($_POST['hdr_use_for_header']));
    for ($i = 1 ; $i <= weaverii_pro_getopt('hdr_num_opts') ; $i++ ) {
	$base = 'hdr_' . $i . '_';
	if (isset($_POST[$base . 'x'])) weaverii_pro_setopt($base . 'x', weaveriip_default_int($_POST[$base . 'x'],-2048,33000,0));
	if (isset($_POST[$base . 'y'])) weaverii_pro_setopt($base . 'y', weaveriip_default_int($_POST[$base . 'y'],-2048,33000,0));
	if (isset($_POST[$base . 'page'])) weaverii_pro_setopt($base . 'page', weaverii_filter_textarea($_POST[$base . 'page']));
	if (isset($_POST[$base . 'img'])) {
	    weaverii_pro_setopt($base . 'img', esc_url(weaverii_filter_textarea($_POST[$base . 'img'])));
	    if (weaverii_pro_getopt($base . 'img') == '' && $_POST[$base . 'img'] != '') weaverii_pro_setopt($base . 'img', '#invalid_url_format_entered');
	}
	if (isset($_POST[$base . 'imgalt'])) weaverii_pro_setopt($base . 'imgalt', weaverii_filter_textarea($_POST[$base . 'imgalt']));
	if (isset($_POST[$base . 'text'])) weaverii_pro_setopt($base . 'text', weaverii_filter_textarea($_POST[$base . 'text']));
	if (isset($_POST[$base . 'textstyle'])) weaverii_pro_setopt($base . 'textstyle', weaverii_filter_textarea($_POST[$base . 'textstyle']));
	if (isset($_POST[$base . 'link'])) {
	    weaverii_pro_setopt($base . 'link', esc_url(weaverii_filter_textarea($_POST[$base . 'link'])));
	    if (weaverii_pro_getopt($base . 'link') == '' && $_POST[$base . 'link'] != '') weaverii_pro_setopt($base . 'link', '#invalid_url__format_entered');
	}
	if (isset($_POST[$base . 'linkalt'])) weaverii_pro_setopt($base . 'linkalt', weaverii_filter_textarea($_POST[$base . 'linkalt']));
	if (isset($_POST[$base . 'hidemobile'])) {
	    weaverii_pro_setopt($base . 'hidemobile', 'checked');
	} else weaverii_pro_setopt($base . 'hidemobile', false);
	if (isset($_POST[$base . 'hidetablet'])) {
	    weaverii_pro_setopt($base . 'hidetablet', 'checked');
	} else weaverii_pro_setopt($base . 'hidetablet', false);
    }
    weaverii_pro_update_options('header2');
    /* and let the user know something happened */
    echo '<div id="message" class="updated fade"><p><strong>Weaver II Pro Header Options Saved</strong></p></div>';
}


function weaveriip_header_gadget_insert() {
    weaveriip_header_gadget_code();
}

function weaveriip_header_gadget_code($which=0) {
    /* This is called from header.php, and will insert code into the #branding div of the header.
    */
    global $weaverii_cur_page_ID;

    if (!weaverii_pro_isset('hdr_num_opts')) weaveriip_header_init();

    // echo("<!-- Weaver II Pro Header Gadgets - Page ID: $weaverii_cur_page_ID; -->\n");

    $lim = weaverii_pro_getopt('hdr_num_opts');
    if ($which < 1) {	// coming from header, not shortcode
	$max = weaverii_pro_getopt('hdr_use_for_header');
	if ($max != '' && $max < $lim) $lim = $max;
    }

    for ($i = 1 ; $i <= $lim ; $i++ ) {
	if ($which > 0 && $which != $i)
	    continue;

	$x = 0; $y = 0; $img = ''; $imgalt = ''; $text = ''; $textstyle = ''; $link=''; $linkalt = '';
	$base = 'hdr_' . $i . '_';
	if (weaverii_pro_getopt($base . 'hidemobile') && weaverii_use_mobile('mobile'))
	    continue;
	if (weaverii_pro_getopt($base . 'hidetablet') && weaverii_use_mobile('tablet'))
	    continue;
	if (weaverii_pro_isset($base . 'page')) {
	    $page = weaverii_pro_getopt($base . 'page');
	    if ($page != '' && $page != $weaverii_cur_page_ID)
	        continue;		// show only on one page, but not this one.
	    if (weaverii_is_checked_page_opt('wvr_plus_hidecustomheader') )	// maybe skip
	        if (!($page != '' && $page == $weaveriip_cur_page_ID))
		    continue;
	}
	if (weaverii_pro_isset($base . 'x')) $x = weaverii_pro_getopt($base . 'x');
	if (weaverii_pro_isset($base . 'y')) $y = weaverii_pro_getopt($base . 'y');
	if (weaverii_pro_isset($base . 'img')) $img = weaverii_pro_getopt($base . 'img');
	if (weaverii_pro_isset($base . 'imgalt')) $imgalt = weaverii_pro_getopt($base . 'imgalt');
	if (weaverii_pro_isset($base . 'text')) $text = do_shortcode(weaverii_pro_getopt($base . 'text'));
	if (weaverii_pro_isset($base . 'textstyle')) $textstyle = weaverii_pro_getopt($base . 'textstyle');
	if (weaverii_pro_isset($base . 'link')) $link = weaverii_pro_getopt($base . 'link');
	if (weaverii_pro_isset($base . 'linkalt')) $linkalt = weaverii_pro_getopt($base . 'linkalt');

	if ($img == '' && $text == '' && $textstyle == '') continue;

	echo '<span id="wvr_gadget_' . $i . '" class="wvr_gadget" style="left:0px;position:absolute;z-index:4;margin-left:' . $x . 'px;margin-top:' . $y . 'px;'
	    . $textstyle . '">';
	if ($link != '') echo '<a href="' . $link . '" title="' . $linkalt . '" style="color:inherit;">';
	if ($img != '') {
	    echo '<img src="' . $img . '" title="' . $imgalt . '" />';
	}
	if ($text != '') echo $text;
	if ($link != ''	) echo("</a>");
	echo("</span>\n");
    }
?>

<?php
}

function weaveriip_gadget_shortcode($args = '') {
    // [weaver_extra_menu menu='custom-menu-name' style='style-name']
    extract(shortcode_atts(array(
       'gadget' => '1'      // use #1 by default
    ), $args));

    return weaveriip_header_gadget_code($gadget);
}

add_shortcode('weaver_gadget','weaveriip_gadget_shortcode');
?>
