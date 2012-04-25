<?php
/*
Weaver II Pro Shortcodes - Version 1.0
Widget Area
ADMIN+CODE

This code is Copyright 2011 by Bruce Wampler, all rights reserved.
This code is licensed under the terms of the accompanying license file: license.html.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
*/
function weaveriip_has_widget_area() {return true;}
function weaveriip_widget_area_admin() {
?>
<p class='wvr-option-section'>Widget Area - [weaver_widget_area] <?php weaveriip_help_link('pro-help.html#widget_areas','Widget Area help'); ?></p>

<p><code>[weaver_widget_area id='area-name' class='alt-class-name' style='inline-style-rules']</code></p>

<p>The <code>[weaver_widget_area]</code> short code allows you display a new widget area anywhere on a post or page.
This short code will use one of the new widget areas defined on the
<strong><em>Advanced Options&rarr;Page Templates Options&rarr;Per Page Widget Areas</em></strong>
tab of the Weaver Admin Page. Simply add a new widget area name, just as you would for a per page widget area. Fill the
widget area with widgets. Then use the name of the widget area in this short code..</p>

<p><strong>Shortcode usage:</strong> <code>[weaver_widget_area id='name' class='alt-class' style='inline-style']</code>
<br />
<ol>
    <li><strong>id='area-name'</strong> - The id of the new widget area defined in Advanced Options.
    </li>
    <li><strong>class='alt-class-name'</strong> - By default, the extra widget area will be styled just like other page widget areas
    (top, bottom, per-page). You can add additional styling using <em>.per-page-thename</em>, or by providing your
    own style class name as a parameter to the shortcode. If you use 'primary' as the class, the widget will be displayed
    using the same styling as the primary widget area, which is useful for use in Advanced Options:HTML Insertion: Pre-Sidebar Code.
    </li>
    <li><strong>style='inline-style-rules'</strong> - Allows you to add some inline style to wrap the widget area. Don't include the 'style='
    or wrapping quotation marks. Do include a ';' at the end of each rule. The output will look like
    <code>style="your-rules;"</code> - using double quotation marks.
    By default, the widget area will include an inline style to auto-center the widget area (margin-left:auto;margin-right:auto;)
    which you may need to include in your own style override if you want the widget area centered.
    </li>
    </ol>
</p>

<?php
}

/* -------------- weaveriip_widget_area --------------- */
function weaveriip_widget_area_shortcode($args = '') {
    /* implement [weaver_widget_area id='name'] shortcode */

    extract(shortcode_atts(array(
	'id' => '#',
        'class' => '',
	'style' => '"margin-left:auto;margin-right:auto;"'
    ), $args));

    $area = 'per-page-' . $id;  // retrieve meta value
    $bad = '<h3>[weaver_widget_area] - Area ' . $id . ' not defined.</h3>';
    $id_tag = 'per-page-widget';
    if ($class == 'primary') {
        $id_tag = $class;
        $class = '';
    }

    $content = '<div id="' . $id_tag . '" class="widget-area sidebar_extra ' . $area . ' '. $class . '" style='. weaveriip_bracket($style,'"','"') .'><ul class="xoxo">' ."\n";

    if (strlen($id) > 0) {		// want to display some areas
	if ( !is_active_sidebar($area)) return $bad;
	ob_start(); /* let's use output buffering to allow use of Dynamic Widgets plugin and not have empty sidebar */
	$success = dynamic_sidebar($area);
        $content .= ob_get_clean();
	if ($success) {
            $content .= "\n</ul></div>\n";
        } else {
            $content = $bad;
	}
    }

    return $content;
}

add_shortcode('weaver_widget_area', 'weaveriip_widget_area_shortcode');

?>
