<?php
/* Weaver II - admin Save/Restore
 *
 * This will come after the Options form has been closed, and is used for non-SAPI options
 *
 */

function weaverii_admin_saverestore() {
    ?>
<h3>Save/Restore Theme Settings <?php weaverii_help_link('help.html#SaveRestore','Help on Save/Restore Themes');?></h3>
<h3 style="color:blue;">Save/Restore Current Settings using WordPress Database</h3>
<p>This option allows you to save and restore all current theme settings using your host's WordPress database. Your options will be
preserved across Weaver II theme upgrades, as well when you change to different themes. There is only one
saved backup avaiable. Weaver II Pro allows multiple saves using files.</p>
<p>Note: This save opyion saves <strong>all</strong> settings, including those marked with a &diams;. Other save options
(available with Weaver II Pro or the <em>Weaver II Theme Extras</em> plugin) will save all settings (backup save), or just
those settings that are theme related (settings <em>not</em> marked with  &diams;).</p>
<form name="wii_save_mysave_form" method="post"
	<span class="submit"><input type="submit" name="save_mytheme" value="Save Settings"/></span>
	<strong>Save all current settings in host WordPress database.</strong>
<?php	 weaverii_nonce_field('save_mytheme'); ?>
	<br /><br />
	<span class="submit"><input type="submit" name="restore_mytheme" value="Restore Settings"/></span>
	<strong>Restore from saved settings.</strong>
<?php 	weaverii_nonce_field('restore_mytheme'); ?>
    </form>
    <hr />

<?php
    if (weaverii_init_base()) {
	weaverii_pro_saverestore();
    } else {
	if (function_exists('weaverii_ex_saverestore'))
	    weaverii_ex_saverestore();
	else {
?>
<p>Add <strong>Save/Restore Current Theme Settings using Your Computer</strong> capability to Weaver II basic. Download
the <em>Weaver II Theme Extras</em> plugin from WordPress.org or
<a href="http://weavertheme.com" target="_blank">WeaverTheme.com</a>.
<?php
	}
    }
?>

    <hr />
    <h3 style="color:blue;">Convert previous Weaver (2.2.x) Settings to Weaver II Settings<?php weaverii_help_link('help.html#UpgradingWeaver','Help for Advanced Options'); ?></h3>
	<form name="resetweaverii_form" method="post">
	    <strong>Click the Convert Old Weaver Settings button to convert the settings from the previous version to the
	    new Weaver II settings.</strong><br />
<?php	    if (weaverii_init_base()) {
?>
	    This will also convert Weaver Plus settings if they are present.<br />
<?php	    } ?>
	    <em>Warning: You will lose all current settings.</em> You should use the
	    Save/Restore tab to save a copy of your current settings before converting!<br />
	    <span class="submit"><input type="submit" name="convert_weaver" value="Convert Old Weaver Settings"/></span>
	    <?php weaverii_nonce_field('convert_weaver'); ?>
	</form> <!-- wii_resetweaverii_form -->
    <h3 style="color:blue;">Reset Current Settings to Default</h3>
	<form name="resetweaverii_form" method="post" onSubmit="return confirm('Are you sure you want to reset all Weaver II settings?');">
	    <strong>Click the Clear button to reset all Weaver II settings to the default values.</strong><br >
<?php	    if (weaverii_init_base()) {
?>
	    This will also include Weaver II Pro settings.<br />
<?php	    } ?>
	    <em>Warning: You will lose all current settings.</em> You should use the Save/Restore tab to save a copy
	    of your current settings before clearing! <br />
	    <span class="submit"><input type="submit" name="reset_weaverii" value="Clear All Weaver II Settings"/></span>
	    <?php weaverii_nonce_field('reset_weaverii'); ?>
	</form> <!-- wii_resetweaverii_form -->
<?php
}

function weaverii_process_options_admin_standard() {

    if (weaverii_submitted('reset_weaverii')) {
	// delete everything!
	weaverii_save_msg(__('All Weaver II settings have been reset to the defaults.','weaver-ii'));
	delete_option('weaverii_settings');
	global $weaverii_opts_cache;
	$weaverii_opts_cache = false;	// clear the cache
	weaveriip_clear_opts();
	weaverii_init_opts('reset_weaverii');
    }
    if (weaverii_submitted('convert_weaver')) {
	require_once('admin-convert-old-weaver.php');
	weaverii_convert_old_weaver();
    }

    if (weaverii_submitted('uploadtheme_ex') && !weaverii_init_base() && function_exists('weaverii_ex_loadtheme')) {
	    weaverii_ex_loadtheme();
    }

    if (weaverii_submitted('check_weaver'))
    {
	// perform weaver check
	require_once('check-theme.php');	// include check code now
	weaverii_perform_check();
    }


}
?>
