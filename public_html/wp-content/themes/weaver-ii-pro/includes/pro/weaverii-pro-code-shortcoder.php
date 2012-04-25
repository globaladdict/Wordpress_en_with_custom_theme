<?php
/*
Weaver II Pro Shortcoder

This code is Copyright 2011 by Bruce Wampler, all rights reserved.
This code is licensed under the terms of the accompanying license file: license.html.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
*/

/* =========================== header gadgets code ========================== */
function weaveriip_has_shortcoder() { return true; }

function weaveriip_shortcoder_init() {

    if (!weaverii_pro_isset('wvpsc_num_opts')) weaverii_pro_setopt('wvpsc_num_opts', 2);

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
    }

    weaverii_pro_update_options('header');
}

function weaveriip_save_shortcoder() {
    /* Save options from plus header: wvrx_plus_save_header */

    if (!weaverii_pro_isset('wvpsc_num_opts')) weaveriip_header_init();

    if (isset($_POST['wvpsc_num_opts'])) weaverii_pro_setopt('wvpsc_num_opts', weaveriip_default_int($_POST['wvpsc_num_opts'],1,25,2));

    for ($i = 1 ; $i <= weaverii_pro_getopt('wvpsc_num_opts') ; $i++ ) {
	$base = 'wvpsc_' . $i . '_';
	if (isset($_POST[$base . 'id'])) {
	    $val = filter_var(strtolower(trim(weaverii_filter_textarea($_POST[$base . 'id']))), FILTER_SANITIZE_EMAIL);	// close enough
	    weaverii_pro_setopt($base . 'id', $val);
	}
	if (isset($_POST[$base . 'text'])) {
	    weaverii_pro_setopt($base . 'text', weaverii_filter_textarea($_POST[$base . 'text']));
	}

    }
    weaverii_pro_update_options('shortcoder');
    /* and let the user know something happened */
    echo '<div id="message" class="updated fade"><p><strong>Weaver II Pro Shortcoder Options Saved</strong></p></div>';
}

/* -------------- weaveriip_sc --------------- */
function weaveriip_sc_shortcode($args = '') {
    extract(shortcode_atts(array(
	'id' => '',
	'v1' => '', 'v2' =>'', 'v3' =>'', 'v4' =>'', 'v5' =>'',
	'v6' =>'', 'v7' =>'', 'v8' =>'', 'v9' =>'',
	'php' => ''
    ), $args));

    $text = "[*** ERROR: weaveriip_sc undefined id: '$id' *** ]";

    $out = '';	// no php yet

    if ($php != '') {
	if (function_exists('weaveriip_php_do_eval')) {
	    $out = weaveriip_php_do_eval($php);
	} else {
	    $out = '[**** ERROR: weaveriip_sc: php not allowed ****]';
	}
    }

    for ($i = 1 ; $i <= weaverii_pro_getopt('wvpsc_num_opts') ; $i++ ) { // look for our id
	$base = 'wvpsc_' . $i . '_';
	$cur_id = weaverii_pro_getopt($base . 'id');
	if ($cur_id == $id) {
	    $text = weaverii_pro_getopt($base . 'text');
	    break;
	}
    }
    for ($i = 1 ; $i <= 9 ; $i++) {	// process parameters
	$name = 'v' . $i;
	if ($$name != '') {
	    $text = str_replace( "%$name%", $$name, $text );    // replace params
	}
    }
    if ($out != '') {
	$text = str_replace('%php%', $out, $text);
    }

    return do_shortcode($text);
}

add_shortcode('weaver_sc', 'weaveriip_sc_shortcode');

?>
