<?php
/*
Weaver II Pro Shortcodes - Version 1.0
   BUTTONS
   ADMIN

This code is Copyright 2011 by Bruce Wampler, all rights reserved.
This code is licensed under the terms of the accompanying license file: license.html.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.

*/
function weaveriip_buttons_admin() {

    if (!weaverii_pro_isset('buttons')) {
        weaveriip_init_buttons();      // just in case!

    }
    $buttons = weaverii_pro_getopt('buttons');
    $maxbuttons = $buttons['maxbuttons'];

?>
<div>
<p class='wvr-option-section'>Link Buttons - [weaver_buttons] + Widget <?php weaveriip_help_link('pro-help.html#link_buttons','Link Buttons help'); ?></p>

<p><code>[weaver_buttons start='first-to-show' end='last-to-show' list='1,3,2']</code></p>

<p>The <code>[weaver_buttons]</code> short code allows you to add images buttons with links.
You can specify which image to begin with (1 to <?php echo $maxbuttons;?>) with the 'start' parameter, and the same with the 'end'.
The defaults are start=1 and end=<?php echo $maxbuttons;?>, but images with no image URL defined won't be displayed.
You can specify different sets of images with different instances of the shortcode. You can style with <em>.weaver-buttons</em>.</p>

<p>If you specify a comma separated list with the 'list' parameter (e.g, <code>list='7,4,1,2'</code>), you can specify an
arbitrary set and order of buttons. If you do specify a 'list' parameter, then 'begin' and 'end' will be ignored.</p>

<p>For each button you want to define, add a full URL to an image sized to the size you want your button to be.
It is best to keep the button image in your Media Library. Then add a hover message, and the complete URL to where the
button should link to (optional). Check the New Page box if you want the link to open a new tab or page when clicked.
</p>
<p>If you want to place your links over your header image, add the short code to the "Text" option of
a <em>Header Gadget</em>. You won't need to add an image or link url there since that information is provided here.
</p>

<p>The defined buttons will be displayed in a horizontal list that will wrap when the width of the enclosing HTML block is reached.</p>

<p>If you want to use the shortcode to include buttons Buttons on your menu bar, add the following code to the
<em>Main Options&rarr;Menus&rarr;Add HTML</em> settings:<br />
<code>&lt;div style="width:60px;padding-top:5px; padding-right:10px;">[weaver_buttons start=1 end=2]&lt;/div></code>. <br />
Note this example will display two buttons. Note that 24px height is optimal for the menu bar. The wrapping <code>div</code> is required
to get the buttons centered properly, and you will have to adjust the <code>width:</code> value depending on
how many buttons you want on your menu bar.</p>

<p><strong>Weaver II Pro Link Buttons Widget</strong> - When used in the <em>Weaver II Pro Link Buttons</em> widget, all buttons you've defined will be displayed
using their actual size in the order defined. There are no other options for the widget version.
</p>
<br />
<form name="weaveriip_linkbuttonoptions_form" method="post">
	<input class="button-primary" type="submit" name="weaverii_pro_save_pro" value="Save Link Buttons"/>

        <fieldset class="options">
<p>
    <strong>Number of images:&nbsp;</strong>
    <input type="text" name="maxbuttons" id="maxbuttons"  style="width:40px;height:20px;" class="regular-text" value="<?php echo esc_textarea($buttons['maxbuttons']); ?>" />
    &nbsp;&nbsp;<small>Enter number of buttons you need to define.</small>
</p>

<?php
    weaveriip_buttons_show_list();
?>
	<br />
        </fieldset>
	<input class="button-primary" type="submit" name="weaverii_pro_save_pro" value="Save Link Buttons"/>
        <input type="hidden" name="weaveriip_save_buttons" value="Weaver Link Buttons Options Saved" />

	<?php weaverii_nonce_field('weaverii_pro_save_pro'); ?>
	</form>
</div>
<?php
}

function weaveriip_buttons_show_list() {
    global $weaveriip_buttons_services;

    if (!weaverii_pro_isset('buttons')) {
        weaveriip_init_buttons();      // just in case!
    }
    $buttons = weaverii_pro_getopt('buttons');

    $baseurl = get_template_directory_uri();  /* from codex example */
?>
    <div>
        <table class='even-odd'>
            <tr>
                <td style="font-weight:bold;padding:5px;"></td>
                <td style="font-weight:bold;padding:5px;"><small>Image</small></td>
                <td style="font-weight:bold;padding:5px;"><small>Button Image - Full URL <span style="font-weight:normal">(required)</span></small></td>
                <td style="font-weight:bold;padding:5px;"><small>Hover Text Description</small></td>
                <td style="font-weight:bold;padding:5px;"><small>Link - Full URL</</td>
                <td style="font-weight:bold;padding:5px;"><small>New<br />Page</small></td>
            </tr>
<?php

    for ( $i = 0 ; $i < $buttons['maxbuttons'] ; $i++) {
        if ($i & 1)
            echo("<tr>\n");
        else
            echo("<tr style=\"background:#eee;\">\n");
        $id = 'b' . $i;
?>
    <td>&nbsp;<?php echo $i+1;?>&nbsp;</td>
<?php
    if ( $buttons[$id.'_img_url'] == '') {      // special case - no link
         echo '    <td style="padding:5px;"><img src="' . trailingslashit($baseurl) . 'includes/pro/images/default-button.png"/></td>' . "\n";
    } else {
         echo '    <td style="padding:5px;"><img src="' . $buttons[$id . '_img_url'] . '" /></td>' . "\n";
    }
?>
    <td>
        <input type="text" name="<?php echo $id ?>_img_url" id="<?php echo $id ?>_img_url"  style="width:240px;height:20px;" class="regular-text" value="<?php echo esc_textarea($buttons[$id . '_img_url']); ?>" /><?php weaverii_media_lib_button($id . '_img_url'); ?>
    </td>
    <td style="width:200px;padding-left:10px; padding-right:10px;">
        <input type="text" name="<?php echo $id ?>_hover" id="<?php echo $id ?>_hover"  style="width:200px;height:20px;" class="regular-text" value="<?php echo esc_textarea($buttons[$id . '_hover']); ?>" />
    </td>

    <td style="padding:5px;">
        <input type="text" name="<?php echo $id ?>_link_url" id="<?php echo $id ?>_link_url"  style="width:240px;height:20px;" class="regular-text" value="<?php echo esc_textarea($buttons[$id . '_link_url']); ?>" />
    </td>
    <td style="padding:5px;">
        <input type="checkbox" name="<?php echo $id ?>_blank" id="<?php echo $id ?>_blank" <?php echo ($buttons[$id . '_blank'] ? "checked" : ""); ?> />
    </td>
<?php
    } // end for
?>
        </table>
    </div>

<?php
}
?>
