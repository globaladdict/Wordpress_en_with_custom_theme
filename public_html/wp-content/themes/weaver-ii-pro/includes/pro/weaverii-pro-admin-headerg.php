<?php
/*
Weaver Plus Header Gadgets

This code is Copyright 2011 by Bruce Wampler, all rights reserved.
This code is licensed under the terms of the accompanying license file: license.html.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
*/

function weaveriip_headergadget_admin() {

    if (!weaverii_pro_isset('hdr_num_opts')) weaveriip_header_init();

    $num_imgs = weaverii_pro_getopt('hdr_num_opts');
    ?>

    <div>
    <p class='wvr-option-section'>Header Gadgets - <small>Links, Images & Text over the Header + [weaver_gadget] shortcode</small> <?php weaveriip_help_link('pro-help.html#header_gadgets','Header Gadgets help'); ?></p>


    <p>This tab allows you to add 'gadgets' (mini-widgets) anywhere over the site header. You can use images
    or text, and add links. You can place these anywhere over the header area of your site.</p>

    <h4>[weaver_gadget] shortcode</h4>
    <p>The gadgets defined here can also be used with a shortcode:
    <code>[weaver_gadget gadget=4]</code>
    where the 'gadget' parameter specifies the id number of which gadget to use. The shortcode version allows
    arbitrary placement of gadgets on the content area. You can split the usage of gadgets (some for the header,
    some for the shortcode) by specifying the "Max items" option at the bottom.
    </p>

    <form name="weaveriip_options_form" method="post">
	<input class="button-primary" type="submit" name="weaverii_pro_save_pro" value="Save Plus Header Gadget Options"/>
	<br />
        <fieldset class="options">
	    <br /><strong style="color:blue;">Add Gadgets (Images or Text) over Header Area</strong>
	    <p>You can add an arbitrary number of gadgets (images or text strings) over your header. You can specify how far down
	    from the top (y) and the left (x) each one is displayed (negative values OK).  Gadgets will be displayed
	    <em>behind</em> menu bars. You can also add
	    a link to the gadget. Images will work best
	    if you use an image from your Media Library (click the little image button to open Media Library). </p>
	    <p><em>Please note! Gadgets can cause unexpected results with the mobile view.</em> Gadgets placed
	    beyond 320px to the right will cause an incorrect view on Mobile devices. You can check where they display
	    using the Advanced Options:Mobile:Simulate Mobile. Hide the gadgets if they display outside the
	    main 320px wide content.</p>
        <?php
    for ($i = 1 ; $i <= $num_imgs ; ++$i) {
        weaveriip_header_add($i);
    }
?>
    <br /><strong>Gadget items allowed:</strong><input name="hdr_num_opts" id="hdr_num_opts" type="text" style="width:40px;height:20px;" class="regular-text" value="<?php echo esc_textarea(weaverii_pro_getopt('hdr_num_opts')); ?>" />
    &nbsp;<small>Enter number of gadget items you need to define (32 Max).</small>

    <br /><strong>Max items displayed over Header:</strong><input name="hdr_use_for_header" id="hdr_use_for_header" type="text" style="width:40px;height:20px;" class="regular-text" value="<?php echo esc_textarea(weaverii_pro_getopt('hdr_use_for_header')); ?>" />
    &nbsp;<small>Only the first "n" gadgets will be displayed over the header. The rest can be uses with the [weaver_gadget] shortcode. (Default: use all defined. Use 0 to disable all over the header.)</small>
	</fieldset>
	<br />
	<input class="button-primary" type="submit" name="weaverii_pro_save_pro" value="Save Plus Header Gadget Options"/>
	<input type="hidden" name="weaveriip_save_header" value="Weaver Plus Header Options Saved" />
	<?php weaverii_nonce_field('weaverii_pro_save_pro'); ?>
    </form>
    <hr />
    </div>
<?php
}

function weaveriip_header_add($i) {
    $opt_base = 'hdr_' . $i . '_';
    if ($i & 1)
	echo("<div style=\"width:99%;background:#eee;padding:4px;border-right:2px solid #eee;\">\n");
    else
	echo("<div style=\"width:99%;padding:4px;border:1px solid #ddd;\">\n");
?>

    <strong><?php echo $i; ?> - </strong><em>Add item over header</em>
    <?php

    if (!weaverii_pro_getopt($opt_base . 'hidemobile') && weaverii_pro_getopt($opt_base . 'x') > 300) {
	echo ' &nbsp;<small style="color:red;font-weight:bold;padding-left:30px;">Warning: X position too far right for Mobile View. Recommend &rarr;</small>';
    } else {
	echo '<span style="padding-right:200px;">&nbsp;</span>';
    }
?>
    <input  type="checkbox" name="<?php echo $opt_base . 'hidemobile'; ?>" id="<?php echo $opt_base . 'hidemobile'; ?>"
    <?php echo weaverii_pro_getopt($opt_base . 'hidemobile'); ?> > <small>Hide if Phone or Small Tablet View.</small>
    <input  type="checkbox" name="<?php echo $opt_base . 'hidetablet'; ?>" id="<?php echo $opt_base . 'hidetablet'; ?>"
    <?php echo weaverii_pro_getopt($opt_base . 'hidetablet'); ?> > <small>Hide if Large Tablet View.</small>

    <div style="margin-left:12px;">
    <strong>X position: </strong>

    <input name="<?php echo $opt_base . 'x'; ?>" id="<?php echo $opt_base . 'x'; ?>" type="text" style="width:40px;height:20px;" class="regular-text" value="<?php echo esc_textarea(weaverii_pro_getopt($opt_base . 'x')); ?>" />
    &nbsp;<small>Pixels from left</small>&nbsp;&nbsp;&nbsp;<strong>Y position: </strong>
    <input name="<?php echo $opt_base . 'y'; ?>" id="<?php echo $opt_base . 'y'; ?>" type="text" style="width:40px;height:20px;" class="regular-text" value="<?php echo esc_textarea(weaverii_pro_getopt($opt_base . 'y')); ?>" />
    &nbsp;<small>Pixels from top</small>&nbsp;&nbsp;&nbsp;
    <strong><small>Show only on Page: </small></strong>
    <input name="<?php echo $opt_base . 'page'; ?>" id="<?php echo $opt_base . 'page'; ?>" type="text" style="width:80px;height:20px;" class="regular-text" value="<?php echo esc_textarea(weaverii_pro_getopt($opt_base . 'page')); ?>" />
    &nbsp;<small>Specify Page ID #, blank for all</small>
    <br />
    <strong>Image URL:</strong>&nbsp;
    <input name="<?php echo $opt_base . 'img'; ?>" id="<?php echo $opt_base . 'img'; ?>" type="text" style="width:200px;height:20px;" class="regular-text" value="<?php echo esc_textarea(weaverii_pro_getopt($opt_base . 'img')); ?>" />
    <?php weaverii_media_lib_button($opt_base . 'img'); ?>
    &nbsp;<em>Image Title:</em>&nbsp;
    <input name="<?php echo $opt_base . 'imgalt'; ?>" id="<?php echo $opt_base . 'imgalt'; ?>" type="text" style="width:150px;height:20px;" class="regular-text" value="<?php echo esc_textarea(weaverii_pro_getopt($opt_base . 'imgalt')); ?>" />
    &nbsp;<small>Image URL and optional title attribute.</small>
    <br>
    <strong>Text:</strong>&nbsp;
    <input name="<?php echo $opt_base . 'text'; ?>" id="<?php echo $opt_base . 'text'; ?>" type="text" style="width:360px;height:20px;" class="regular-text" value="<?php echo esc_textarea(weaverii_pro_getopt($opt_base . 'text')); ?>" />
    &nbsp;<small>Arbitrary text, including HTML. Supports shortcodes.</small>
    <br /><strong>Extra CSS styling:</strong>&nbsp;
    <input name="<?php echo $opt_base . 'textstyle'; ?>" id="<?php echo $opt_base . 'textstyle'; ?>" type="text" style="width:180px;height:20px;" class="regular-text" value="<?php echo esc_textarea(weaverii_pro_getopt($opt_base . 'textstyle')); ?>" />
    &nbsp;<small>Optional CSS <em>styling</em> to wrap entire item (will be added in &lt;span style="<em>styling</em>"&gt; tag.).</small>
    <br>
    <strong>Link URL:</strong>&nbsp;
    <input name="<?php echo $opt_base . 'link'; ?>" id="<?php echo $opt_base . 'link'; ?>" type="text" style="width:200px;height:20px;" class="regular-text" value="<?php echo esc_textarea(weaverii_pro_getopt($opt_base . 'link')); ?>" />
    &nbsp;<em>Link Description:</em>&nbsp;
    <input name="<?php echo $opt_base . 'linkalt'; ?>" id="<?php echo $opt_base . 'linkalt'; ?>" type="text" style="width:150px;height:20px;" class="regular-text" value="<?php echo esc_textarea(weaverii_pro_getopt($opt_base . 'linkalt')); ?>" />
    &nbsp;<small>Add link and description if you want item to link.</small>
    <br />
    </div>
<?php
     echo("</div>\n");
}

?>
