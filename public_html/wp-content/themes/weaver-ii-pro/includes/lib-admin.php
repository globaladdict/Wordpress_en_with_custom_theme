<?php
/*	Weaver II Theme

  This file contains all the functions needed to interact with the different
  options and settings.

  Options are saved in the WP DB in one option called 'weaverii_main_settings'.

    This file includes the interface to the WP Settings API.

   Because the SAPI is quite limiting on the format of the output fields
   supported by add_settings_field, we will not use that part.

   Settings that need validation and nonce handling, we use our function weaverii_sapi_advanced_name() that
   generates the <input name="weaverii_main_settings[wii_option_name]" ...> format required for
   processing by the sapi handlers. They create an array called $_POST['weaverii_main_settings']. Each
   setting in that array corresponds to a Weaver II option value, and will be passed to the
   validation function.

   We will wrap the two main forms (Main Options and most Advanced Options with our functions
   weaverii_sapi_form_top() and weaverii_sapi_form_bottom() that generates required calls to sapi.

   All other forms will use submit buttons that include their own nonce definition. Other forms generally
   do not change individual settings, but take actions such as save/restore or setting a sub-theme.
*/


/*
    ================= Main SAPI helper functions =================
*/

function weaverii_sapi_form_top($group, $form_name='') {
    /* beginning of a form */
    $name = '';
    if ($form_name != '') $name = 'name="' . $form_name . '"';

    echo("<form action=\"options.php\" $name method=\"post\">\n");	/* <form action="options.php" method="post"> */
    settings_fields($group);		// use our one set of settings
}

function weaverii_sapi_form_bottom($form_name='end of form') {

    $non_sapi = array(		// non-sapi elements in the db
	'wii_version_id', 'wii_style_version', 'wii_themename', 'wii_subtheme', 'wii_theme_image',
	'wii_theme_description', 'wii_hide_old_weaver', 'wii_theme_filename', '_wii_save_mods_basic', '_wii_save_mods_pro'

    );

    /*	The following code allows the SAPI to save the non-sapi values. If you don't do this here, then the values will
	be set to false, and be lost! SAPI is not tolerant of submitting a form that doesn't include EVERY setting for the form group. */

    foreach ($non_sapi as $name) {
?>
	<input name="<?php weaverii_sapi_advanced_name($name); ?>" id="<?php echo $name;?>" type="hidden" value="<?php echo weaverii_getopt($name); ?>" />
<?php
    }
    echo ("</form> <!-- $form_name -->\n");
}

function weaverii_sapi_submit($submit_action = 'Submit', $submit_label = 'Submit', $class='button-primary') {
	// generate a submit button for the form
?>
	<input name="<?php echo($submit_action); ?>" type="submit" class="<?php echo($class); ?>" value="<?php echo($submit_label); ?>" />
<?php
}

function weaverii_sapi_advanced_name($id, $echo=true) {
    /* generate the SAPI name for 'weaverii_advanced_settings' */
    if ($echo) echo 'weaverii_settings[' . $id . ']';
    return 'weaverii_settings[' . $id . ']';
}

function weaverii_sapi_main_name($id, $echo=true) {
    /* generate the SAPI name for 'weaverii_main_settings' */
    if ($echo) echo 'weaverii_settings[' . $id . ']';
    return 'weaverii_settings[' . $id . ']';
}

/*
    ============== Validation =====================
*/
function weaverii_validate_all_options($in) {

   /* validation for all options  */

    $err_msg = '';			// no error message yet

    if (empty($in)) {
	return $in;
    }

    foreach ($in as $key => $value) {
	switch ($key) {

	    /* -------- integer -------- */
	    case 'wii_excerpt_length':

		if (!empty($value) && (!is_numeric($value) || !is_int((int)$value))) {
		    $opt_id = str_replace('wii_', '', $key);
		    $opt_id = str_replace('_', ' ', $opt_id);
		    $err_msg .= __('Option must be an integer value: ', 'weaver-ii'/*a*/ ) . '"'. $opt_id . '" = "' . $value . '".'
			    . __(' Value has been cleared to blank value', 'weaver-ii'/*a*/ ) . '<br />';
		    $in[$key] = '';
		}
		break;

	    /* ---------- text ----------- */
	    case 'wii_excerpt_more_msg':
	    case 'wii_header_maxwidth':

		if (!empty($value))
		    $in[$key] = weaverii_filter_textarea($value);
		break;

	    /* code */

	    case '_wii_metainfo':               	// meta info for header
	    case 'wii_theme_head_opts':		// Predefined Theme CSS Rules
	    case 'wii_menu_addhtml-left':	// add html to left menu
	    case 'wii_menu_addhtml':
	    case '_wii_copyright':		// Alternate copyright
	    case '_wii_css_rows':
	    case 'ftp_hostname':
	    case 'ftp_username':
	    case '_wii_search_button_url':
		if (!empty($value)) {
		    $in[$key] = weaverii_filter_code($value);
		}
		break;

	    case 'ftp_password':		// special handling for password
		if (!empty($value)) {
		    $c_t = weaverii_encrypt(trim($value));
		    $in[$key] = $c_t;
		}
		break;

	    case 'wii_perpagewidgets':       	// Add widget areas for per page - names must be lower case
		if (!empty($value)) {
		    $in[$key] = strtolower(str_ireplace(' ','',weaverii_filter_code($value)));
		}
		break;

	    /* must not have <style .... </style> */
	    case 'wii_add_css':              	// Add CSS Rules to Weaver II's style rules

		if (!empty($value)) {
		    $val = weaverii_filter_code($value);
		    $in[$key] = $val;
		    if (stripos($val,'<style') !== false || stripos($val, '</style') !== false) {
			$err_msg .= __('"Add CSS Rules" option must not contain &lt;style&gt; tags!', 'weaver-ii'/*a*/ )
			    . __(' Please correct your entry.', 'weaver-ii'/*a*/ ) . '<br />';
		    }

		}
		break;

	    default:				/* to here, then colors, _css, or checkbox/selectors */
		$keylen = strlen($key);

		if (strrpos($key,'_css') == $keylen-4) {	// all _css settings
		    if (!empty($value)) {
			$val = weaverii_filter_code($value);
			$in[$key] = $val;

			if (strpos($val, '{') === false || strpos($val, '}') === false) {
			    $opt_id = str_replace('_css', '', $key);	// kill _css
			    $opt_id = str_replace('wii_', '', $opt_id);
			    $opt_id = str_replace('_', ' ', $opt_id);
			    $err_msg .= __('CSS options must be enclosed in {}\'s: ', 'weaver-ii'/*a*/ ) . '"'. $opt_id . '" = "' . $value . '".'
				. __(' Please correct your entry.', 'weaver-ii'/*a*/ ) . '<br />';
			}
		    }
		    break;
		} // _css

		if (strrpos($key,'_insert') == $keylen-7) {	// all _insert settings
		    if (!empty($value)) {
			$val = weaverii_filter_code($value);
			$in[$key] = $val;
		    }
		    break;
		} // _insert

		if (strrpos($key,'_url') == $keylen-4) {	// all _url settings
		    if (!empty($value)) {
			$val = esc_url_raw($value);
			$in[$key] = $val;
		    }
		    break;
		} // _insert


		if (strrpos($key,'_int') == $keylen-4 ||	// _int settings
		    strrpos($key,'_X') == $keylen-2 ||
		    strrpos($key,'_Y') == $keylen-2 ||
		    strrpos($key,'_L') == $keylen-2 ||
		    strrpos($key,'_R') == $keylen-2 ||
		    strrpos($key,'_T') == $keylen-2 ||
		    strrpos($key,'_B') == $keylen-2 ) {
		    if (!empty($value) && (!is_numeric($value) || !is_int((int)$value))) {
			$opt_id = str_replace('wii_', '', $key);
			$opt_id = str_replace('_int', '', $opt_id);
			$opt_id = str_replace('_', ' ', $opt_id);
			$err_msg .= __('Option must be an integer value: ', 'weaver-ii'/*a*/ ) . '"'. $opt_id . '" = "' . $value . '".'
			    . __(' Value has been cleared to blank value.', 'weaver-ii'/*a*/ ) . '<br />';
			$in[$key] = '';
		    }
		    break;
		}

		if (strrpos($key,'color') == $keylen-5) {	// _bgcolor and _color (order here important - after _css, etc.)
		    if (!empty($value)) {
			$val = weaverii_filter_code($value);
			if (strpos($val, '#') !== false)
			    $val = strtoupper($val);		// force hex values to upper case, just to be tidy
			if ($val == WEAVERII_DEFAULT_COLOR)
			    $val = '';
			$in[$key] = $val;
		    }
		    break;
		}

		break;
	}
    }
    if (!empty($err_msg)) {
	add_settings_error('weaverii_settings', 'settings_error', $err_msg,'error');
    } else {
	add_settings_error('weaverii_settings', 'settings_updated', __('Weaver II  Settings Saved.', 'weaver-ii'/*a*/ ),'updated');
    }
    return $in;
}

// ========================== utils ==================================
function weaverii_donate_button() {

    if (!weaverii_init_base() && !weaverii_getopt_checked('_wii_hide_donate')) { ?>
<div style="float:right;padding-right:30px;"><small><strong>Like Weaver II? Please</strong></small>
<form action="https://www.paypal.com/cgi-bin/webscr" method="post">
<input type="hidden" name="cmd" value="_s-xclick">
<input type="hidden" name="hosted_button_id" value="6Y68LG9G9M82W">
<input type="image" src="https://www.paypalobjects.com/en_US/i/btn/btn_donate_LG.gif" border="0" name="submit" alt="PayPal - The safer, easier way to pay online!">
<img alt="" border="0" src="https://www.paypalobjects.com/en_US/i/scr/pixel.gif" width="1" height="1">
</form>
</div>
<?php }
}

function weaverii_check_theme() {
?>
<form style="float:right;margin-right:15px;" name="checkweaverii_form" method="post">
    <span class="submit"><input type="submit" name="check_weaver" value="Check Theme for Possible Problems"/></span>
    <?php weaverii_nonce_field('check_weaver'); ?>
</form> <!-- wii_resetweaverii_form -->
<?php
}

function weaverii_clear_messages() {
?>
<form style="float:right;margin-right:15px;" name="clearweaverii_form" method="post">
    <span class="submit"><input type="submit" name="weaver_clear_messages" value="Clear Messages"/></span>
    <?php weaverii_nonce_field('weaver_clear_messages'); ?>
</form> <!-- wii_resetweaverii_form -->
<?php
}

function weaverii_check_version($force=false) {
    if (weaverii_getopt('_wii_hide_updatemsg')) return;
    $version = WEAVERII_VERSION;
    if (weaverii_init_base()) {
	$check_site = 'http://weaverthemepro.wordpress.com';
	$home_site = 'http://weavertheme.com';
	$msg = ') is available in the member downloads area at <a href="http://pro.weavertheme.com" target="_blank">pro.WeaverTheme.com</a>.';
    } else {
	$check_site = 'http://weavertheme.wordpress.com';
	$home_site = 'http://weavertheme.com';
	$msg = ') is available available now or very soon from WordPress.org.<br /> The latest version is always available at <a href="http://weavertheme.com" target="_blank">WeaverTheme.com</a>.';
    }

    $latest = weaverii_latest_version($check_site);     // check if newer version is available
    if (stripos($latest,'announcement') !== false) {
      weaverii_save_msg( $latest . ' - Please check <a href="' . $home_site . '" target="_blank">' . $home_site . '</a>.');
    } else if ($latest != 'unavailable' && version_compare($version,$latest,'<') ) {
       weaverii_save_msg('Current ' . WEAVERII_THEMENAME . ' version is ' . $version . '. A newer version (' . $latest .
             $msg);
    } else if ($force) {
	return 'Current ' . WEAVERII_THEMENAME . ' version is ' . $version . '. You have the latest version.';
    }
    return '';
}

function weaverii_check_cache_plugins($before='<p style="border:1px solid black;padding:2px 2px 2px 6px;background:#faa">',$after='</p>') {

    $bad_cache = '';

    if (function_exists('wpsupercache_site_admin'))
	$bad_cache = "the WP Super Cache Plugin";

    if (function_exists('wpgc_handle_user_interactions'))
	$bad_cache = "WP Green Cache";

    if (function_exists('hyper_activate'))
	$bad_cache = "Hyper Cache";


    if ($bad_cache != '') {
    echo $before; ?>
<strong style="color:red;">WARNING!</strong> You are using
<strong><?php echo $bad_cache; ?></strong>.
Currently, <strong>Weaver II is not compatible with that cache plugin</strong>. Visitors using a Mobile Device to view your site will
not get the correct content when using this cache plugin. Most cache plugins will not work with Weaver II. However,
<strong>Quick Cache</strong> and <strong>W3 Total Cache</strong> do work with Weaver II when properly set up.
Please see the Weaver II help file for instructions on
using compatible cache. Click here &rarr; <?php weaverii_help_link('help.html#quickcache','Cache Settings for Weaver II');?>
<?php
    echo $after;
    }

    $good_cache = '';
    if (function_exists('ws_plugin__qcache_configure_options_and_their_defaults'))
	$good_cache = 'Quick Cache';

    if (function_exists('w3_load_plugins'))
	$good_cache = "the W3 Total Cache Plugin";
    if ($good_cache) {
	echo $before;
?>
    <strong>NOTICE!</strong> You are using
<strong><?php echo $good_cache; ?></strong>.
Currently, <strong>Weaver II requires custom settings</strong> to work properly with that cache plugin. If you have
not yet configured <em><?php echo $good_cache; ?></em>, please see the Weaver II help file for instructions on
using that plugin. Click here &rarr; <?php weaverii_help_link('help.html#quickcache','Cache Settings for Weaver II');?></p>
<?php
    echo $after;
    }

}

function weaverii_latest_version($check_site) {
    $rss = fetch_feed($check_site. '/feed/');
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

function weaverii_update_mods($from, $to) {
    /* update theme_mods_$from to theme_mods_$to, return true if changed
       Values of interest:
	'header_image' : full http:// path to header image. e.g. "http://wii.me/wp-content/themes/weaver/images/headers/mum.jpg"
	'random-uploaded-image' : set if true, not set otherwise (if set, header_image set to '')
	'background_image': full path to bg image. e.g. "http://wii.me/wp-content/uploads/2011/10/Kokopell1-82x150.png"
	'background_repeat': repeat string e.g., "repeat"
	'background_position_x': indicates left, center, right
	'background_attachment': indicates scroll/fixed
	'background_color': color

	!! need to do this once only.
     */
    $changed = false;
    if (($from_mods = get_option( "theme_mods_$from" )) !== false) {	// some old mods exist to change
	$to_mods = get_option( "theme_mods_$to");	// get current values
	if ($to_mods === false) {	// the to doesn't exist, so we might not do anything
	    if ($from == WEAVER_SLUG)	// we're converting from old weaver, so we need to do this
		$to_mods = array();
	    else			// there's nothing to do (e.g., Weaver II Pro not installed)
		return false;
	}
	$changed = true;
	$header = isset($from_mods['header_image']) ? $from_mods['header_image'] : false;
	if ($header !== false) {
	    // need to see if a default header, or custom.
	    $newpath = str_replace($from, $to, $header);	// change to current theme if a default image
	    if (weaverii_f_exists(weaverii_abs_file_path($newpath)))
		$to_mods['header_image'] = $newpath;			// can still find the image, so use it
	}
	if (isset($from_mods['random-uploaded-image'])) {
	    $to_mods['random-uploaded-image'] = $from_mods['random-uploaded-image'];
	}
	if (isset($from_mods['background_image'])) {
	    $to_mods['background_image'] = $from_mods['background_image'];
	}
	if (isset($from_mods['background_repeat'])) {
	    $to_mods['background_repeat'] = $from_mods['background_repeat'];
	}
	if (isset($from_mods['background_position_x'])) {
	    $to_mods['background_position_x'] = $from_mods['background_position_x'];
	}
	if (isset($from_mods['background_attachment'])) {
	    $to_mods['background_attachment'] = $from_mods['background_attachment'];
	}
	if (isset($from_mods['background_color'])) {
	    $to_mods['background_color'] = $from_mods['background_color'];
	}
    }
    if ($changed)
	update_option("theme_mods_$to",$to_mods);
    return $changed;
}

function weaverii_abs_file_path($http_path) {
    return untrailingslashit(ABSPATH) . parse_url($http_path,PHP_URL_PATH);
}
/*
    ==================== SAVE / RESTORE THEMES AND BACKUPS ==========================
*/

function weaverii_get_save_settings($is_theme) {
    // serialize current settings
    global $weaverii_opts_cache, $weaverii_pro_opts;;

    if (weaverii_init_base())
	weaverii_pro_update_options('write_backup');
    weaverii_update_options('write_backup');

    if ($is_theme) {
	$header = 'W2T-V01.00';			/* Save theme settings: 10 byte header */
	$theme_opts = array();
	$theme_opts['weaverii_base'] = $weaverii_opts_cache;
	foreach ($weaverii_opts_cache as $opt => $val) {
	    if ($opt[0] == '_')
		$theme_opts['weaverii_base'][$opt] = false;
	}
	$theme_opts['weaverii_pro'] = array();
	return $header . serialize($theme_opts);	/* serialize full set of options right now */
    } else {
	$header = 'W2B-V01.00';			/* Save all settings: 10 byte header */
	$theme_opts = array();
	$theme_opts['weaverii_base'] = $weaverii_opts_cache;
	$theme_opts['weaverii_pro'] = array();
	if (weaverii_init_base())
	    $theme_opts['weaverii_pro'] = $weaverii_pro_opts;
	return $header . serialize($theme_opts);	/* serialize full set of options right now */
    }
}

function weaverii_clear_cache_settings() {
    /* clear all settings */
    global $weaverii_opts_cache;
    foreach ($weaverii_opts_cache as $key => $value) {
	$weaverii_opts_cache[$key] = false;		// clear everything
    }
}

function weaverii_save_msg($msg) {
    echo '<div id="message" class="updated fade"><p><strong>' . $msg .
	    '</strong></p></div>';
}
function weaverii_error_msg($msg) {
    echo '<div id="message" class="updated fade" style="background:#F88;"><p><strong>' . $msg .
	    '</strong></p></div>';
}

function weaverii_check_for_old_weaver() {

    // sync theme_mods '_wii_save_mods_basic', '_wii_save_mods_pro'
    if (weaverii_init_base()) {
	if (!weaverii_getopt('_wii_save_mods_pro')) {
	    //echo '<h3>PRO - FIRST TIME, setting BASIC to PRO</h3>';
	    weaverii_update_mods(WEAVERII_SLUG,WEAVERII_PRO_SLUG);	// copy any weaver-ii settings if there
	}
	else {
	    //echo '<h3>PRO - copy PRO to BASIC</h3>';
	    weaverii_update_mods(WEAVERII_PRO_SLUG,WEAVERII_SLUG);	// copy any pro to basic because we are most recent
	}
	weaverii_setopt('_wii_save_mods_pro',time());
    }
    else {
	if (!weaverii_getopt('_wii_save_mods_basic')) {
	    //echo '<h3>BASIC - copy PRO to BASIC</h3>';
	    weaverii_update_mods(WEAVERII_PRO_SLUG,WEAVERII_SLUG);	// copy any weaver-ii settings if there
	}
	else {
	   // echo '<h3>BASIC - copy BASIC to PRO</h3>';
	    weaverii_update_mods(WEAVERII_SLUG,WEAVERII_PRO_SLUG);	// copy any basic to pro because we are most recent
	}
	weaverii_setopt('_wii_save_mods_basic',time());
    }

    if (function_exists( 'weaver_plus_plugin' ) ) {
?>
      <div style="background-color:#FFEEEE; border: 6px ridge red; margin: 0px 60px 0px 20px; padding-left:10px;">
	<p><span style="font-weight:bold;font-size:150%">CRITICAL NOTICE:</span> &nbsp; The <strong>Weaver Plus Theme Extension</strong>
	plugin for the old version of Weaver is installed and activated. <strong>It is not compatible with Weaver II!</strong>
	You <strong>must</strong> open the <em>Installed Plugins</em> admin panel, and <em>Deactivate</em> the
	<strong>Weaver Plus Theme Extension</strong> plugin for proper operation of Weaver II.</p>
	<p>You will <em>not</em> lose any Weaver Plus settings by deactivating (or even deleting) the Weaver Plus
	Theme Extension plugin. They will still be there if you need to re-activate it. All the features of Weaver Plus
	are included with Weaver II Pro, which is available for a small upgrade fee to existing Weaver Plus members.</p>
      </div>
      <?php
      return;
    }
    /* see if old Weaver 2.0 settings found, and tell them how to upgrade */
    if (weaverii_getopt('wii_hide_old_weaver') < 4 && get_option('weaver_main_settings'))
      {
	$val = weaverii_getopt('wii_hide_old_weaver') + 1;
	weaverii_setopt('wii_hide_old_weaver',$val);

?>
      <div style="background-color:#FFEEEE; border: 1px solid red; margin: 0px 60px 0px 20px; padding-left:10px;">
	<p><strong>Notice:</strong> Existing settings from an older version of Weaver have been found.
	If you would like to automatically convert most of those settings to this version, please
	go to the <em>Save/Restore</em> tab and click the convert button near the bottom. This message
	will automatically stop displaying after <?php echo 5 - $val; ?> more times.
	<?php weaverii_help_link('help.html#UpgradingWeaver','Help for Advanced Options'); ?>
	</p>
      </div>
      <?php
      }
}
//============================================ form builder ====================================


function weaverii_form_show_options($weaverii_olist, $begin_table = true, $end_table = true) {
    /* output a list of options - this really does the layout for the options defined in an array */
    if ($begin_table) {
?>
<div>
<table class="optiontable" style="margin-top:6px;">
<?php
    }
    foreach ($weaverii_olist as $value) {
	$value['type'] = weaverii_fix_type($value['type']);
	switch ($value['type']) {
	    case 'checkbox':
		weaverii_form_row_checkbox($value);
		break;
	    case 'ctext':
		weaverii_form_row_ctext($value);
		break;
	    case 'color':
		weaverii_form_row_color($value);
		break;
	    case 'hdr_widget':
		weaverii_form_row_hdr_widget($value);
		break;
	    case 'header':
		weaverii_form_row_header($value);
		break;
	    case 'header0':
		weaverii_form_row_header($value,true);
		break;
	    case 'hidden':
		break;
	    case 'inactive':
		weaverii_form_row_inactive($value);
		break;
	    case 'link':
		weaverii_form_row_link($value);
		break;
	    case 'note':
		weaverii_form_row_note($value);
		break;
	    case 'selectold':
		weaverii_form_row_selectold($value);
		break;
	    case 'select_id':
		weaverii_form_row_select_id($value);
		break;
	    case 'select_layout':
		weaverii_form_row_select_layout($value);
		break;
	    case 'subheader':
		weaverii_form_row_subheader($value);
		break;
	    case 'subheader_alt':
		weaverii_form_row_subheader_alt($value);
		break;
	    case 'submit':
		weaverii_form_row_submit($value);
		break;
	    case 'text':
	    case 'widetext':
		weaverii_form_row_text($value);
		break;
	    case 'text_xy':
		weaverii_form_row_text_xy($value);
		break;
	    case 'text_tb':
		weaverii_form_row_text_xy($value,'T','B');
		break;
	    case 'text_lr':
		weaverii_form_row_text_xy($value,'L','R');
		break;
	    case 'textmedia':
		weaverii_form_row_textarea($value,true);
		break;
	    case 'textarea':
		weaverii_form_row_textarea($value);
		break;
	    case 'val_percent':
		weaverii_form_row_val($value,'%');
		break;
	    case 'val_px':
		weaverii_form_row_val($value,'px');
		break;
	    case 'widget_area':
		weaverii_form_row_widget_area($value);
		break;
	    default:
		weaverii_form_row_subheader_alt($value);
		break;
	}

    }
    if ($end_table) {
?>
</table></div> <!-- close previous tab div -->
 	<br />
<?php
    }
}

function weaverii_fix_type($type) {
    // these are pro options if start with +. Pro will strip the +
    if ($type[0] == '+') {
	if (weaverii_init_base())
	    return substr($type,1);
	else
	    return 'inactive';
	// + return 'inactive';
	// $ return 'invisible';
    }
    return $type;
}

function weaverii_form_row_ctext($value) {

    $pclass = 'color {hash:true, adjust:false}';    // starting with V 1.3, allow text in color pickers
    $img_css = '<img src="'. get_template_directory_uri() . '/images/theme/css.png" />' ;
    $img_hide = get_template_directory_uri() . '/images/theme/hide.png' ;
    $img_show = get_template_directory_uri() . '/images/theme/show.png' ;
    $help_file = get_template_directory_uri() . '/help/css-help.html';
    $css_id = $value['id'] . '_css';
    $css_id_text = weaverii_getopt($css_id);
    if ($css_id_text && !weaverii_getopt( '_wii_hide_auto_css_rules' )) {
	$img_toggle = $img_hide;
    } else {
	$img_toggle = $img_show;
    }
?>
    <tr>
    <th scope="row" align="right"><?php echo $value['name']; ?>:&nbsp;</th>
    <td>
	<input class="<?php echo $pclass; ?>" name="<?php weaverii_sapi_main_name($value['id']); ?>" id="<?php echo $value['id']; ?>" type="text" style="width:90px" value="<?php if ( weaverii_getopt( $value['id'] ) != "") { echo weaverii_esc_textarea(weaverii_getopt( $value['id'] )); } else { echo ''; } ?>" />
<?php echo $img_css; ?><a href="javascript:void(null);" onclick="weaverii_ToggleRowCSS(document.getElementById('<?php echo $css_id . '_js'; ?>'), this, '<?php echo $img_show; ?>', '<?php echo $img_hide; ?>')"><?php echo '<img src="' . $img_toggle . '" />'; ?></a>
    </td>
<?php 	weaverii_form_row_info($value);
?>
    </tr>
<?php
    $css_rows = weaverii_getopt('_wii_css_rows');
    if ($css_rows < 1 || $css_rows > 25)
	$css_rows = 1;
    if ($css_id_text && !weaverii_getopt( '_wii_hide_auto_css_rules' )) { ?>
    <tr id="<?php echo $css_id . '_js'; ?>">
    <th scope="row" align="right"><span style="color:green;"><small>Custom CSS styling:</small></span></th>
	<td align="right"><small>&nbsp;</small></td>
	<td>
	    <small>You can enter CSS rules, enclosed in {}'s, and separated by <strong>;</strong>.
	    See <a href="<?php echo $help_file; ?>" target="_blank">CSS Help</a> for more details.</small><br />
	    <textarea name="<?php weaverii_sapi_main_name($css_id); ?>" rows=<?php echo $css_rows;?> style="width: 85%"><?php echo(weaverii_esc_textarea($css_id_text)); ?></textarea>
	</td>
    </tr>
<?php
    } else {
?>
    <tr id="<?php echo $css_id . '_js'; ?>" style="display:none;">
	<th scope="row" align="right"><span style="color:green;"><small>Custom CSS styling:</small></span></th>
	<td align="right"><small>&nbsp;</small></td>
	<td>
	    <small>You can enter CSS rules, enclosed in {}'s, and separated by <strong>;</strong>.
	    See <a href="<?php echo $help_file; ?>" target="_blank">CSS Help</a> for more details.</small><br />
	    <textarea name="<?php weaverii_sapi_main_name($css_id); ?>" rows=<?php echo $css_rows;?> style="width: 85%"><?php echo(weaverii_esc_textarea($css_id_text)); ?></textarea>
	</td>
    </tr>
<?php
    }
}

function weaverii_form_row_color($value) {

    $pclass = 'color {hash:true, adjust:false}';    // starting with V 1.3, allow text in color pickers
?>
    <tr>
    <th scope="row" align="right"><?php echo $value['name']; ?>:&nbsp;</th>
    <td>
	<input class="<?php echo $pclass; ?>" name="<?php weaverii_sapi_main_name($value['id']); ?>" id="<?php echo $value['id']; ?>" type="text" style="width:90px" value="<?php if ( weaverii_getopt( $value['id'] ) != "") { echo weaverii_esc_textarea(weaverii_getopt( $value['id'] )); } else { echo ''; } ?>" />
    </td>
<?php 	weaverii_form_row_info($value);
?>
    </tr>
<?php
}

function weaverii_form_row_header($value,$narrow=false) {
?>
    <tr>
	<th scope="row" align="left" style="width:200px;"><?php	/* NO SAPI SETTING */
	echo '<span style="font-weight:bold; font-size: larger;"><em>'.$value['name'].'</em></span>';
	if (!empty($value['help'])) {
	    weaverii_help_link($value['help'], 'Help for ' . $value['name']);
	    }
?>
	</th>
<?php
	if ($narrow) echo ('<td  style="width:80px;">&nbsp;</td>'. "\n");
	else echo ('<td style="width:170px;">&nbsp;</td>'. "\n");

	if ($value['info'] != '') {
	    echo('<td style="padding-left: 10px"><u><em><strong>'); echo $value['info'];
	    echo("</strong></em></u></td>\n");
	}
?>
    </tr>
<?php
}

function weaverii_form_row_subheader($value) {
?>
    <tr>
	<th scope="row" align="left" style="width:200px;line-height:2em;"><?php	/* NO SAPI SETTING */
	echo '<span style="color:blue; font-weight:bold; "><em><u>'.$value['name'].'</u></em></span>';
	if (!empty($value['help'])) {
	    weaverii_help_link($value['help'], 'Help for ' . $value['name']);
	    }
?>
	</th>
	<td style="width:170px;">&nbsp;</td>
<?php
	if ($value['info'] != '') {
	    echo('<td style="padding-left: 10px"><u><em>'); echo $value['info'];
	    echo("</em></u></td>\n");
	}
?>
    </tr>
<?php
}

function weaverii_form_row_inactive($value) {
?>
    <tr>
	<th scope="row" style="width:200px;"><?php	/* NO SAPI SETTING */
	echo '<span style="color:#999;float:right;">'.$value['name'].':&nbsp;</span>';
	if (!empty($value['help'])) {
	    weaverii_help_link($value['help'], 'Help for ' . $value['name']);
	    }
?>
	</th>
	<td style="color:#999;">Pro Version&nbsp;&nbsp;</td>
<?php
	if ($value['info'] != '') {
	    echo('<td style="padding-left:10px;color:#999;font-size:x-small;">'); echo $value['info'];
	    echo("</td>\n");
	}
?>
    </tr>
<?php
}

function weaverii_form_row_hdr_widget($value) {
    $name = $value['name'];
    $val['name'] = $name . ' Widget BG';
    $val['id'] = $value['id'] . '_bgcolor';
    $val['type'] = 'ctext';
    $val['info'] = 'Background color for ' . $name . ' widget.';
    weaverii_form_row_ctext($val);

    $val['name'] = $name . ' Widget Width';
    $val['id'] = $value['id'] . '_w_int';
    $val['type'] = 'val_pc';
    $val['info'] = 'Width of ' . $name . ' widget. (Use 0 to hide. Allows different widgets on regular and mobile views.)';
    weaverii_form_row_val($val,'%');

    $val['name'] = '<small>' . $name . ' Widget Mobile Width</small>';
    $val['id'] = $value['id'] . '_w_mobile_int';
    $val['type'] = 'val_pc';
    $val['info'] = 'Width of ' . $name . ' widget on mobile devices. (Use 0 to hide. Allows different widgets on regular and mobile views.) (Pro)';
    if (!weaverii_init_base())
	weaverii_form_row_inactive($val);
    else
	weaverii_form_row_val($val,'%');


}

function weaverii_form_row_subheader_alt($value) {
?>
    <tr>
	<th scope="row" align="left" style="width:200px;line-height:2em;"><?php	/* NO SAPI SETTING */
	echo '<span style="color:blue; font-weight:bold;padding-left:15px;"><em>'.$value['name'].'</em></span>';
	if (!empty($value['help'])) {
	    weaverii_help_link($value['help'], 'Help for ' . $value['name']);
	    }
?>
	</th>
	<td style="width:170px;">&nbsp;</td>
<?php
	if ($value['info'] != '') {
	    echo('<td style="padding-left: 10px;color:blue;">'); echo $value['info'];
	    echo("</td>\n");
	}
?>
    </tr>
<?php
}

function weaverii_form_row_textarea($value,$media = false) {
    $twide =  ($value['type'] == 'text') ? '60' : '140';
?>
    <tr>
	<th scope="row" align="right"><?php echo $value['name']; ?>:&nbsp;</th>
	<td colspan=2>
	    <textarea name="<?php weaverii_sapi_main_name($value['id']); ?>" id="<?php echo $value['id']; ?>" rows=1 style="width: 350px"><?php echo(esc_textarea( weaverii_getopt($value['id'] ))); ?></textarea>
<?php
    if ($media) {
	weaverii_media_lib_button($value['id']);
    }
?>
&nbsp;<small><?php echo $value['info']; ?></small>
	</td>

    </tr>
<?php
}

function weaverii_form_row_text($value,$media=false) {
    $twide =  ($value['type'] == 'text') ? '60' : '140';
?>
    <tr>
	<th scope="row" align="right"><?php echo $value['name']; ?>:&nbsp;</th>
	<td>
	    <input name="<?php weaverii_sapi_main_name($value['id']); ?>" id="<?php echo $value['id']; ?>" type="text" style="width:<?php echo $twide;?>px;height:22px;" class="regular-text" value="<?php echo esc_textarea(weaverii_getopt( $value['id'] )); ?>" />
<?php
	if ($media) {
	   weaverii_media_lib_button($value['id']);
	}
?>
	</td>
<?php	weaverii_form_row_info($value);
?>
    </tr>
<?php
}

function weaverii_form_row_val($value,$unit) {
?>
    <tr>
	<th scope="row" align="right"><?php echo $value['name']; ?>:&nbsp;</th>
	<td>
	    <input name="<?php weaverii_sapi_main_name($value['id']); ?>" id="<?php echo $value['id']; ?>" type="text" style="width:50px;height:22px;" class="regular-text" value="<?php echo esc_textarea(weaverii_getopt( $value['id'] )); ?>" /> <?php echo $unit; ?>
	</td>
<?php	weaverii_form_row_info($value);
?>
    </tr>
<?php
}

function weaverii_form_row_text_xy($value,$x='X',$y='Y') {
    $xid = $value['id'] . '_' . $x;
    $yid = $value['id'] . '_' . $y;
?>
    <tr>
	<th scope="row" align="right"><?php echo $value['name']; ?>:&nbsp;</th>
	<td>
	    <?php echo $x;?>:<input name="<?php weaverii_sapi_main_name($xid); ?>" id="<?php echo $xid; ?>" type="text" style="width:40px;height:20px;" class="regular-text" value="<?php echo weaverii_esc_textarea(weaverii_getopt( $xid )); ?>" /> px
	    &nbsp;<?php echo $y;?>:<input name="<?php weaverii_sapi_main_name($yid); ?>" id="<?php echo $yid; ?>" type="text" style="width:40px;height:20px;" class="regular-text" value="<?php echo weaverii_esc_textarea(weaverii_getopt( $yid )); ?>" /> px
	</td>
<?php	weaverii_form_row_info($value);
?>
    </tr>
<?php
}

function weaverii_form_row_checkbox($value) {
?>
    <tr>
    <th scope="row" align="right"><?php echo $value['name']; ?>:&nbsp;</th>
	<td>
	<input type="checkbox" name="<?php weaverii_sapi_main_name($value['id']); ?>" id="<?php echo $value['id']; ?>"
<?php 		checked(weaverii_getopt_checked( $value['id'] )); ?> >
	</td>
<?php 	weaverii_form_row_info($value);
?>
    </tr>
<?php
}

function weaverii_form_row_selectold($value) {
?>
    <tr>
	<th scope="row" align="right"><?php echo $value['name']; ?>:&nbsp;</th>
	<td>
	<select name="<?php weaverii_sapi_main_name($value['id']); ?>" id="<?php echo $value['id']; ?>">
<?php 	foreach ($value['value'] as $option) { ?>
            <option<?php if ( weaverii_getopt( $value['id'] ) == $option) { echo ' selected="selected"'; }?>><?php echo $option; ?></option>
<?php 	} ?>
	</select>
	</td>
<?php 	weaverii_form_row_info($value);
?>
	</tr>
<?php
}

function weaverii_form_row_select_id($value) {
?>
    <tr>
	<th scope="row" align="right"><?php echo $value['name']; ?>:&nbsp;</th>
	<td>
	<select name="<?php weaverii_sapi_main_name($value['id']); ?>" id="<?php echo $value['id']; ?>">
<?php
    foreach ($value['value'] as $option) {
    ?>
            <option value="<?php echo $option['val'] ?>" <?php if ( weaverii_getopt( $value['id'] ) == $option['val']) { echo ' selected="selected"'; }?>><?php echo $option['desc']; ?></option>
<?php 	} ?>
	</select>
	</td>
<?php 	weaverii_form_row_info($value);
?>
	</tr>
<?php
}
function weaverii_form_row_select_layout($value) {
    $list = array(array('val' => 'default', 'desc'=> 'Use Default' ),
	array('val' => 'right-1-col', 'desc'=> 'Single column sidebar on Right' ),
	array('val' => 'left-1-col', 'desc' => 'Single column sidebar on Left'),
	array('val' => 'right-2-col', 'desc' => 'Double Cols, Right (top wide)'),
	array('val' => 'left-2-col', 'desc' => 'Double Cols, Left (top wide)'),
	array('val' => 'right-2-col-bottom', 'desc' => 'Double Cols, Right (bottom wide)'),
	array('val' => 'left-2-col-bottom', 'desc' => 'Double Cols, Left (bottom wide)'),
	array('val' => 'split', 'desc' => 'Split - sidebars on Right and Left'),
	array('val' => 'one-column', 'desc' => 'No sidebars, one column content')
    );
    $value['value'] = $list;
    weaverii_form_row_select_id($value);
}

function weaverii_form_row_link($value) {
    $link = array ('name' => '<small>Link</small>', 'id' => $value['id'].'_color', 'type' => 'ctext', 'info' => 'Color of link');
    $strong = array ('name' => '<small>Bold</small>', 'id' => $value['id'].'_strong', 'type' => 'checkbox', 'info' => '<strong>Bold</strong> link');
    $em = array ('name' => '<small>Italic</small>', 'id' => $value['id'].'_em', 'type' => 'checkbox', 'info' => '<em>Italic</em> link');
    $visit = array ('name' => '<small>Visited</small>', 'id' => $value['id'].'_visited_color', 'type' => 'ctext', 'info' => 'Color when link has been visited (this option is generally falling out of use)');
    $hover = array ('name' => '<small>Hover</small>', 'id' => $value['id'].'_hover_color', 'type' => 'ctext', 'info' => 'Color when hovering');
    $under = array ('name' => '<small>Underline</small>', 'id' => $value['id'].'_u', 'type' => 'checkbox', 'info' => '<u>Underline</u> on hover');

    weaverii_form_row_subheader_alt($value);
    weaverii_form_row_ctext($link);
    weaverii_form_row_checkbox($strong);
    weaverii_form_row_checkbox($em);
    weaverii_form_row_ctext($visit);
    weaverii_form_row_ctext($hover);
    weaverii_form_row_checkbox($under);

}


function weaverii_form_row_note($value) {
?>
    <tr>
	<th scope="row" align="right">&nbsp;</th>
	    <td style="float:right;font-weight:bold;"><?php echo $value['name']; ?>&nbsp;</td>
<?php
	weaverii_form_row_info($value);
?>
    </tr>
<?php
}

function weaverii_form_row_submit($value) {
?>
<tr><th scope="row" align="left">
<?php
    weaverii_sapi_submit('save_options',__('Save Settings', 'weaver-ii'/*a*/ ));
?>
</th</tr><td>&nbsp;</td><td>&nbsp;</td></tr>
<?php
}

function weaverii_form_row_info($value) {
    if ($value['info'] != '') {
	echo('<td style="padding-left: 10px"><small>'); echo $value['info']; echo("</small></td>");
    }
}

function weaverii_form_row_widget_area($value) {
    // build the rows for widget area settigns
    /*
    Primary Sidebar Widget Area
    Background
    Left/Right Padding
    Top/Bottom Padding
    Top/Bottom Margin
    Border
*/
    $name = $value['name']; $id = $value['id'];
    $row = array('name' => '', 'id' => '', 'type' => '', 'info' => '');
    weaverii_form_row_subheader_alt($value);
    $row['name'] = 'Background'; $row['id'] = $id . '_bgcolor'; $row['info'] = $name . ': Background Color (use CSS+ to specify custom borders!)';
    weaverii_form_row_ctext($row);
    $row['name'] = 'Top/Bottom Margins'; $row['id'] = $id . '_margin'; $row['info'] = $name . ': Top and bottom margin (space between areas, default: T:0px B:10px)';
    weaverii_form_row_text_xy($row,'T','B');
    $row['name'] = 'Add Border'; $row['id'] = $id . '_std_border'; $row['info'] = $name . ': Add the "standard" border (as set on General Appearance tab)';
    weaverii_form_row_checkbox($row);

}


// require_once ("wvr-fileio.php");
?>
