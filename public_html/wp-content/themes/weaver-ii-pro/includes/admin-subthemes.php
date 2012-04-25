<?php
/* Weaver II - admin Subtheme
 *
 * This is the intro form. It won't have any options because it will be outside the main form
 */

function weaverii_admin_subthemes() {

?>
<h3>Predefined Weaver II Sub-Themes
<?php weaverii_help_link('help.html#PredefinedThemes','Help for Weaver II Predefined Themes');?>
<small style="font-weight:normal;font-size:10px;">&nbsp;&larr; You can click the ?'s found throughout Weaver II admin pages for context specific help.</small></h3>
<b>Welcome to Weaver II</b>

<p>Weaver II gives you extreme control of your WordPress blog appearance using the
different admin tabs here. This tab lets you get a quick start by picking one of the many
predefined sub-themes. Once you've picked a starter theme, use the <em>Main Options</em> and <em>Advanced Options</em>
tabs to tweak the theme to be whatever you like. After you have a theme you're happy with,
you can save it from the Save/Restore tab. The <em>Help</em> tab has much more <b>useful</b> information.</p>

<h4>Get started by trying one of the predefined sub-themes!</h4>
<?php
    if (weaverii_init_base())
	$theme_dir = trailingslashit(WP_CONTENT_DIR) . 'themes/weaver-ii-pro/subthemes/';
    else
	$theme_dir = trailingslashit(WP_CONTENT_DIR) . 'themes/weaver-ii/subthemes/';
    $theme_list = array();
    if($media_dir = opendir($theme_dir)){	    // build the list of themes from directory
	while ($m_file = readdir($media_dir)) {
	    $len = strlen($m_file);
	    $base = substr($m_file,0,$len-4);
	    $ext = $len > 4 ? substr($m_file,$len-4,4) : '';
	    if($ext == '.w2t' ) {
		$theme_list[] = $base;
	    }
	}
    }

    if (!empty($theme_list)) {
	//asort($theme_list);
	weaverii_st_pick_theme($theme_list);	// show the theme picker

	// show the thumbs in a 4 column table
	echo("<hr />\n<h3>Sub-theme thumbnails</h3>\n");
	if (!weaverii_getopt_checked('_wii_hide_theme_thumbs')) {
	    echo "<table>";
	    $thumbs = weaverii_relative_url('/subthemes/');
	    $i = 1;		// column counter
	    echo("<tr>");
	    foreach ($theme_list as $theme) {
		echo '<td style="padding:10px;"><strong>' . ucwords(str_replace('-',' ',$theme)) . '</strong></br><img src="'.
		    $thumbs . $theme . '.jpg' . '" height="150" width = "200" /></td>';
		$i++;
		if ($i > 4) {
		    echo "</tr>\n<tr>";
		    $i=1;
		}
	    }
	    echo "</tr></table>\n";
	} else {
	    echo "Uncheck 'Hide Theme Thumbnails' on <em>Admin Options</em> tab to show theme preview thumbnails.";
	}
    } else {
	echo "<h3>WARNING: Your version of Weaver II is likely installed incorrectly. Unable to find sub-theme defiitions.</h3>\n";
    }
}

function weaverii_st_pick_theme($list) {
    // output the form to select a file list from weaverii-subthemes directory
?>
<form enctype="multipart/form-data" name='pick_theme' method='post'>
    &nbsp;&nbsp;<strong>Select a sub-theme: &nbsp;</strong>
    <select name="wii_theme_picked" id="wvr_pick_theme">
<?php
    $cur_theme = weaverii_getopt('wii_theme_filename');
    if (!$cur_theme) $cur_theme = 'antique-ivory';	// the default theme
    foreach ($list as $theme) {
	$selected = ($cur_theme == $theme) ? ' selected="selected"' : '';
        echo '<option value="' . $theme . '"' . $selected . '>'
	  . ucwords(str_replace('-',' ',$theme)).'</option>';
    }

?>
    </select>
    <small>Select a predefined sub-theme from the list.    Current theme: <strong><?php echo ucwords(str_replace('-',' ',$cur_theme)); ?></strong></small>


    <br /><br /><span class='submit'><input name="set_subtheme" type="submit" value="Set to Selected Sub-Theme" /></span>&nbsp;
    <small><strong>Note:</strong> Selecting a new theme will change only theme related settings. Most Advanced Options will be retained.
    You can use the Save/Restore tab to save a copy of all your current settings first.</small></td></tr>
                <tr><td>&nbsp;</td></tr>
	</table>
	<?php weaverii_nonce_field('set_subtheme'); ?>
    </form>
<?php
}

function weaverii_process_options_themes() {

    if (weaverii_submitted('set_subtheme')) {	// invoked from Weaver II Themes tab (this file)
	if (isset($_POST['wii_theme_picked'])) {
	    $theme = weaverii_filter_textarea($_POST['wii_theme_picked']);

	    if (weaverii_activate_subtheme($theme))
		weaverii_save_msg(__("Sub-Theme Selected: ", 'weaver-ii'/*a*/ ) . $theme );
	    else
		weaverii_save_msg(__("Invalid Sub-Theme file detected. Your installation of Weaver II may be broken.", 'weaver-ii'/*a*/ ));
	} else {
	    weaverii_save_msg(__("Please select a sub-theme.", 'weaver-ii'/*a*/ ));
	}
    }

    if (weaverii_submitted('save_mytheme')) {	// invoked from Save/Restore tab
	weaverii_save_msg(__("Current settings saved in WordPress database.", 'weaver-ii'/*a*/ ));
	weaverii_setopt('wii_theme_filename','custom');
	global $weaverii_opts_cache;
	if (!$weaverii_opts_cache)
	    $weaverii_opts_cache = get_option('weaverii_settings',array());
	if (current_user_can( 'manage_options' ))
	    update_option('weaverii_settings_backup',$weaverii_opts_cache);
	weaveriip_save_opts_backup();
    }

    if (weaverii_submitted('restore_mytheme')) {	// invoked from Save/Restore tab
	global $weaverii_opts_cache;
	$saved = get_option('weaverii_settings_backup',array());
	if (!empty($saved)) {
	    $weaverii_opts_cache = $saved;
	    weaverii_wpupdate_option('weaverii_settings',$weaverii_opts_cache);
	}
	weaveriip_restore_opts_backup();
	weaverii_save_msg(__("Current settings restored from WordPress database.", 'weaver-ii'/*a*/ ));
    }
}

function weaverii_activate_subtheme($theme) {
    /* load settings for specified theme */
    global $weaverii_opts_cache;

    /* build the filename - theme files stored in /wp-content/themes/weaverii/subthemes/

    Important: the following code assumes that any of the pre-defined theme files won't have
    and end-of-line character in them, which should be true. A user could muck about with the
    files, and possibly break this assumption. This assumption is necessary because the WP
    theme rules allow file(), but not file_get_contents(). Other than that, the following code
    is really the same as the 'theme' section of weaverii_upload_theme() in the pro library
    */

    $filename = get_template_directory() . '/subthemes/' . $theme . '.w2t';

    $contents = weaverii_f_get_contents($filename);	// use either real (pro) or file (standard) version of function

    if (empty($contents)) return false;

    if (substr($contents,0,10) != 'W2T-V01.00')
	return false;

    $restore = array();
    $restore = unserialize(substr($contents,10));

    if (!$restore) return false;
    $version = weaverii_getopt('wii_version_id');	// get something to force load

    // need to clear some settings
    // first, pickup the per-site settings that aren't theme related...
    $new_cache = array();
    foreach ($weaverii_opts_cache as $key => $val) {
	if ($key[0] == '_') {	// these are non-theme specific settings
	    $new_cache[$key] = $weaverii_opts_cache[$key];	// clear
	}
    }
    $opts = $restore['weaverii_base'];	// fetch base opts
    weaverii_delete_all_options();

    foreach ($new_cache as $key => $val) {	// set the values we need to keep
	weaverii_setopt($key,$new_cache[$key],false);
    }
    foreach ($opts as $key => $val) {
	if ($key[0] == '_') continue;	// should be here
	weaverii_setopt($key, $val, false);	// overwrite with saved theme values
    }

    weaverii_setopt('wii_theme_filename',$theme);

    weaverii_save_opts('set sub-theme');	// OK, now we've saved the options, update them in the DB
    return true;
}
?>
