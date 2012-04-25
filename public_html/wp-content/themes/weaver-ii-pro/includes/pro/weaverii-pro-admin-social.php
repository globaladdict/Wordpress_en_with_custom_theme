<?php
/*
Weaver II Pro Social Buttons - Version 1.0
   SOCIAL
   ADMIN

This code is Copyright 2011 by Bruce Wampler, all rights reserved.
This code is licensed under the terms of the accompanying license file: license.html.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.

*/
function weaveriip_social_admin() {
?>
<p class='wvr-option-section'>Social Buttons - [weaver_social] Shortcode and Widget <?php weaveriip_help_link('pro-help.html#social_buttons','Social Buttons help'); ?></p>

<p><code>[weaver_social height='height' number='showcount']</code></p>

<p>The <code>[weaver_social]</code> short code allows you to add Social site buttons with links to your account or page.</p>

<p>To display social buttons,
check the buttons you want to show. Provide the full URL to your account link. For example: <code>http://twitter.com/wpweaver</code>.
You can specify the display order in the <em>Display Order</em> column using the WordPress ordering method used
to order your static pages: 10,15,30, etc. Lower numbers display first - they don't have to be sequential.
</p>
<p>If you want to use the shortcode to include Social Buttons on your menu bar, either set how many to show in the option
below. For more control or to place the buttons on the left side of the menu bar, add the following code to the
<em>Main Options&rarr;Menus&rarr;Add HTML</em> settings:<br />
<code>&lt;div style="width:56px; padding-right:14px;display:inline-block;">[weaver_social number=2]&lt;/div></code>. <br />
Note this example will display two buttons, 24px high (the default). The wrapping <code>div</code> is required
to get the buttons centered properly, and you will have to adjust the <code>width:</code> value depending on
how many buttons you want on your menu bar (number * 28).</p>
<p>You can place social buttons over your header area using a Header Gadget. Place the <code>[weaver_social]</code>
shortcode in the "Text" field of a Header Gadget. You don't need to fill in a link or image field since they
are provided by this shortcode.
</p>
<p>When used in the <em>Weaver II Pro Social Buttons</em> widget, all buttons you've selected will be displayed
using 32px high images. There are no other options for the widget version.
</p>
<p style="font-size:small;font-style:italic;"><strong>A note about the URL:</strong> The exact form of the URL you add
for each button will depend on the service in question. Almost all of these services allow you to set up an account,
and then provide a URL address for other people to view your account's public page.</p>
<p>
<small>Note: you can click a service's icon on the list to open the site's main home page if you want
to learn more about a particular service.</small>
</p>
<form name="weaveriip_linkbuttonoptions_form" method="post">
	<input class="button-primary" type="submit" name="weaverii_pro_save_pro" value="Save Social Buttons"/>
<br />
        <fieldset class="options">
        <strong style="color:blue;">Social Button Options</strong><br /><br />
	    <table class="optiontable">

<?php
    weaveriip_value_row('Add Social Buttons to Menu Bar','wvp_add_social_to_menu','Add up to number specified (34 max) Social Buttons to the right side of the Primary Menu Bar.');
?>
            </table>
            <br />
<?php
    weaveriip_social_show_list();
?>
	<br />
        </fieldset>
	<input class="button-primary" type="submit" name="weaverii_pro_save_pro" value="Save Social Buttons"/>
        <input type="hidden" name="weaveriip_save_social" value="Weaver Social Buttons Saved" />
	<?php weaverii_nonce_field('weaverii_pro_save_pro'); ?>
	</form>
<?php
}

function weaveriip_social_show_list() {
    global $weaveriip_social_services;

    if (!weaverii_pro_isset('social')) {
        weaveriip_init_social();      // make sane
    }
    $soc = weaverii_pro_getopt('social');    // fetch the sub list

    $baseurl = trailingslashit(get_template_directory_uri());  /* from codex example */
?>
    <div>
        <table class='even-odd'>
            <tr>
                <td><strong><small>Use</small></strong></td>
                <td style="text-align:center;font-weight:bold;"><small>Display<br />Order</small></td>
                <td></td>
                <td style="font-weight:bold;"><small>Social Site Description</small></td>
                <td style="font-weight:bold;"><small>Full URL link to your account</</td>
		<td style="font-weight:bold;"><small>Stay<br />on page</</td>
            </tr>
<?php
    $i = 1;
    foreach ( $weaveriip_social_services as $service) {
        if ($i++ & 1) $rowbg = '#eee';
	else $rowbg = 'transparent';
        echo("<tr style=\"background:$rowbg;\">\n");


        $id = $service['icon'];
        if (!isset($soc[$id . '_use'])) $soc[$id . '_use'] = '';
        if (!isset($soc[$id . '_url'])) $soc[$id . '_url'] = '';
        if (!isset($soc[$id . '_order']))  $soc[$id . '_order'] = '';
        if (!isset($soc[$id . '_hover'])) $soc[$id . '_hover'] = '';
	if (!isset($soc[$id . '_stay'])) $soc[$id . '_stay'] = '';
	if (!isset($soc[$id . '_custom'])) $soc[$id . '_custom'] = '';
?>
    <td style="padding:5px;">
        <input type="checkbox" name="<?php echo $id ?>_use" id="<?php echo $id ?>_use" <?php echo ($soc[$id . '_use'] ? "checked" : ""); ?> />
    </td>
    <td style="padding:5px;">
        <input type="text" name="<?php echo $id ?>_order" id="<?php echo $id ?>_order"  style="width:50px;height:20px;" class="regular-text" value="<?php echo weaverii_esc_textarea($soc[$id . '_order']); ?>" />
    </td>
<?php
	if ($service['icon'][0] == '_') {
	    if ($soc[$id . '_custom'] == '')
		$img = '<img src="' . $baseurl . 'includes/pro/social/1/button-white.png" height="28" width="28" />';
	    else
		$img = '<img src="' . $soc[$id . '_custom'] . '" height="28" width="28" />';
	} else {
	    $img = '<img src="' . $baseurl . 'includes/pro/social/1/' . $service['icon'] . '.png" height="28" width="28" />';
	}
        if ( $service['site'][0] == '#') {      // special case - no link
            echo '<td style="padding:5px;">' . $img . '</td>' . "\n";
            echo '<td style="width:340px;padding-left:10px; padding-right:10px;">';
?>
<input type="text" name="<?php echo $id ?>_hover" id="<?php echo $id ?>_hover"  style="width:340px;height:20px;" class="regular-text" value="<?php echo weaverii_esc_textarea($soc[$id . '_hover']); ?>" /></td>
<?php
        } else {
            echo '<td style="padding:5px;"><a href="http://' . $service['site'] . '" target="_blank">' . $img . '</td>' . "\n";
?>
            <td style="width:340px;padding-left:10px; padding-right:10px;"><input type="text" name="<?php echo $id ?>_hover" id="<?php echo $id ?>_hover"  style="width:340px;height:20px;" class="regular-text" value="<?php echo weaverii_esc_textarea($soc[$id . '_hover']); ?>" /></td>
<?php
            // echo '<td style="width:340px;padding-left:10px; padding-right:10px;">' . $service['blurb'] . "</td>\n";
        }
?>
    <td style="padding:5px;">
<?php
        if ( $service['site'][0] == '#') {      // special case - no link
           echo ( substr($service['site'],1) . '<br />');
        }
?>
        <input type="text" name="<?php echo $id ?>_url" id="<?php echo $id ?>_url"  style="width:280px;height:20px;" class="regular-text" value="<?php echo weaverii_esc_textarea($soc[$id . '_url']); ?>" />
    </td>
    <td style="padding:5px;">
        <input type="checkbox" name="<?php echo $id ?>_stay" id="<?php echo $id ?>_stay" <?php echo ($soc[$id . '_stay'] ? "checked" : ""); ?> />
    </td>

<?php
	if ($service['icon'][0] == '_') {
	    echo("<tr style=\"background:$rowbg;\">\n");
?>
<td colspan>&nbsp;</td><td colspan="2"><small>Custom Icon URL:</td><td style="width:340px;padding-left:10px; padding-right:10px;">
<input type="text" name="<?php echo $id ?>_custom" id="<?php echo $id ?>_custom"  style="width:300px;height:20px;padding-bottom:10px;" class="regular-text" value="<?php echo weaverii_esc_textarea($soc[$id . '_custom']); ?>" /><?php weaverii_media_lib_button($id . '_custom'); ?>
</td><td>&nbsp;&nbsp;<small>Suggested size: 32x32 px</td></tr>
<?php
	}
	echo ("</tr>\n");
    } // end foreach
?>
        </table>
    </div>

<?php
}
?>
