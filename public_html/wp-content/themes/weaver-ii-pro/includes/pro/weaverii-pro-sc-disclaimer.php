<?php
/*
Weaver II Pro Shortcodes - Version 1.0
COMMENT DISCLAIMER
ADMIN+CODE

This code is Copyright 2011 by Bruce Wampler, all rights reserved.
This code is licensed under the terms of the accompanying license file: license.html.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
*/
function weaveriip_has_disclaimer() {return true;}

function weaveriip_disclaimer_admin() {
?>
<p class='wvr-option-section'>Weaver II Pro Comment Policy / Disclaimer <?php weaveriip_help_link('pro-help.html#comment_policy','Comment Policy help'); ?></p>


<p>Weaver II Pro Comment Disclaimer allows you to display a disclaimer, other comment policy, or any thing else (including
shortcodes) right under the Post Comment button. Nothing will be displayed if the text box below is empty.</p>

    <form name="weaveriip_options_form" method="post">
	<input class="button-primary" type="submit" name="weaverii_pro_save_pro" value="Save Comment Disclaimer Text"/>
	<br /><br />
        <fieldset class="options">
	<span style="font-weight:bold; color:blue;">Weaver II Pro Comment Policy / Disclaimer</span><br />
        <p>
            Enter text for you disclaimer. You can use basic HTML to format your disclaimer text. The HTML
            will be wrapped with &lt;div class="weaver-comment-disclaimer"> so you can add style
            using Weaver's &lt;HEAD> Section. While designed to
            add comment policy text, you can add anything you want, including shortcodes. Need a widget area after
            a comment block? Use the [weaver_widget_area] short code to add one.
        </p>
        <p>
	    <textarea name="wvr_disclaimer" rows=10 style="width: 90%"><?php echo(weaverii_esc_textarea(weaverii_pro_getopt('wvr_disclaimer'))); ?></textarea>
        </p>

	</fieldset>
	<br />
	<input class="button-primary" type="submit" name="weaverii_pro_save_pro" value="Save Comment Disclaimer Text"/>
	<input type="hidden" name="weaveriip_save_disclaimer" value="Weaver II Pro Posts Options Saved" />
	<?php weaverii_nonce_field('weaverii_pro_save_pro'); ?>
    </form>
    <hr />
<?php
}

function weaveriip_save_disclaimer() {
    if (isset($_POST['wvr_disclaimer'])) {
	$val = $_POST['wvr_disclaimer'];
	if ($val == '')
	    weaverii_pro_setopt('wvr_disclaimer','');
	else
	    weaverii_pro_setopt('wvr_disclaimer',weaverii_filter_textarea($_POST['wvr_disclaimer']));
    }

    weaverii_pro_update_options('save_disclaimer');

    /* and let the user know something happened */
    echo '<div id="message" class="updated fade"><p><strong>Weaver II Pro Comment Disclaimer Text Saved</strong></p></div>';
}

function weaveriip_show_disclaimer() {
	$text = weaverii_pro_getopt('wvr_disclaimer');
	if (!empty($text)) {
		echo('<div class="weaver-comment-disclaimer">'. do_shortcode($text) .'</div>');
	}
}
add_action('comment_form', 'weaveriip_show_disclaimer', 99);


?>
