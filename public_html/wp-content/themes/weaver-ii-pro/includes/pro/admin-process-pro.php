<?php

//  Process non-SAPI options for Pro Version

function weaverii_process_options_admin_pro() {

    if (weaverii_submitted('backup_settings')) {
	$name = weaverii_savebackup();
	if ($name !== false)
	    weaverii_save_msg(__('All current main and advanced options backed up in:', 'weaver-ii'/*a*/ ).' "'. $name . '.w2b"');
	else
	    weaverii_save_msg(__('ERROR: Saving backup failed.', 'weaver-ii'/*a*/ ));
    }

    if (weaverii_submitted('filesavetheme')) {
        $base = sanitize_file_name($_POST['savethemename']);
	if (weaverii_dev_mode()) weaverii_setopt('wii_hide_old_weaver',0);
	$temp_url =  weaverii_write_current_theme($base);
        if ($temp_url == '')
            weaverii_save_msg(__('Invalid name supplied to save theme to file.', 'weaver-ii'/*a*/ ));
        else
            weaverii_save_msg(__("All current main and advanced options saved in ", 'weaver-ii'/*a*/ ) . $temp_url);
    }

    if (weaverii_submitted('uploadtheme') &&  isset($_POST['uploadit']) && $_POST['uploadit'] == 'yes') {
        weaverii_uploadit();
    }


    if (weaverii_submitted('restoretheme')) {
	$base = $_POST['wii_restorename'];
	$valid = validate_file($base);		// make sure an ok file name
        $fn = weaverii_f_uploads_base_dir() .'weaverii-subthemes/'.$base;

	if ($valid < 1 && weaverii_upload_theme($fn)) {
	    $t = weaverii_getopt('wii_subtheme'); if ($t == '') $t = 'Antique Ivory';    /* did we save a theme? */
	    weaverii_setopt('wii_theme_filename','custom');	// we have a custom theme now...
	    weaverii_save_msg(__("Weaver II theme restored from file, saved as: ", 'weaver-ii'/*a*/ ).$t);
	} else {
	    weaverii_save_msg('<em style="color:red;">'. __('INVALID FILE NAME PROVIDED - Try Again', 'weaver-ii'/*a*/ ). "($fn)" . '</em>');
	}
    }

    if (weaverii_submitted('save_mobiletheme')) {
	weaverii_save_msg(__("Current settings saved in alternate Mobile View database entry.", 'weaver-ii'/*a*/ ));
	$weaverii_opts = get_option('weaverii_settings',array());
	$weaverii_opts['_wii_mobile_alt_theme'] = 'saved_mobile';		// force these two
	$weaverii_opts['_wii_sim_mobile'] = false;
	$weaverii_opts['_wii_inline_style'] = 'on';
	weaverii_wpupdate_option('weaverii_settings_mobile',$weaverii_opts);
	$weaverii_pro_opts = get_option('weaverii_pro',array());
	weaverii_wpupdate_option('weaverii_pro_mobile',$weaverii_pro_opts);
    }

    if (weaverii_submitted('renametheme')) {
	$name = isset($_POST['wii_themename']) ? $_POST['wii_themename'] : '';
	$desc = isset($_POST['wii_theme_description']) ? $_POST['wii_theme_description'] : '';
	if ($name) weaverii_setopt('wii_themename',$name);
	if ($desc) weaverii_setopt('wii_theme_description',$desc);
    }

    if (weaverii_submitted('deletetheme')) {

        $myFile = isset($_POST['selectName']) ? $_POST['selectName'] : '';
	$valid = validate_file($myFile);
        if ($valid < 1 && $myFile != "None") {
            weaverii_f_delete(weaverii_f_uploads_base_dir() .'weaverii-subthemes/'.$myFile);
	    echo '<div style="background-color: rgb(255, 251, 204);" id="message" class="updated fade"><p>File: <strong>'.$myFile.'</strong> has been deleted.</p></div>';
        } else {
	    echo '<div style="background-color: rgb(255, 251, 204);" id="message" class="updated fade"><p>File: <strong>'.$myFile.'</strong> invalid file name, not deleted.</p></div>';
	}
    }
}

?>
