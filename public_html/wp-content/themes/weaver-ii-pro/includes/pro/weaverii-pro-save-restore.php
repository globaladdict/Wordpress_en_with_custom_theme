<?php
/*
Weaver II Pro Save/Restore - Version 1.0

ADMIN+CODE

This code is Copyright 2011 by Bruce Wampler, all rights reserved.
This code is licensed under the terms of the accompanying license file: license.html.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
*/
function weaveriip_has_saverestore() {return true;}

function weaveriip_saverestore_admin() {
?>
<p class='wvr-option-section'>Weaver II Pro Save/Restore Plus Settings <?php weaveriip_help_link('pro-help.html#plus_admin','Save/Restore help'); ?></p>


<p>You can save and restore Weaver II Pro settings to a file on your site's files.</p>


<h4>Save as file on this website's server</h4>
 <p>Please provide a name for your file, then click the "Save File" button. <b>Warning:</b> Duplicate names will
    automatically overwrite existing file without notification.</p>
    <form name="weaveriip_options_form" method="post">
	table>
    <td>Name for saved Plus Settings: <input type="text" name="wvp_save_name" size="30" />&nbsp;<small>(Please use a meaningful
    name - do not provide file extension. Name might be altered to standard form.)</small></td></tr>
	<tr>
	<td><span class='submit'><input class="button-primary" type="submit" name="weaverii_pro_save_pro" value="Save Plus Settings to File"/></span>&nbsp;&nbsp;
	<small><strong>Save Plus Settings in File</strong> - Settings will be saved in <em><?php echo($ttw_theme_dir);?></em> directory on your site server.</small></td>
        </tr>
    </table>
	<br />
	<input type="hidden" name="weaveriip_save_settings" value="Weaver II Pro Settings Saved" />
	<?php weaverii_nonce_field('weaverii_pro_save_pro'); ?>
    </form>
<?php
}

function weaveriip_save_settings() {
    if (isset($_POST['wvp_save_name'])) {
	$val = $_POST['wvp_save_name'];
	if ($val == '')
	    $i = 0; // no name
	else
	    $i = 1;// save to xx
    }

    /* and let the user know something happened */
    echo '<div id="message" class="updated fade"><p><strong>Weaver II Pro Settings Saved to File</strong></p></div>';
}

?>
