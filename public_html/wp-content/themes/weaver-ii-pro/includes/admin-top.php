<?php
/*
    Weaver II Admin - Uses yetii JavaScript to build tabs.
    Tabs include:
	Weaver Themes		(in wvr-subthemes.php)
	Main Options		(in this file)
	Advanced Options	(in wvr_advancedopts.php)
	Save/Restore Themes	(in wvr-subthemes.php)
	Snippets		(in wvr-help.php)
	CSS Help		ditto
	Help			ditto
/*
    ========================= Weaver Admin Tab - Main Options ==============
*/
function weaverii_do_admin() {
/* theme admin page */

/* This generates the startup script calls, etc, for the admin page */
    global $weaverii_opts_cache, $weaverii_main_options, $weaverii_main_opts_list;

    if (!current_user_can('edit_theme_options')) wp_die("No permission to access that page.");

    weaverii_admin_page_process_options();	// Process non-sapi options

    if (weaverii_getopt('wii_subtheme') == 'none')
	weaverii_activate_subtheme('antique-ivory');		// first time run, so we gotta load the theme

    echo('<div class="wrap">');
    screen_icon("themes");	/* add a nice icon to the admin page */
?>
<div style="float:left;"><h2><?php echo(WEAVERII_THEMEVERSION); ?> Options</h2><a name="top_main" id="top_main"></a></div>
<?php weaverii_donate_button();
    weaverii_check_theme();
    weaverii_clear_messages();
?>

<div style="clear:both;">

<?php
    weaverii_check_for_old_weaver();
    weaverii_check_version();		// check version RSS
      // @@@@ weaverii_check_write_files();
?>

<div id="tabwrap">
  <div id="tab-admin" class='yetii'>
    <ul id="tab-admin-nav" class='yetii'>
      <li><a href="#tab_themes" title="Select from pre-defined sub-themes"><?php echo(__('Weaver II Themes', 'weaver-ii'/*a*/ )); ?></a></li>
      <li><a href="#tab_main" title="Main options for most theme elements: site appearance, layout, header, menus, content, footer, fonts, more."><?php echo(__('Main Options', 'weaver-ii'/*a*/ )); ?></a></li>
      <li><a href="#tab_advanced" title="Advanced options: HTML, code, CSS insertion; page templates, background images, SEO, site options."><?php echo(__('Advanced Options', 'weaver-ii'/*a*/ )); ?></a></li>
      <li><a href="#tab_admin" title="Basic Administrative Options."><?php echo(__('Admin Options', 'weaver-ii'/*a*/ )); ?></a></li>
      <li><a href="#tab_pro" title="Settings for Weaver II Pro edition: tools, activate plugins and features."><?php echo(__('Weaver II Pro', 'weaver-ii'/*a*/ )); ?></a></li>
      <li><a href="#tab_shortcodes" title="Weaver and Weaver Pro Shortcodes."><?php echo(__('Shortcodes', 'weaver-ii'/*a*/ )); ?></a></li>
      <li><a href="#tab_saverestore" title="Save and Restore theme settings."><?php echo(__('Save/Restore', 'weaver-ii'/*a*/ )); ?></a></li>
      <li><a href="#tab_help" title="Table of Content links to Weaver Help files"><?php echo(__('Help', 'weaver-ii'/*a*/ )); ?></a></li>
    </ul>

<?php //  list is order specific - above and below must match ?>

      <div id="tab_themes" class="tab" >
<?php 	weaverii_admin_subthemes(); ?>
      </div>
<?php
      // ====================== Begin the big form here =====================
    weaverii_sapi_form_top('weaverii_settings_group','weaverii_options_form');
?>
      <div id="tab_main" class="tab" >
<?php weaverii_admin_mainopts(); ?>
      </div>

      <div id="tab_advanced" class="tab" >
<?php weaverii_admin_advancedopts(); ?>
      </div>

      <div id="tab_advanced" class="tab" >
<?php weaverii_admin_admin(); ?>
      </div>

      <div id="tab_pro" class="tab" >
<?php weaverii_admin_pro(); ?>
      </div>

<?php
    weaverii_sapi_form_bottom();		// end of SAPI opts here. Can't cross <div>s! Non-sapi forms follow
    // ===================== end of big form  =====================
?>
    <div id="tab_shortcodes" class="tab" >
<h3>Weaver Shortcodes</h3>

<br /><p><a href="<?php echo site_url('/wp-admin/themes.php?page=WeaverII_Shortcodes'); ?>">
<span style="color:white;background:#57A;padding:4px;font-weight:bold;">Open Shortcodes Admin</span></a></p>
<br /><p>Settings and information about Weaver II  and Weaver II Pro Shortcodes are found on the
<a href="<?php echo site_url('/wp-admin/themes.php?page=WeaverII_Shortcodes'); ?>"><em>Appearance&rarr;Shortcodes + Pro</em></a>
menu found at the left.
</p>
    </div>
    <div id="tab_saverestore" class="tab" >
<?php weaverii_admin_saverestore(); ?>
    </div>
    <div id="tab_help" class="tab" >
<?php weaverii_admin_help(); ?>
    </div>
   </div> <!-- #tab-saverestore -->
</div> <!-- #tabwrap -->

<script type="text/javascript">
	var tabberAdmin = new Yetii({
	id: 'tab-admin',
	tabclass: 'tab',
	persist: true
	});
</script>

<?php
}	/* end weaverii_do_admin */

/*
    ================= process settings when enter admin pages ================
*/
function weaverii_admin_page_process_options() {
    /* Process all options - called upon entry to options forms */

    // Most options are handled by the SAPI filter.

    settings_errors();			// display results from SAPI save settings

    global $weaverii_opts_cache;

    weaverii_process_options_themes(); 	// >>>> Weaver II Themes Tab

    weaverii_process_options_admin_standard();	// setting from admin page

    /* this tab has the most individual forms and submit commands */

    weaverii_process_options_admin_pro();

    /* ====================================================== */

     weaverii_save_opts('Weaver II Admin');			/* FINALLY - SAVE ALL OPTIONS AND UPDATE CURRENT CSS FILE */

}

function weaverii_admin_admin() {
?>
<h3>Basic Administrative Options <?php weaverii_help_link('help.html#AdminOptions','Help for Admin Options'); ?></h3>
<?php
    weaverii_sapi_submit('save_options',__('Save Settings', 'weaver-ii'/*a*/ ));
?>
    <br /><br />
    These options control some administrative options and appearance features.
    <br />


<br />
    <input type="checkbox" name="<?php weaverii_sapi_advanced_name('_wii_hide_editor_style'); ?>" id="_wii_hide_editor_style" <?php checked(weaverii_getopt_checked( '_wii_hide_editor_style' )); ?> />
	<label>Disable Page/Post Editor Styling - </label><small>Checking this box will disable the Weaver sub-theme based styling in the Page/Post editor.
	If you have a theme using transparent backgrounds, this option will likely improve the Post/Page editor visibility.</small> &diams;<br />

    <input type="checkbox" name="<?php weaverii_sapi_advanced_name('_wii_hide_updatemsg'); ?>" id="wii_hide_updatemsg" <?php checked(weaverii_getopt_checked( '_wii_hide_updatemsg' )); ?> />
	<label>Hide Update Messages - </label><small>Checking this box will hide the Weaver version update announcements on the Weaver Admin page.</small> &diams;<br />

    <input type="checkbox" name="<?php weaverii_sapi_advanced_name('_wii_hide_donate'); ?>" id="wii_hide_donate" <?php checked(weaverii_getopt_checked( '_wii_hide_donate' )); ?> />
	<label>I've Donated - </label><small>Thank you for donating to the Weaver II theme. This will hide the donate button.</small> &diams;<br />

    <input type="checkbox" name="<?php weaverii_sapi_advanced_name('_wii_hide_theme_thumbs'); ?>" id="wii_hide_theme_thumbs" <?php checked(weaverii_getopt_checked( '_wii_hide_theme_thumbs' )); ?> />
	<label>Hide Theme Thumbnails - </label><small>Checking this box will hide the Sub-theme preview thumbnails on the Weaver Themes tab which might speed up response a bit.</small> &diams;<br />

    <input type="checkbox" name="<?php weaverii_sapi_advanced_name('_wii_hide_auto_css_rules'); ?>" id="wii_hide_auto_css_rules" <?php checked(weaverii_getopt_checked( '_wii_hide_auto_css_rules' )); ?> />
	<label>Don't auto-display CSS rules - </label><small>Checking this box will disable the auto-display of Main Option elements that have CSS settings.</small> &diams;<br />

    <input name="<?php weaverii_sapi_advanced_name('_wii_css_rows'); ?>" id="wii_css_rows" type="text" style="width:30px;height:20px;" class="regular-text" value="<?php echo(weaverii_esc_textarea(weaverii_getopt('_wii_css_rows'))); ?>" />
    <label>Set CSS+ text box height - </label><small>You can increase the default height of the CSS+ input area.</small> &diams;
<br />
<br /> <small><span style="color:red;"><b>NOTE:</b></span> Weaver II includes support for Rounded Corners and
Shadows for Internet Explorer 7/8 via an add-on script called PIE. The script has been <strong>enabled</strong> by default.
Note while PIE supports most rounded areas, it doesn't support the menu bars.
If you have difficulties or don't like the way your site renders in IE 7/8, you can disable the support.</small>
<br />
<input type="checkbox" name="<?php weaverii_sapi_advanced_name('_wii_hide_PIE'); ?>" id="wii_hide_PIE" <?php checked(weaverii_getopt_checked( '_wii_hide_PIE' )); ?> />
    <label>Disable IE rounded corners support - </label><small>If you are having issues with IE and rounded corners, please disable this option.</small> &diams;<br />
<?php
}
/* ^^^^^ end weaverii_admin_page_process_options ^^^^^^ */

// ===================================== include other stuff ==========================

require_once( dirname( __FILE__ ) . '/lib-admin.php' );
require_once( dirname( __FILE__ ) . '/pro/admin-process-pro.php' );
require_once( dirname( __FILE__ ) . '/pro/lib-admin-pro.php' );

require_once( dirname( __FILE__ ) . '/admin-subthemes.php' );
require_once( dirname( __FILE__ ) . '/admin-mainopts.php' );
require_once( dirname( __FILE__ ) . '/admin-advancedopts.php' );
require_once( dirname( __FILE__ ) . '/admin-pro.php' );
require_once( dirname( __FILE__ ) . '/admin-shortcodes.php' );
require_once( dirname( __FILE__ ) . '/admin-saverestore.php' );
require_once( dirname( __FILE__ ) . '/admin-help.php' );
?>
