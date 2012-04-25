<?php
/* MULTI-SITE Control
  All non-checkbox options for this theme are filtered based on the 'unfiltered_html' capability,
  so non-admins and non-editors can only add safe html to the various options. It should be
  farily safe to leave all theme options available on your Multi-site installation. If you want
  to eliminate most of the options that let users enter HTML, then set this option to false.
*/
define('WEAVERII_MULTISITE_ALLOPTIONS', true);  // Set to true to allow all options for users on multisite

define ('WEAVERII_FORCE_RTL', false);	// Shouldn't need this, but will force use of RTL layout rules

/* Version Information */

define ('WEAVERII_VERSION','1.0.26');
define ('WEAVERII_VERSION_ID',100);
define ('WEAVERII_THEMENAME', 'Weaver II Pro');
define ('WEAVERII_THEMEVERSION',WEAVERII_THEMENAME . ' ' . WEAVERII_VERSION);
define ('WEAVERII_MIN_WPVERSION','3.2');

/* utility definitions - should not be edited */
define ('WEAVERII_DEFAULT_COLOR','default-style-color');
define ('WEAVERII_SLUG', 'weaver-ii');
define ('WEAVERII_PRO_SLUG','weaver-ii-pro');
define ('WEAVER_SLUG','weaver');
?>
