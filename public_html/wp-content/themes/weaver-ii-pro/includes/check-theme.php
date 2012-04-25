<?php
/*
 Check issues

 1. Header Widget - if any widgets are defined for the area, then check to be sure widths are set.
 2. Look for SEO plugins
 3. See if they've saved their options ever.
 4. Custom bullet defined, but not selected, or selected and not defined
 5. No defined widget areas
 6. See if they have defined SEO meta, FavIcon
 7. Warn about fixed width theme

*/
function weaverii_perform_check() {
?>
<div style="background:#FFFF88;border:3px solid green;font-size:larger;padding:0 10px 0 10px; width:80%;margin-top:15px;margin-bottom:10px;">
    <p style="font-weight:normal;"><strong>Checking Weaver II for possible problems.</strong> This will check for some potential problems, but it is
    not a comprehensive check. Most messages are informational warnings, but things that should be fixed are marked ERROR.</p>
    <ul style="list-style-type:disc;list-style-position:inside;">
<?php

    echo '<li>' . weaverii_check_version(true) . "</li>\n";	// version
    global $wp_version;

    // see about file system

    if (function_exists('get_filesystem_method')) {	// this is available to check
	$type = get_filesystem_method(array());		// lets see if we have direct or ftpx
	if ($type == 'ftpext') {		// supposed to be using ftp access
?>
    <li>Please note: your site server is configured so that WordPress requires "FTP File Access" to update themes,
    plugins, and other files. If your site host is a private server, VPS, or other system where your site is secure from other
    users, <em>this is not an issue</em>. If, on the other hand, your site is using shared hosting, then it might
    be vulnerable to attack from other users who share your server. We <strong>strongly</strong> advise that you contact
    your hosting company and see if your site can be configured more securely, and if not, change hosting companies.
    Most modern shared hosting companies can provide "suPHP", "fastCGI", or other tools that allow shared
    serving without compromising file security.
<?php
	    if (weaverii_init_base()) {
?>
    <br /><br />
    For Weaver II Pro, the "FTP File Access" requirement may cause issues with creating css and saved-settings files.
    You may want to add FTP credentials to your wp-config.php file.
<?php
	    }
?>
    </li>
<?php
	}
    }

    // plugins

    weaverii_check_cache_plugins('<li>','</li>');		// Cache check

    $seo = '';

    if (function_exists('aioseop_get_version'))
	$seo = 'All in One SEO Pack';
    if (function_exists('wpseo_get_value'))
	$seo = 'WordPress SEO by Yoast';
    if (function_exists('su_wp_incompat_notice'))
	$seo = 'SEO Ultimate';
    if (class_exists('gregsHighPerformanceSEO'))
	$seo = 'Greg\'s High Performance SEO';
    if (class_exists('EcordiaContentOptimizer'))
	$seo = 'Scribe SEO';

    if ($seo && !weaverii_getopt_checked('_wii_hide_metainfo')) {
	echo '<li>ERROR: You are using the SEO plugin <em>' . $seo .
	'</em>. You also need to checkmark the <em>Use SEO plugin instead</em> option on the Advanced Options:SEO Weaver II admin tab.';
    }

    if (!$seo && weaverii_getopt_checked('_wii_hide_metainfo')) {
	echo '<li>You have checkmarked the <em>Use SEO plugin instead</em> option on the Advanced Options:SEO tab, however none of the more popular SEO plugins were detected. You might want to consider using "WordPress SEO by Yoast" or "All in One SEO Pack", for example.</li>';
    }

    // widgets

    if (is_active_sidebar('header-widget-area')) {		// have an active horizontal header area
	if (weaverii_getopt('_wii_hdr_widg_1_w_int') == '') {	// just check the first one
?>
    <li>ERROR: You have added widgets for the <em>Header Horizontal Widget Area</em>, but have not
    properly defined widths for the widgets in that area. (Main Options:Header:Header Widget Area Widgets:Widths) </li>
<?php
	}
    }

    if (!is_active_sidebar('primary-widget-area') && !is_active_sidebar('right-widget-area') && !is_active_sidebar('left-widget-area')) {
	echo '<li>You have not added any <em>widgets</em> to the standard sidebar widget areas. (Dashboard:Widgets)</li>';
    }

    // misc

    $saved = get_option('weaverii_settings_backup');
    if (empty($saved)) {
	echo '<li>You have not saved your settings using the <em>Save/Restore</em> tab. It is good practice to keep a saved version of your settings.</li>';
    }

    $meta = weaverii_getopt('_wii_metainfo');
    if (!$meta) {
	echo '<li>You do not have any SEO meta information set. You may want to add SEO info. (Advanced Options:SEO)</li>';
    } else {
	$myName = esc_attr( get_bloginfo( 'name', 'display' ) );
	$myDescrip = esc_attr( get_bloginfo( 'description', 'display' ) );
	if (strcasecmp($myDescrip,'Just another WordPress site') == 0) $myDescrip = '';
	$SEOText = "<meta name=\"description\" content=\" $myName - $myDescrip \" />
<meta name=\"keywords\" content=\"$myName blog, $myName\" />";
	$meta = str_replace("\r",'',$meta);	// saving to db changes \n to \r\n apparently
	$meta = str_replace("\n",'',$meta);
	$SEOText = str_replace("\r",'',$SEOText);
	$SEOText = str_replace("\n",'',$SEOText);
	if ($meta == $SEOText) {
	    echo '<li>Your site <em>SEO Tags</em> are set to the default values. You may want to add additional description or keywords. (Advanced Options:SEO)</li>';

	}
    }

    $icon = weaverii_getopt('_wii_favicon_url');
    if (!$icon) {
	echo '<li>You have not specified a <em>FavIcon</em>. It is a good idea to have a FavIcon for your site. (Advanced Options:Site Options)</li>';
    }

    // pro options

    if (weaverii_getopt_checked('_wii_inline_style')) {
	echo '<li>You have <em>Use Inline CSS</em> checked. (Weaver II Pro tab)</li>';
    }
    if (weaverii_getopt_checked('_wii_development_mode')) {
	echo '<li>You have <em>Development Mode</em> checked. It is recommended to disable it for production sites. (Weaver II Pro tab)</li>';
    }

    // MOBILE

    if (weaverii_getopt_checked('_wii_mobile_alt_theme')) {
	$temp = get_option('weaverii_settings_mobile');
	if ($temp === false) {
	    echo '<li>ERROR: You have checked <em>Use Alternate Mobile Theme</em>, but no Mobile Theme Settings have been saved. (Advanced Options:Mobile tab) You <em>must</em> use the "Save Settings to Mobile Settings" from the Save/Restore tab first!</li>';
	}
    }
    if (weaverii_getopt_checked('_wii_sim_mobile') && weaverii_getopt_checked('_wii_sim_mobile_always')) {
	echo '<li>You have <em>Simulate Mobile Device</em> enabled for all visitors to your site. That is recommended only for demo sites. (Advanced Options:Mobile tab)</li>';
    }
    if (!is_active_sidebar('mobile-widget-area')) {
	echo '<li>You don\'t have any widgets defined for the <em>Mobile Device Widget Area</em> (Dashboard:Widgets)</li>';
    }
    if (weaverii_getopt_checked('_wii_mobile_disable')) {
	echo '<li>You have <em>Disable Mobile Support</em> checked. That is not recommended unless you have an alternate mobile theme plugin. (Advanced Options:Mobile tab)</li>';
    }

?>
    <li>You can use the <em>Mobile Device Simulator</em> to check how your site will look on mobile devices. (Advanced Options:Mobile)</li>
    </ul>
    <p style="font-weight:normal;">Theme check complete.</p>

</div>
<?php
}

?>
