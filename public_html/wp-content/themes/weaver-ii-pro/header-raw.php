<?php
/**
 * The Header for our theme.
 *
 * Displays all of the <head> section and everything up till < div id="main" >
 *
 * @package WordPress
 * @subpackage Weaver II
 * @since Weaver II 1.0
 */
weaverii_setup_mobile();
?><!DOCTYPE html>
<!--[if IE 6]>
<html id="ie6" <?php language_attributes(); ?>>
<![endif]-->
<!--[if IE 7]>
<html id="ie7" <?php language_attributes(); ?>>
<![endif]-->
<!--[if IE 8]>
<html id="ie8" <?php language_attributes(); ?>>
<![endif]-->
<!--[if IE 9]>
<html id="ie9" <?php language_attributes(); ?>>
<![endif]-->
<!--[if !(IE 6) | !(IE 7) | !(IE 8) ] | !(IE 9) ><!-->
<html <?php language_attributes(); ?>>
<!--<![endif]-->
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>" />
<meta name='viewport' content='width=device-width, initial-scale=1.0, maximum-scale=2.0, user-scalable=yes' />
<title><?php		// ++++++ HEAD TITLE ++++++

	wp_title('');		// this is compatible with SEO plugins

?></title>

<link rel="profile" href="http://gmpg.org/xfn/11" />
<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>" />
<!--[if lt IE 9]>
<script src="<?php echo get_template_directory_uri(); ?>/js/html5.js" type="text/javascript"></script>
<![endif]-->

<?php			// ++++ CSS AND CUSTOM SCRIPTS ++++
    $icon = weaverii_getopt('_wii_favicon_url');
    if ($icon != '') {
	$url = parse_url($icon,PHP_URL_PATH);
	echo "<link rel=\"shortcut icon\"  href=\"$url\" />\n";
    }
    $icon = weaverii_getopt('_wii_apple_touch_icon_url');
    if ($icon != '') {
	$url = parse_url($icon,PHP_URL_PATH);
	echo "<link rel=\"apple-touch-icon\"  href=\"$url\" />\n";
    }
    weaverii_facebook_meta();
    if (!weaverii_getopt('_wii_hide_metainfo'))
	echo(weaverii_getopt('_wii_metainfo')."\n");
?>
<style type="text/css">
html, body, div, span, iframe, wrap
{
	background: transparent;
	border: 0;
	margin: 0;
	outline: 0;
	padding: 0;
	vertical-align: baseline;
}
</style>

<?php
    $per_page_code = weaverii_get_per_page_value('page-head-code');
    if (!empty($per_page_code)) {
	echo($per_page_code);
    }
?>
</head>

<body>
<?php weaverii_trace_template(__FILE__);
echo "<div id=\"wrap\" class=\"hfeed raw\">\n";

?>
