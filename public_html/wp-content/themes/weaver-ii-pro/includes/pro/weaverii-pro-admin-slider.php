<?php
/*
Weaver II Pro Slider - Version 1.0

ADMIN

This code is Copyright 2011 by Bruce Wampler, all rights reserved.
This code is licensed under the terms of the accompanying license file: license.html.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.

*/

function weaveriip_slider_admin() {

    if (!weaverii_pro_isset('slider_number_sliders')) weaveriip_slider_init();
?>

    <div>
    <p class='wvr-option-section'>Slider Menu Shortcode - [weaver_slider] <?php weaveriip_help_link('pro-help.html#slider','Slider help'); ?></p>

    <p>This tab configures the Weaver II Pro Slider shortcode. These are the basic steps:
    <ol>
	<li>First, you <strong><em>MUST</em></strong> use the WP 3 Appearance->Menus admin option (Menu box
	in the upper right corner) to define
	a custom menu for each Slider you've defined. For each slider, you can define from 2 to 8 Menu items.
	Don't define sub-menus. Failure to follow these guidelines will result in a broken-looking slider.</li>
	<li>Set the options for each Slider. Create and specify images to be used. You can change the default sizes. The actual
	display width (or height for vertical menus) of each image on the menus is automatically adjusted.</li>
	<li><strong style="color:red;">Show your Slider!</strong> Add the <code>[weaver_slider id=1]</code> shortcode to your site
	for each Slider. For example, add <code>[weaver_slider]</code> to "Site Header Insert Code"
	from "Advanced Options&rarr;HTML Insertion" to display the first slider (id=1, the default) in your <strong>site header</strong>.
	Add <code>[weaver_slider id=2]</code>
	to a standard <em>Text Widget</em> to add a vertical slider to a <strong>sidebar</strong>.
	If you are placing a horizontal slider in the header, you likely will want to disable the standard header
	image. (Set "Header Image Height" to 0 in Main Options->Header Options)</li>
	<li>Once you have defined any Slider Menus, you must check "Enable Slider Menu". None will display until you do.
	</li>

    </ol>
    </p>
    <form name="weaveriip_options_form" method="post">
	<input class="button-primary" type="submit" name="weaverii_pro_save_pro" value="Save Slider Options"/>
	<br /><br />
        <fieldset class="options">
        <table class="optiontable">
	<tr>
	    <th scope="row" align="right" style="width:200px;">Enable Slider Menu:&nbsp;</th>
	    <td>
	    <input type="checkbox" name="slider_enable" id="slider_enable" <?php echo (weaverii_pro_getopt('slider_enable') ? "checked" : ""); ?> />
	    </td>
	    <td style="padding-left: 10px"><small>Enable Sliders. The <code>[weaver_slider]</code> shortcode will not be recognized until you Enable Sliders.</small></td>
	</tr>
	<tr>
	    <th scope="row" align="right">Number of Sliders:&nbsp;</th>
	    <td>
		<input name="slider_number_sliders" id="slider_number_sliders" type="text" style="width:30px;height:20px;" class="regular-text" value="<?php echo weaverii_esc_textarea(weaverii_pro_getopt('slider_number_sliders')) ; ?>" />
	    <td style="padding-left: 10px"><small>Number of Sliders. Need a unique slider defined for each <code>[weaver_slider]</code> shortcode used. Default is 1, max is 10.</small></td>
	    </td>
	</tr>
	</table>
<?php
	for ($i = 1 ; $i <= weaverii_pro_getopt('slider_number_sliders') ; $i++) {	// opts for each slider
	    weaveriip_slider_sform($i);
	}
?>
    <input type="hidden" name="weaveriip_save_slider" value="Weaver Slider Options Saved" />
<?php
    weaverii_nonce_field('weaverii_pro_save_pro');
?>
    </form>
   </div>
    <hr />
<?php
}

function weaveriip_slider_sform($i) {
    global $weaveriip_slider_opts;
    $sname = 'slider' . $i;

    if ($i & 1)
	echo("<div style=\"width:99%;background:#eee;padding:4px;border-right:2px solid #eee;\">\n");
    else
	echo("<div style=\"width:99%;padding:4px;border:1px solid #ddd;\">\n");

    $menus = get_terms( 'nav_menu', array( 'hide_empty' => false ) );		// get defined custom menus
    $menu_selected = weaverii_pro_isset( $sname.'_menu') ? weaverii_pro_getopt($sname.'_menu') : '';
    ?>
    <div><span style="color:blue;font-weight:bold;font-size:120%;">Slider <?php echo $i; ?></span>
	&nbsp;&nbsp;<em>Shortcode:</em> <strong><code>[weaver_slider id=<?php echo $i; ?>]</code></strong>
	| <em>Note (where used, for example):</em>
	<input name="<?php echo $sname; ?>_note" id="<?php echo $sname; ?>_note" type="text" style="width:250px;height:22px;" class="regular-text" value="<?php echo weaverii_esc_textarea(weaverii_pro_getopt($sname . '_note')); ?>" />
    </div>
    <br />
    <table class="optiontable">
	<tr>
	    <th scope="row" align="right" style="width:20%;">Select Menu:&nbsp;</th>
	    <td>
<?php
	    // If no irect the user to go and create some.
		if ( !$menus ) {
		    echo  sprintf('No menus have been created yet. Please use <a href="$s">Appearance&rarr;Menus</a> to create some.',admin_url('nav-menus.php'));
		} else {
?>
		    <select id="<?php echo $sname.'_menu'; ?>" name="<?php echo $sname.'_menu'; ?>">
<?php
		    foreach ( $menus as $menu ) {
			$selected = $menu_selected == $menu->term_id ? ' selected="selected"' : '';
			echo '<option'. $selected .' value="'. $menu->term_id .'">'. $menu->name .'</option>' . "\n";
		    }
		}
?>
		    </select>
	    </td>
	    <td style="padding-left: 10px"><small>Select a custom menu to for this slider. Sub-menus are not supported!.</small></td>

	</tr>
	<tr>
	    <th scope="row" align="right" style="width:20%;">Hide Menu Text:&nbsp;</th>
	    <td>
	    <input type="checkbox" name="<?php echo $sname; ?>_hidetext" id="<?php echo $sname; ?>_hidetext" <?php echo (weaverii_pro_getopt($sname . '_hidetext') ? "checked" : ""); ?> />
	    </td>
	    <td style="padding-left: 10px"><small>Hide standard Menu names over each image. Useful if your image
	    contains the Menu name.</small></td>
	</tr>
	<tr>
	    <th scope="row" align="right">Number of Images in Menu:&nbsp;</th>
	    <td>
		<input name="<?php echo $sname; ?>_number_images" id="<?php echo $sname; ?>_number_images" type="text" style="width:60px;height:22px;" class="regular-text" value="<?php echo weaverii_esc_textarea(weaverii_pro_getopt($sname . '_number_images')); ?>" />
	    <td style="padding-left: 10px"><small>Number of Images in Menu (must be between 2 and 8). Default is 7.</small></td>
	    </td>
	</tr>
	<tr>
	<th scope="row" align="right">Menu Width:&nbsp;</th>
	    <td>
		<input name="<?php echo $sname; ?>_menu_width" id="<?php echo $sname; ?>_menu_width" type="text" style="width:60px;height:22px;" class="regular-text" value="<?php echo weaverii_esc_textarea(weaverii_pro_getopt($sname . '_menu_width')); ?>" />
	    <td style="padding-left: 10px"><small>Overall width of Slider Menu (in px). <em>(Typically matches image width for vertical menus, theme width for horizontal menus.)</em></small></td>
	    </td>
	</tr>
	<tr>
	    <th scope="row" align="right">Width of each image:&nbsp;</th>
	    <td>
		<input name="<?php echo $sname; ?>_img_width" id="<?php echo $sname; ?>_img_width" type="text" style="width:60px;height:22px;" class="regular-text" value="<?php echo weaverii_esc_textarea(weaverii_pro_getopt($sname . '_img_width')); ?>" />
	    <td style="padding-left: 10px"><small>Enter the width of each image (in px). For horizontal sliders, this will affect the exact look of the slider effect.
	    The default 320 works well with 7 horizontal images. For vertical sliders, this will be the width of the slider. <em>Use 210 width for
	    slider in text widget with default sidebar. (130 is good matching height.)</em></small></td>
	    </td>
	</tr>
	<tr>
	    <th scope="row" align="right">Height of each image:&nbsp;</th>
	    <td>
		<input name="<?php echo $sname; ?>_img_height" id="<?php echo $sname; ?>_img_height" type="text" style="width:60px;height:22px;" class="regular-text" value="<?php echo weaverii_esc_textarea(weaverii_pro_getopt($sname . '_img_height')); ?>" />
	    <td style="padding-left: 10px"><small>Enter the height of each image (in px). This will determine the height of your slider menu. Default is 200. Limits are 25 and 1000.</small></td>
	    </td>
	</tr>
	<tr>
	    <th scope="row" align="right" style="width:20%;">Vertical Menu:&nbsp;</th>
	    <td>
	    <input type="checkbox" name="<?php echo $sname; ?>_vertical" id="<?php echo $sname; ?>_vertical" <?php echo (weaverii_pro_getopt($sname . '_vertical') ? "checked" : ""); ?> />
	    </td>
	    <td style="padding-left: 10px"><small>Check for vertical menu.</small> <strong>|</strong> Compressed height for each image:&nbsp;
	    <input name="<?php echo $sname; ?>_vert_compress" id="<?php echo $sname; ?>_vert_compress" type="text" style="width:40px;height:20px;" class="regular-text" value="<?php echo weaverii_esc_textarea(weaverii_pro_getopt($sname . '_vert_compress')); ?>" />
	    &nbsp;<small>This value, image height, and number of images interact to determine total height of vertical menu. Not used for horizontal menus.</small>
	    </td>
	</tr>
	<tr>
	    <th scope="row" align="right" style="width:20%;">Images Only, No Sliding:&nbsp;</th>
	    <td>
	    <input type="checkbox" name="<?php echo $sname; ?>_noeffects" id="<?php echo $sname; ?>_noeffects" <?php echo (weaverii_pro_getopt($sname . '_noeffects') ? "checked" : ""); ?> />
	    </td>
	    <td style="padding-left: 10px"><small>Check to disable sliding effects. You will get an image menu only. You will have to adjust image sizes to fit.</small>
	    </td>
	</tr>
	<tr>
	    <th scope="row" align="right">CSS for Menu Text:&nbsp;</th>
	    <td>&nbsp;</td>
	    <td>
		<span style="padding-left: 10px"><small>You can control the font characteristics of the Slider Menu Text
		by editing this CSS. (Clear to blank to restore defaults.)</small></span>
		<br />
		<textarea name="<?php echo $sname; ?>_text_font" rows=2 style="width: 95%"><?php echo(weaverii_esc_textarea(weaverii_pro_getopt($sname . '_text_font'))); ?></textarea>
		</td>
	    </td>
	</tr>
	<tr>
	    <th scope="row" align="right">Slider Menu CSS:&nbsp;</th>
	    <td>&nbsp;</td>
	    <td>
		<span style="padding-left: 10px"><small>Edit this CSS to change menu margins, etc. Use <code>border:0;</code> for no borders. Clear to blank to restore default.</small></span>
		<br />
		<textarea name="<?php echo $sname; ?>_borders" rows=1 style="width: 95%"><?php echo(weaverii_esc_textarea(weaverii_pro_getopt($sname . '_borders'))); ?></textarea>
		</td>
	    </td>
	</tr>
	</table>
	<h3>Slider Image Locations</h3>
	<p>
	Specify URLs for images for the menu. Each image should be
	<?php echo weaveriip_default_int(weaverii_pro_getopt($sname.'_img_height'),25,1024,200); ?>px high and
	<?php echo weaveriip_default_int(weaverii_pro_getopt($sname.'_img_width'),25,1024,320); ?>px wide. The most reliable place to
	keep your Slider images is in your Media Library. Click the small image icon to open the Medial Library selection dialog. Click "Insert into Post" to add URL. You can also enter any URL directly into the URL box below. If you have < 8 images, just leave the excess image links blank.</p>

	<table class="optiontable" style="padding-left:3%; padding-right:3%;">
	<tr>
	    <td>
		1. Enter URL: <input type="text" name="<?php echo $sname; ?>_img1" id="<?php echo $sname; ?>_img1" size="55" value="<?php echo(weaverii_esc_textarea(weaverii_pro_getopt($sname . '_img1'))); ?>" /><?php weaverii_media_lib_button($sname . '_img1'); ?>&nbsp;
	    </td>
	    <td>
		2. Enter URL: <input type="text" name="<?php echo $sname; ?>_img2" id="<?php echo $sname; ?>_img2" size="55" value="<?php echo(weaverii_esc_textarea(weaverii_pro_getopt($sname . '_img2'))); ?>" /><?php weaverii_media_lib_button($sname . '_img2'); ?>
	    </td>
	</tr>
	<tr>
	    <td>
		3. Enter URL: <input type="text" name="<?php echo $sname; ?>_img3" id="<?php echo $sname; ?>_img3" size="55" value="<?php echo(weaverii_esc_textarea(weaverii_pro_getopt($sname . '_img3'))); ?>" /><?php weaverii_media_lib_button($sname . '_img3'); ?>&nbsp;
	    </td>
	    <td>
		4. Enter URL: <input type="text" name="<?php echo $sname; ?>_img4" id="<?php echo $sname; ?>_img4" size="55" value="<?php echo(weaverii_esc_textarea(weaverii_pro_getopt($sname . '_img4'))); ?>" /><?php weaverii_media_lib_button($sname . '_img4'); ?>
	    </td>
	</tr>
	<tr>
	    <td>
		5. Enter URL: <input type="text" name="<?php echo $sname; ?>_img5" id="<?php echo $sname; ?>_img5" size="55" value="<?php echo(weaverii_esc_textarea(weaverii_pro_getopt($sname . '_img5'))); ?>" /><?php weaverii_media_lib_button($sname . '_img5'); ?>&nbsp;
	    </td>
	    <td>
		6. Enter URL: <input type="text" name="<?php echo $sname; ?>_img6" id="<?php echo $sname; ?>_img6" size="55" value="<?php echo(weaverii_esc_textarea(weaverii_pro_getopt($sname . '_img6'))); ?>" /><?php weaverii_media_lib_button($sname . '_img6'); ?>
	    </td>
	</tr>
	<tr>
	    <td>
		7. Enter URL: <input type="text" name="<?php echo $sname; ?>_img7" id="<?php echo $sname; ?>_img7" size="55" value="<?php echo(weaverii_esc_textarea(weaverii_pro_getopt($sname . '_img7'))); ?>" /><?php weaverii_media_lib_button($sname . '_img7'); ?>&nbsp;
	    </td>
	    <td>
		8. Enter URL: <input type="text" name="<?php echo $sname; ?>_img8" id="<?php echo $sname; ?>_img8" size="55" value="<?php echo(weaverii_esc_textarea(weaverii_pro_getopt($sname . '_img8'))); ?>" /><?php weaverii_media_lib_button($sname . '_img8'); ?>
	    </td>
	</tr>

	</table>
	<input class="button-primary" type="submit" name="weaverii_pro_save_pro" value="Save Slider Options"/>
</div>
<?php
}
?>
