<?php
/*
Weaver II Pro Shortcoder

This code is Copyright 2011 by Bruce Wampler, all rights reserved.
This code is licensed under the terms of the accompanying license file: license.html.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
*/

function weaveriip_shortcoder_admin() {

    if (!weaverii_pro_isset('wvpsc_num_opts')) weaveriip_shortcoder_init();

    $num_imgs = weaverii_pro_getopt('wvpsc_num_opts');
    if ($num_imgs < 1) {
	weaverii_pro_setopt('wvpsc_num_opts',2);
	$num_imgs = 2;
    }
    ?>

    <div>
    <p class='wvr-option-section'>Weaver Shortcoder [weaver_sc] - <small>Define your own shortcodes.</small> <?php weaveriip_help_link('pro-help.html#shortcoder','Shortcoder help'); ?></p>
<p><code>[weaver_sc id="myname" v1="optional-replacement" ... v9="replacement"]</code></p>


    <p>This [weaver_sc] shortcode allows you to define your own named shortcodes. These really serve as "macros" - an easy way
    to define constant text or other fixed content you would like to add to your pages, posts, or widget areas.
    The content you define can include other <em>shortcodes</em> and <em>basic HTML</em>, as well as <em>Raw HTML</em>
    or <em>Scripts</em> if you have the role permissions to do that.</p>

    <p>[weaver_sc] supports nine (9) optional parameters, v1 to v9, that allow you to pass values to your shortcode
    definition text. The value of any parameter will replace the equivalent parameter specified as %v1% in your text.
    For example, if you had a shorcode "name" and definition text contained "My name is %v1%.", and you use the shortcode
    [weaver_sc id="name" v1="Bruce"], the output included in your content would be "My name is Bruce." This allows
    you to use the same short code in different pages or posts and supply variable content.</p>

    <form name="weaveriip_options_form" method="post">
	<input class="button-primary" type="submit" name="weaverii_pro_save_pro" value="Save Plus Shortcoder Options"/>
	<br />
        <fieldset class="options">
	    <br /><strong style="color:blue;">Define Custom Shortcodes</strong>
	    <p>You can add an arbitrary number of your own [weaver_sc] definitions by id.</p>
        <?php
    for ($i = 1 ; $i <= $num_imgs ; ++$i) {
        weaveriip_sc_add($i);
    }
?>
    <br /><strong>Custom shortcodes definitions allowed:</strong><input name="wvpsc_num_opts" id="wvpsc_num_opts" type="text" style="width:40px;height:20px;" class="regular-text" value="<?php echo weaverii_esc_textarea(weaverii_pro_getopt('wvpsc_num_opts')); ?>" />
    &nbsp;<small>Enter number of Weaver Shortcoder definitions you need (25 max).</small>
	</fieldset>
	<br />
	<input class="button-primary" type="submit" name="weaverii_pro_save_pro" value="Save Plus Shortcoder Options"/>
	<input type="hidden" name="weaveriip_save_shortcoder" value="Weaver II Pro Shortcoder Options Saved" />
	<?php weaverii_nonce_field('weaverii_pro_save_pro'); ?>
    </form>
    <hr />
    </div>
<?php
}

function weaveriip_sc_add($i) {
    $opt_base = 'wvpsc_' . $i . '_';
    if ($i & 1)
	echo("<div style=\"width:99%;background:#eee;padding:4px;border-right:2px solid #eee;\">\n");
    else
	echo("<div style=\"width:99%;padding:4px;border:1px solid #ddd;\">\n");
?>

    <strong><em>Define Custom Shortcode</em></strong>
<?php
    if (weaverii_pro_getopt($opt_base . 'id') != '')
        echo '&nbsp;&nbsp;To use, add <code>[weaver_sc id="' . trim(weaverii_pro_getopt($opt_base . 'id')) . '"]</code> wherever shortcodes are supported.' ;
?>
    <br /><div style="margin-left:12px;">
    <strong>Shortcode ID:</strong>
    <input name="<?php echo $opt_base . 'id'; ?>" id="<?php echo $opt_base . 'id'; ?>" type="text" style="width:100px;height:20px;" class="regular-text" value="<?php echo weaverii_esc_textarea(weaverii_pro_getopt($opt_base . 'id')); ?>" />
    &nbsp;<small>Enter an ID name for your shortcode - your choice (will be filtered to valid format)</small><br />
    <strong>Shortcode definition:</strong><br />
    <textarea name="<?php echo $opt_base . 'text'; ?>" rows=4 style="width: 600px"><?php
	      echo(weaverii_esc_textarea(weaverii_pro_getopt($opt_base . 'text'))); ?></textarea>

    <br>
    </div>
<?php
     echo("</div>\n");
}

?>
