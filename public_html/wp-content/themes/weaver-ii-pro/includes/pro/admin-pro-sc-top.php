<?php
/*
weaveriip_admin - admin code

This code is Copyright 2011 by Bruce E. Wampler, all rights reserved.
This code is licensed under the terms of the accompanying license file: license.txt.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
*/

function weaverii_pro_sc_admin() {

    weaverii_pro_submits();			// process submits

    if (false && !weaverii_pro_getopt('_wii_hide_updatemsg')) {
        $latest = weaveriip_latest_version();     // check if newer version is available

        if (stripos($latest,'announcement') !== false) {
            echo '<div id="message" class="updated fade"><p><strong>' . $latest .
            ' - Please check <a href="http://weaverplus.info" target="_blank">WeaverPlus.info</a>.</strong></p></div>';
        } else if ($latest != weaveriip_VERSION && $latest != 'unavailable') {
            echo '<div id="message" class="updated fade"><p><strong>Current Weaver II Pro version is ' . weaveriip_VERSION .
            '. <br />A newer version (' . $latest .
            ') is available for your account at <a href="http://weaverplus.info" target="_blank">WeaverPlus.info</a>.</strong></p></div>';
        }
    }
?>

<p><strong style="font-size:130%;">Weaver II Shortcode Admin</strong> <span style="float:right;color:white;background:#57A;padding:4px;font-weight:bold;"><a href="<?php echo site_url('/wp-admin/themes.php?page=WeaverII'); ?>" style="color:white;text-decoration:none;">Weaver II Admin</a></span></h3>

<div id="tabwrap_plus" style="padding-left:5px;">
    <div id="tab-container-plus" class='yetiisub'>
	<ul id="tab-container-plus-nav" class='yetiisub'>

    <li><a href="#btab22" style="background:#D6D9FF;" title="Header Gadgets - Images/Text over Header"><?php echo(__('Header Gadgets', 'weaver-ii'/*a*/ )); ?></a></li>
	<li><a href="#btab20" style="background:#D6D9FF;" title="Link Buttons - shortcode & widget"><?php echo(__('Link Buttons', 'weaver-ii'/*a*/ )); ?></a></li>
    <li><a href="#btab21" style="background:#D6D9FF;" title="Social Buttons - shortcode & widget"><?php echo(__('Social Buttons', 'weaver-ii'/*a*/ )); ?></a></li>

    <li><a href="#mtab10" style="background:#FFE8B9;" title="Weaver Slider Menu Shortcode"><?php echo(__('Slider Menu', 'weaver-ii'/*a*/ )); ?></a></li>
    <li><a href="#mtab11"  style="background:#FFE8B9;" title="Extra Menus Shortcode"><?php echo(__('Extra Menus', 'weaver-ii'/*a*/ )); ?></a></li>
    <li><a href="#sctabbread" style="background:#FFCC33;" title="Breadcrumbs Shortcode"><?php echo(__('Breadcrumbs', 'weaver-ii'/*a*/ )); ?></a></li>
    <li><a href="#sctabhdr" style="background:#FFCC33;" title="Header Image Shortcode"><?php echo(__('Header Img', 'weaver-ii'/*a*/ )); ?></a></li>
    <li><a href="#sctabhtml" style="background:#FFCC33;" title="HTML Shortcode"><?php echo(__('HTML', 'weaver-ii'/*a*/ )); ?></a></li>
    <li><a href="#sctabdiv" style="background:#FFCC33;" title="DIV Shortcode"><?php echo(__('div,span', 'weaver-ii'/*a*/ )); ?></a></li>
    <li><a href="#sctabiframe" style="background:#FFCC33;" title="iframe Shortcode"><?php echo(__('iframe', 'weaver-ii'/*a*/ )); ?></a></li>
    <li><a href="#sctabpgnv" style="background:#FFCC33;" title="PageNav Shortcode"><?php echo(__('Page Nav', 'weaver-ii'/*a*/ )); ?></a></li>

    <li><a href="#sctabmobile" style="background:#FFCC33;" title="Show/Hide Mobile Shortcodes"><?php echo(__('Show/Hide Mobile', 'weaver-ii'/*a*/ )); ?></a></li>
    <li><a href="#sctabloggedin" style="background:#FFCC33;" title="Show/Hide Logged In Shortcodes"><?php echo(__('Show/Hide Logged In', 'weaver-ii'/*a*/ )); ?></a></li>
    <li><a href="#sctabsp" style="background:#FFCC33;" title="Show Posts Shortcode"><?php echo(__('Show Posts', 'weaver-ii'/*a*/ )); ?></a></li>
    <li><a href="#sctabstitle" style="background:#FFCC33;" title="Site Title/Desc Shortcodes"><?php echo(__('Site Title/Desc', 'weaver-ii'/*a*/ )); ?></a></li>
    <li><a href="#sctabvodep" style="background:#FFCC33;" title="Video Shortcodes"><?php echo(__('Video', 'weaver-ii'/*a*/ )); ?></a></li>


    <li><a href="#sctab36" style="background:#FAFAAC;" title="Widget Area Shortcode"><?php echo(__('Widget Area', 'weaver-ii'/*a*/ )); ?></a></li>
            <li><a href="#sctab37" style="background:#FAFAAC;" title="Search Form Shortcode"><?php echo(__('Search Form', 'weaver-ii'/*a*/ )); ?></a></li>
            <li><a href="#sctab34" style="background:#FAFAAC;" title="Show Feed Shortcode"><?php echo(__('Show Feed', 'weaver-ii'/*a*/ )); ?></a></li>

            <li><a href="#sctab31" style="background:#FAFAAC;" title="Popup Link Shortcode"><?php echo(__('Popup Link', 'weaver-ii'/*a*/ )); ?></a></li>
            <li><a href="#sctab32" style="background:#FAFAAC;" title="Show/Hide Shortcode"><?php echo(__('Show/Hide Text', 'weaver-ii'/*a*/ )); ?></a></li>
            <li><a href="#sctab33" style="background:#FAFAAC;" title="Comment Policy"><?php echo(__('Comment Policy', 'weaver-ii'/*a*/ )); ?></a></li>
	    <li><a href="#sctab38" style="background:#FAFAAC;" title="Shortcoder"><?php echo(__('Shortcoder', 'weaver-ii'/*a*/ )); ?></a></li>
            <li><a href="#sctab35" style="background:#FAFAAC;" title="Include PHP Shortcode"><?php echo(__('PHP', 'weaver-ii'/*a*/ )); ?></a></li>

	    <li><a href="#xtab22" style="background:#D4FAC3;" title="Total CSS"><?php echo(__('Total CSS', 'weaver-ii'/*a*/ )); ?></a></li>

	    <li><a href="#xtab5" style="background:#FCDEE4;"><?php echo(__('Shortcode Help', 'weaver-ii'/*a*/ )); ?></a></li>
	</ul>

<?php   /* IMPORTANT - in spite of the id's, these MUST be in the correct order - the same as the above list... */
?>
	<div id="btab22" class="tab_plus" > <!-- Header Gadgets -->
<?php
            if (function_exists('weaveriip_has_header_gadgets')) {
		require_once('weaverii-pro-admin-headerg.php');
                weaveriip_headergadget_admin();
            } else {
                echo "<p class='wvr-option-section'>Header Gadgets - <small>Links, Images & Text over the Header</small></p>
                <p style='font-weight:bold;'>Option disabled. See Weaver II Admin&rarr;Weaver II Pro tab to enable it.</p>\n";
            }
?>
	</div>
	        <div id="btab20" class="tab_plus" > <!-- Link Buttons -->
<?php
            if (function_exists('weaveriip_has_linkbuttons')) {
                require_once('weaverii-pro-admin-linkbuttons.php');
                weaveriip_buttons_admin();
            } else {
                echo "<p class='wvr-option-section'>Link Buttons - [weaver_buttons] + Widget</p>
                <p style='font-weight:bold;'>Option disabled. See Weaver II Admin&rarr;Weaver II Pro tab to enable it.</p>\n";
            }
?>
	</div>

        <div id="btab21" class="tab_plus" > <!-- Social Buttons -->
<?php
            if (function_exists('weaveriip_has_socialbuttons')) {
                require_once('weaverii-pro-admin-social.php');
                weaveriip_social_admin();
            } else {
                echo "<p class='wvr-option-section'>Social Buttons - [weaver_social] Shortcode and Widget</p>
                <p style='font-weight:bold;'>Option disabled. See Weaver II Admin&rarr;Weaver II Pro tab to enable it.</p>\n";
            }
?>
        </div>

	<div id="mtab10" class="tab_plus" > <!-- Slider -->
<?php
            if (function_exists('weaveriip_has_slider')) {
                require_once('weaverii-pro-admin-slider.php');
                weaveriip_slider_admin();
            } else {
                 echo "<p class='wvr-option-section'>Slider Menu Shortcode - [weaver_slider]</p>
                <p style='font-weight:bold;'>Option disabled. See Weaver II Admin&rarr;Weaver II Pro tab to enable it.</p>\n";
            }
?>
	</div>

        <div id="mtab11" class="tab_plus" > <!-- Extra Menus -->
<?php
            if (function_exists('weaveriip_has_extra_menu')) {
                require_once('weaverii-pro-admin-extramenu.php');
                weaveriip_extra_menu_admin();
            } else {
                echo "<p class='wvr-option-section'>Extra Menu Shortcode - [weaver_extra_menu] + Vertical Menu Widget</p>
                <p style='font-weight:bold;'>Option disabled. See Weaver II Admin&rarr;Weaver II Pro tab to enable it.</p>\n";
            }
?>
	</div>

	<div id="sctabsp" class="tab_plus" > <!-- Breadcrumbs -->
<?php
        if (function_exists('weaveriip_has_breadcrumbs')) {
            weaveriip_breadcrumbs_admin();
	}
 ?>
        </div>

	<div id="sctabhdr" class="tab_plus" > <!-- Header Image -->
<?php
        if (function_exists('weaveriip_has_headerimg')) {
            weaveriip_headerimg_admin();
	}
 ?>
        </div>


	<div id="sctabhtml" class="tab_plus" > <!-- HTML -->
<?php
        if (function_exists('weaveriip_has_sc_html')) {
            weaveriip_sc_html_admin();
	}
 ?>
        </div>

	<div id="sctabdiv" class="tab_plus" > <!-- DIV -->
<?php
        if (function_exists('weaveriip_has_sc_div')) {
            weaveriip_sc_div_admin();
	}
 ?>
        </div>

	<div id="sctabiframe" class="tab_plus" > <!-- iframe -->
<?php
        if (function_exists('weaveriip_has_sc_iframe')) {
            weaveriip_sc_iframe_admin();
	}
 ?>
        </div>


	<div id="sctabpgnv" class="tab_plus" > <!-- Page Nav -->
<?php
        if (function_exists('weaveriip_has_pagenav')) {
            weaveriip_pagenav_admin();
	}
 ?>
        </div>

	<div id="sctabmobile" class="tab_plus" > <!-- Show/Hide Mobile -->
<?php
        if (function_exists('weaveriip_has_showhide_mobile')) {
            weaveriip_showhide_mobile_admin();
	}
 ?>
        </div>

	<div id="sctabloggedin" class="tab_plus" > <!-- Show/Hide Logged In -->
<?php
        if (function_exists('weaveriip_has_showhide_logged_in')) {
            weaveriip_showhide_logged_in_admin();
	}
 ?>
        </div>

	<div id="sctabbread" class="tab_plus" > <!-- Show Posts -->
<?php
        if (function_exists('weaveriip_has_show_posts')) {
            weaveriip_show_posts_admin();
	}
 ?>
        </div>

	<div id="sctabstitle" class="tab_plus" > <!-- Site Title/Description -->
<?php
        if (function_exists('weaveriip_has_sitetitle')) {
            weaveriip_sitetitle_admin();
	}
 ?>
        </div>


	<div id="sctabvodep" class="tab_plus" > <!-- Video -->
<?php
        if (function_exists('weaveriip_has_video')) {
            weaveriip_video_admin();
	}
 ?>
        </div>

        <div id="sctab36" class="tab_plus" > <!-- Widget Area -->
<?php
        if (function_exists('weaveriip_has_widget_area')) {
            weaveriip_widget_area_admin();
        } else {
             echo "<p class='wvr-option-section'>Widget Area - [weaver_widget_area]</p>
            <p style='font-weight:bold;'>Option disabled. See Weaver II Admin&rarr;Weaver II Pro tab to enable it.</p>\n";
        }
?>
        </div>

        <div id="sctab37" class="tab_plus" > <!-- Search -->
<?php
        if (function_exists('weaveriip_has_search')) {
            weaveriip_search_admin();
        } else {
             echo "<p class='wvr-option-section'>Search Form - [weaver_search]</p>
            <p style='font-weight:bold;'>Option disabled. See Weaver II Admin&rarr;Weaver II Pro tab to enable it.</p>\n";
        }
?>
        </div>

        <div id="sctab34" class="tab_plus" > <!-- Show Feed -->
<?php
            if (function_exists('weaveriip_feed_admin')) {
                weaveriip_feed_admin();
            } else {
                echo "<p class='wvr-option-section'>Show Feed - [weaver_feed]</p>
                <p style='font-weight:bold;'>Option disabled. See Weaver II Admin&rarr;Weaver II Pro tab to enable it.</p>\n";
            }
?>
        </div>

        <div id="sctab31" class="tab_plus" > <!-- Popup Link -->
<?php
            if (function_exists('weaveriip_has_popup_link')) {
                weaveriip_popup_link_admin();
            } else {
                echo "<p class='wvr-option-section'>Weaver Show/Hide - [weaver_showhide]</p>
                <p style='font-weight:bold;'>Option disabled. See Weaver II Admin&rarr;Weaver II Pro tab to enable it.</p>\n";
            }
?>
        </div>

        <div id="sctab32" class="tab_plus" > <!-- Show/Hide -->
<?php
            if (function_exists('weaveriip_has_showhide')) {
                weaveriip_showhide_admin();
            } else {
                echo "<p class='wvr-option-section'>Weaver Show/Hide - [weaver_showhide] </p>
                <p style='font-weight:bold;'>Option disabled. See Weaver II Admin&rarr;Weaver II Pro tab to enable it.</p>\n";
            }
?>
        </div>

        <div id="sctab33" class="tab_plus" > <!-- Comment Policy -->
<?php
            if (function_exists('weaveriip_has_disclaimer')) {
                weaveriip_disclaimer_admin();
                } else {
             echo "<p class='wvr-option-section'>Weaver II Pro Comment Disclaimer</p>
            <p style='font-weight:bold;'>Option disabled. See Weaver II Admin&rarr;Weaver II Pro tab to enable it.</p>\n";
        }
?>
        </div>

        <div id="sctab38" class="tab_plus" > <!-- Shortcoder -->
<?php
            if (function_exists('weaveriip_has_shortcoder')) {
		require_once('weaverii-pro-admin-shortcoder.php');
                weaveriip_shortcoder_admin();
                } else {
             echo "<p class='wvr-option-section'>Weaver II Pro Shortcoder</p>
            <p style='font-weight:bold;'>Option disabled. See Weaver II Admin&rarr;Weaver II Pro tab to enable it.</p>\n";
        }
?>
        </div>

        <div id="sctab35" class="tab_plus" > <!-- PHP -->
<?php
            if (function_exists('weaveriip_has_php')) {
                weaveriip_php_admin();
            } else {
                echo "<p class='wvr-option-section'>PHP - [weaver_php]</p>
                <p style='font-weight:bold;'>Option disabled. See Weaver II Admin&rarr;Weaver II Pro tab to enable it.</p>
		<p>The <em>PHP shortcode is an advanced option that allows for
		insertion of PHP code into any Weaver HTML area.</p>\n";
            }
?>
        </div>

	<div id="xtab22" class="tab_plus" >
<?php
            if (function_exists('weaveriip_has_totalcss_admin')) {
                weaveriip_totalcss_admin();
                } else {
             echo "<p class='wvr-option-section'>Weaver II Pro Total CSS</p>
            <p style='font-weight:bold;'>Option disabled. See Weaver II Admin&rarr;Weaver II Pro tab to enable it.</p>\n"
	    . "<p>The <em>Total CSS option is an advanced option that allows custom CSS for
	    almost every CSS tag used by Weaver.</p>\n";
        }
?>
	</div>

        <div id="xtab5" class="tab_plus" >
	    <?php
	        require_once('weaverii-pro-help.php');
		weaveriip_help_admin(); ?>
	</div>

    </div>
</div> <!-- #tabwrap_plus -->

<script type="text/javascript">
	var tabber2 = new Yetii({
	id: 'tab-container-plus',
	tabclass: 'tab_plus',
	persist: true
	});
</script>

<?php
}

function weaveriip_latest_version() {
    $rss = fetch_feed('http://weaverplus.wordpress.com/feed/');
     if (is_wp_error($rss) ) {
	return 'unavailable';
    }
    $out = '';
    $items = 1;
    $num_items = $rss->get_item_quantity($items);
    if ( $num_items < 1 ) {
	$out .= 'unavailable';
	$rss->__destruct();
	unset($rss);
	return $out;
    }
    $rss_items = $rss->get_items(0, $items);
    foreach ($rss_items as $item ) {
	$title = esc_attr(strip_tags($item->get_title()));
	if ( empty($title) )
	    $title = 'unavailable';
    }
    if (stripos($title,'announcement') === false) {
        $blank = strpos($title,' ');    // find blank
        if ($blank < 1)     // problem
            $title = 'unavailable';
        else {
            $title = substr($title,0,$blank);
        }
    }
    $out .= $title;
    $rss->__destruct();
    unset($rss);
    return $out;
}

// ========================================= FORM DISPLAY ===============================

function weaveriip_value_row($th,$id,$desc,$width='') {
    $style = '';
    if ($width != '') {
        $style = ' style="width:' . $width . ';"';
    }
?>
    <tr>
	<th scope="row" align="right"<?php echo $style . '>' . $th; ?>:&nbsp;</th>
	<td>
	    <input type="text" style="width:60px;height:22px;" class="regular-text" name="<?php echo $id; ?>"
                id="<?php echo $id; ?>" value="<?php echo (weaverii_esc_textarea(weaverii_pro_getopt($id))); ?>" />
	</td>
	<td style="padding-left: 10px"><small><?php echo $desc; ?></small></td>
    </tr>
<?php
}

function weaveriip_save_admin_opts() {
    global $weaverii_pro_opts;
    $weaveriip_admin_checkboxes = array ('wvp_hide_slider', 'wvp_hide_extramenus', 'wvp_hide_menuoptions',
                'wvp_hide_linkbuttons', 'wvp_hide_socialbuttons', 'wvp_hide_headergadgets', 'wvp_hide_popuplink',
                'wvp_hide_showhide', 'wvp_hide_commentpolicy', 'wvp_hide_showfeed', 'wvp_hide_fontsopts',
                'wvp_hide_widgetarea', 'wvp_hide_searchbox', 'wvp_hide_moreopts', 'wvp_show_php', 'wvp_show_totalcss',
		'wvp_hide_shortcoder'
	);

    foreach ($weaverii_pro_admin_checkboxes as $opt) {
        if (isset($_POST[$opt])) weaverii_pro_setopt($opt, 'checked');
        else weaverii_pro_setopt($opt, false);
    }

    weaverii_pro_update_options('save_admin_opts');

    // carry out admin opts.
    if (isset($_POST['plus_clear_settings'])) {     // won't check, just do it.
        delete_option('weaverii_pro_plus');
        $weaverii_pro_opts = false;
    }

    echo '<div id="message" class="updated fade"><p><strong>Weaver II Pro Admin Options Saved.<br /> <span style="color:red;">NOTE: While features have been enabled
    or disabled, it will take one more save before the admin tabs display the respective features correctly.</span></strong></p></div>';
}

function weaveriip_per_page_opts() {
    // options to be displayed on per page Editor options panel

    _e("<strong>Weaver II Pro Per Page Options</strong>", 'weaver-ii'/*a*/ );
    weaverii_html_br();
    weaverii_page_checkbox('wvr_plus_hideslider', __('Hide Weaver II Pro Slider Menu on this page', 'weaver-ii'/*a*/ ));
    weaverii_page_checkbox('wvr_plus_hidecustomheader', __('Hide Weaver II Pro Custom Header content (unless this page specified)', 'weaver-ii'/*a*/ ));
    weaverii_html_br();
    weaverii_page_checkbox('wvr_plus_hidetopmenu', __('Hide Top Menu Bar on this page', 'weaver-ii'/*a*/ ));
    weaverii_page_checkbox('wvr_plus_hidebottommenu', __('Hide Bottom Menu on this page', 'weaver-ii'/*a*/ ));
    weaverii_html_br();
    weaverii_html_br();
}

function weaveriip_per_post_opts() {
    weaverii_html_br();
    weaverii_html_br();

    _e("<strong>Weaver II Pro Per Post Options</strong>", 'weaver-ii'/*a*/ );
    weaverii_html_br();
    weaverii_page_checkbox('wvpp_post_no_titlelink', __('Don\'t make this post\'s title a link.', 'weaver-ii'/*a*/ ));

}

function weaverii_add_per_opts_list() {
    $plus_fields = array ('wvr_plus_hideslider','wvr_plus_hidecustomheader','wvr_plus_hidebottommenu','wvr_plus_hidetopmenu',
                          'wvpp_post_no_titlelink');
    return $plus_fields;
}


function weaverii_pro_submits() {
/*
 Save option handler for all plus features
 Each form will use this convention:

    <input class="button-primary" type="submit" name="weaverii_pro_save_pro" value="Save Plus Specific Options"/>
    <input type="hidden" name="weaveriip_save_specific opts" value="save" />
    lt ? php weaverii_nonce_field('weaverii_pro_save_pro');

 The button value gives the action name, the hidden field gives the actual action, and using
 weaverii_pro_save_pro routes all settings through here. This allows unlimited addition of
 options without needing to mess with the loop in Weaver.
*/

    if (!weaverii_submitted('weaverii_pro_save_pro')) {		// did they submit anything?
	return;
    }
    $actions = array('weaveriip_save_admin_opts','weaveriip_save_settings','weaveriip_restore_psettings',
        'weaveriip_save_social','weaveriip_save_slider','weaveriip_save_header','weaveriip_save_moreopts',
	'weaveriip_save_totalcss','weaveriip_save_fonts','weaveriip_generate_fonts','weaveriip_add_to_google_list',
        'weaveriip_save_buttons','weaveriip_save_menuopts','weaveriip_save_searchopts','weaveriip_save_disclaimer',
	'weaveriip_save_shortcoder'
        );

    foreach ($actions as $functionName) {
	if (isset($_POST[$functionName])) {
            if (function_exists($functionName)) {
		$functionName();
	    }
        }
    }
}


?>
