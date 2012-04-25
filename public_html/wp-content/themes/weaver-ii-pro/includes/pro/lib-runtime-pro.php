<?php
/*
Weaver II Pro Runtime Library

This code is Copyright 2011 by Bruce Wampler, all rights reserved.
This code is licensed under the terms of the accompanying license file: license.html.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.

*/
if (!function_exists('weaverii_trans')) {
//==================== Pro RUN TIME ==========
function weaverii_trans($id, $text) {
    return $text;
}
}

function weaverii_init_base() {
    return true;
}

function weaverii_pro_wp_head() {

    // include scripts

    if (function_exists('weaveriip_slider_scripts')) weaveriip_slider_scripts();
    if (function_exists('weaveriip_showhide_scripts')) weaveriip_showhide_scripts();
    if (function_exists('weaveriip_moreopts_scripts')) weaveriip_moreopts_scripts();

// === include Google Fonts links
    $google = weaverii_getopt('fonts_google_font_list');
    if ($google) {
	echo ("<!-- Weaver II Pro Google Fonts -->\n");
	echo $google;
    }
}

function weaverii_pro_output_style($sout) {

// === Fonts from Pro Fonts
    weaverii_f_write($sout,"/* Weaver II Pro Fonts */\n");

    global $weaverii_fonts_defs;
    foreach ($weaverii_fonts_defs as $option => $val) {
	$fonts = weaverii_getopt($val['id']);
	if ($fonts) {
	    $rule = $val['tag'] != '+++' ? $val['tag'] : '';
	    weaverii_f_write($sout,$rule . $fonts . "\n");
	}
    }


// ======================= background areas ============================
   $val = weaverii_getopt('_wii_bg_fullsite_url');
   if ($val != '') {
        weaverii_f_write($sout,
"html {background: url($val) no-repeat center center fixed; -webkit-background-size: cover;
-moz-background-size: cover;-o-background-size: cover;background-size: cover;}
body {background-color:transparent;}\n");
   }
   weaveriip_bgimg_style($sout,'_wii_bg_wrapper_url','#wrapper');
   weaveriip_bgimg_style($sout,'_wii_bg_header_url','#branding');
   weaveriip_bgimg_style($sout,'_wii_bg_main_url','#main');
   weaveriip_bgimg_style($sout,'_wii_bg_container_url','#container_wrap');
   weaveriip_bgimg_style($sout,'_wii_bg_content_url','#content');
   weaveriip_bgimg_style($sout,'_wii_bg_page_url','#container .page');
   weaveriip_bgimg_style($sout,'_wii_bg_post_url','#container .post');
   weaveriip_bgimg_style($sout,'_wii_bg_widgets_left_url','#sidebar_wrap_left');
   weaveriip_bgimg_style($sout,'_wii_bg_widgets_right_url','#sidebar_wrap_right');
   weaveriip_bgimg_style($sout,'_wii_bg_footer_url','#colophon');


    weaveriip_display_none_style($sout,'wii_hide_p_category','#content .category-title, #content .category-archive-meta');
    weaveriip_display_none_style($sout,'wii_hide_p_tag','#content .tag-title, #content .category-archive-meta');
    weaveriip_display_none_style($sout,'wii_hide_p_author','#content .author-title');
    weaveriip_display_none_style($sout,'wii_hide_p_date','#content .archive-title');
    weaveriip_display_none_style($sout,'wii_hide_p_search', '#content .search-results');

    if (function_exists('weaveriip_slider_output_style')) weaveriip_slider_output_style($sout);
    if (function_exists('weaveriip_extra_menu_output_style')) weaveriip_extra_menu_output_style($sout);
    if (function_exists('weaveriip_totalcss_output_style')) weaveriip_totalcss_output_style($sout);	// always last
}

function weaveriip_header_insert() {
    // This is called from header.php

    if (function_exists('weaveriip_header_gadget_insert')) weaveriip_header_gadget_insert();
    if (function_exists('weaveriip_moreopts_header_insert')) weaveriip_moreopts_header_insert();
}

function weaveriip_bgimg_style($sout,$id,$name) {
    $val = weaverii_getopt($id);
    if ($val != '') {
	$fixid = str_replace('_url','',$id);
	$rpt = weaverii_getopt($fixid . '_rpt');
	if (strlen($rpt) < 6) $rpt = 'repeat';	// set to default
	weaverii_f_write($sout, $name . '{background-image:url('. parse_url($val,PHP_URL_PATH) . ');background-repeat:' . $rpt . ';}' . "\n");
    }
}

function weaveriip_display_none_style($sout,$id,$name) {
    $val = weaverii_getopt($id);
    if ($val)
	weaverii_f_write($sout, $name . '{display:none;}' . "\n");

}

function weaveriip_help_link($link, $info) {
    $t_dir = weaverii_relative_url('');

    $pp_help =  '<a href="' . $t_dir . 'includes/pro/' . $link . '" target="_blank" title="' . $info . '">'
	. '<img class="entry-cat-img" src="' . $t_dir . 'images/icons/help-1.png" style="position:relative; top:4px; padding-left:4px;" /></a>';
    echo($pp_help);
}

// ============================ OPTIONS ===========================

function weaverii_opt_cache() {
    // load the options cache - from regular or mobile depending...
    global $weaverii_opts_cache;
    if (!$weaverii_opts_cache) {
	$weaverii_opts_cache = apply_filters('weaverii_switch_theme',get_option('weaverii_settings',array()));	// start with the default
    }

    if (isset($weaverii_opts_cache['_wii_mobile_alt_theme'])
	&& $weaverii_opts_cache['_wii_mobile_alt_theme']
	&& $weaverii_opts_cache['_wii_mobile_alt_theme'] != 'saved_mobile'
	&& !is_admin()
	&& weaverii_use_mobile('mobile')) { // want mobile alternative - but not on sim...
	$sim = $weaverii_opts_cache['_wii_sim_mobile'];
	if (!$sim || $sim == 'none') {
	    $mobile_opts = get_option('weaverii_settings_mobile');	// only used in Pro theme...
	    if ($mobile_opts !== false) {
		$weaverii_opts_cache = $mobile_opts;
	    }
	}
    }
}

function weaverii_pro_opt_cache() {
    // load the options cache - from regular or mobile depending...
    global $weaverii_pro_opts;
    if (!$weaverii_pro_opts)
    {
	if (weaverii_getopt_checked('_wii_mobile_alt_theme') && !is_admin() && weaverii_use_mobile('mobile')) {
	    $weaverii_pro_opts = get_option('weaverii_pro_mobile');
	    if ($weaverii_pro_opts === false)
		$weaverii_pro_opts = get_option('weaverii_pro');
	}
	else {
	    $weaverii_pro_opts = apply_filters('weaverii_switch_theme_pro',get_option('weaverii_pro',array()));
	}
    }
}

function weaverii_pro_setpost_checkbox($name) {
    if (isset($_POST[$name])) weaverii_pro_setopt($name, 'checked');
	else weaverii_pro_setopt($name, false);
}

function weaverii_pro_getopt($name) {
    global $weaverii_pro_opts;
    weaverii_pro_opt_cache();

    if (isset($weaverii_pro_opts[$name]))
        return $weaverii_pro_opts[$name];
    else
        return false;
}

function weaverii_pro_setopt($name, $value) {
    global $weaverii_pro_opts;
    if (!$weaverii_pro_opts)
        $weaverii_pro_opts = get_option('weaverii_pro',array());
    $weaverii_pro_opts[$name] = $value;
}

function weaverii_pro_isset($name){
    global $weaverii_pro_opts;

    weaverii_pro_opt_cache();

    $val = isset($weaverii_pro_opts[$name]);
    return $val;
}

function weaverii_pro_update_options($id) {
    global $weaverii_pro_opts;
    if (!$weaverii_pro_opts)
        $weaverii_pro_opts = get_option('weaverii_pro',array());

    weaverii_wpupdate_option('weaverii_pro',$weaverii_pro_opts);
    weaverii_save_opts('weaverii_pro');		// need to re-write the stylesheet
}

function weaveriip_default_int($value, $min, $max, $default='') {
    if (!is_numeric($value) || !is_int((int)$value)) {
	return $default;
    } else {
 	if ($value == '' || (int)$value < $min || (int)$value > $max)
            return $default;
	else
	    return $value;
    }
}

function weaveriip_clear_opts() {
    global $weaverii_pro_opts;
    $weaver_pro_opts = false;
    delete_option('weaverii_pro');
    delete_option('weaverii_pro_mobile');
    delete_option('weaverii_settings_mobile');
}

function weaveriip_save_opts_backup() {
    global $weaverii_pro_opts;

    if (!$weaverii_pro_opts)
        $weaverii_pro_opts = get_option('weaverii_pro',array());
    weaverii_wpupdate_option('weaverii_pro_backup',$weaverii_pro_opts);
}

function weaveriip_restore_opts_backup() {
   global $weaverii_pro_opts;
   $saved = get_option('weaverii_pro_backup',array());
   if (!empty($saved)) {
	$weaver_pro_opts = $saved;
	weaverii_wpupdate_option('weaverii_pro',$weaver_pro_opts);
   }
}

function weaveriip_moreopts_scripts() {
    // Use wp_enqueue_script to add scripts - called from header.php
//	if (weaverii_getopt('wii_hide_tooltip')) {
//	$url =  trailingslashit(get_template_directory_uri());
//	wp_enqueue_script('weaveriiHideToolTips', $url.'includes/pro/plus-js/weaver-hide-tooltip.js');
//    }
}

function weaveriip_bracket($txt,$head,$tail){
    $lead = strpos($txt, $head);
    if ($lead === false || $lead != 0)
	$txt = $head . $txt;
    $end = strrchr($txt, $tail);
    if ($end === false || strlen($end) > 1)
	$txt = $txt . $tail;
    return $txt;
}

require_once( dirname( __FILE__ ) . '/globals-runtime-pro.php' );
/* ------------------------------------ Weaver II Pro FEATURE IMPLEMENTATIONS ------------------------ */

require_once('weaverii-pro-sc-basic.php');		// The basic Weaver II shortcodes

if (weaverii_getopt('_wii_show_totalcss'))		// Total CSS
    require_once('weaverii-pro-total-css.php');

if (!weaverii_getopt('_wii_hide_slider')) {		// Slider Menu
    require_once('weaverii-pro-code-slider.php');}
if (!weaverii_getopt('_wii_hide_extramenus'))	// Extra Menus
    require_once('weaverii-pro-code-extramenu.php');


if (!weaverii_getopt('_wii_hide_linkbuttons'))	// Link Buttons
    require_once('weaverii-pro-code-linkbuttons.php');
if (!weaverii_getopt('_wii_hide_socialbuttons')) // Social Buttons
    require_once('weaverii-pro-code-social.php');
if (!weaverii_getopt('_wii_hide_headergadgets')) // Header Gadgets
    require_once('weaverii-pro-code-headerg.php');

if (!weaverii_getopt('_wii_hide_widgetarea'))	// Widget Area
    require_once('weaverii-pro-sc-widget-area.php');
if (!weaverii_getopt('_wii_hide_searchbox'))	// Search Form
    require_once('weaverii-pro-sc-search.php');
if (!weaverii_getopt('_wii_hide_showfeed'))	// Show Feed
    require_once('weaverii-pro-sc-feed.php');
if (!weaverii_getopt('_wii_hide_popuplink'))	// Popup Link
    require_once('weaverii-pro-sc-popup.php');
if (!weaverii_getopt('_wii_hide_showhide'))	// Show/Hide Text
    require_once('weaverii-pro-sc-showhide.php');
if (!weaverii_getopt('_wii_hide_commentpolicy')) // Comment Policy
    require_once('weaverii-pro-sc-disclaimer.php');
if (!weaverii_getopt('_wii_hide_shortcoder'))	// Shortcoder
    require_once('weaverii-pro-code-shortcoder.php');

if (weaverii_getopt('_wii_show_php'))			// PHP
    require_once('weaverii-pro-sc-php.php');

?>
