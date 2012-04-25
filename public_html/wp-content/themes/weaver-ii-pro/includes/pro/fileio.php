<?php
// The Weaver II File Handlers

// This library is designed to handle these cases:
// 1. Standard Weaver II Edition with no file writing used - the fileio-lite.php version is used.
// 2. Weaver Pro using standard PHP file I/O
// 3. Use Weaver FTP File Access Plugin for insecure shared hosts
//

function weaverii_f_file_access_fail($who = '') {
    static $weaverii_f_file_access_fail_sent = false;
    if ($weaverii_f_file_access_fail_sent) return;	// only show once...
    $weaverii_f_file_access_fail_sent = true;

    $readme = get_template_directory_uri().'/help.html';
?>
	<div class="error">
        <strong style="color:#f00; line-height:150%;">*** Weaver II File Access Error! ***</strong> <small style="padding-left:20px;">(But don't panic!)</small>
	<p>Weaver II is unable to process a file access request. This error is most commonly seen if you are using the
	Weaver II FTP File Access Plugin. In that case, you may have incomplete or incorrect FTP credentials set in
	the plugin's admin page, or in your wp-config.php file. Otherwise, it is unusual to see this error. It often is generated
	after you move to a new host, or switch between the <em>Weaver II FTP File Access Plugin</em> and <em>Standard File Access</em>.</p>
	<p>You may have to change the directory permissions on your web hosting server. See <a href="<?php echo $readme; ?>#File_access_plugin" target="_blank">
Weaver II FTP File Access Plugin</a> Help for more information.</p>
	<?php echo "<p>Diagnostics: $who</p>\n"; ?>
	</div>
<?php
	return;
}


function weaverii_f_file_access_available() {
    return true;
}

function weaverii_f_open($fn, $how) {
    if (function_exists('weaverii_ftp_open'))
	return weaverii_ftp_open($fn, $how);
    else
	return fopen($fn, $how);
}

function weaverii_f_write($fn,$data) {
    if (function_exists('weaverii_ftp_write'))
	return weaverii_ftp_write($fn,$data);
    else
	return fwrite($fn,$data);
}

function weaverii_f_close($fn) {
    if (function_exists('weaverii_ftp_close'))
	return weaverii_ftp_close($fn);
    else
	return fclose($fn);
}

function weaverii_f_delete($fn) {
    if (function_exists('weaverii_ftp_delete'))
	return weaverii_filep_delete($fn);
    else
	return @unlink($fn);
}

function weaverii_f_is_writable($fn) {
    if (function_exists('weaverii_ftp_is_writable'))
	return weaverii_ftp_is_writable($fn);
    else
	return @is_writable($fn);

}

function weaverii_f_touch($fn) {
    if (function_exists('weaverii_ftp_touch'))
	return weaverii_ftp_touch($fn);
    else
	return @touch($fn, time(), time());
}

function weaverii_f_mkdir($fn) {
    if (function_exists('weaverii_ftp_mkdir'))
	return weaverii_ftp_mkdir($fn);
    else
	return wp_mkdir_p($fn);
}

// functions for reading files

function weaverii_f_exists($fn) {
    // this one must use native PHP version since it is used at theme runtime as well as admin
    return @file_exists($fn);
}

function weaverii_f_get_contents($fn) {
    if (function_exists('weaverii_ftp_get_contents'))
	return weaverii_ftp_get_contents($fn);
    else
	return file_get_contents($fn);
}

// =========================== helper functions ===========================
function weaverii_f_content_dir() {
    // delivers appropraite path for using weaverii_f_ functions. WP_CONTENT_DIR
    if (function_exists('weaverii_ftp_content_dir'))
	return weaverii_ftp_content_dir();
    else
	return trailingslashit(WP_CONTENT_DIR);
}

function weaverii_f_plugins_dir() {
    // delivers appropraite path for using weaverii_f_ functions. WP_PLUGIN_DIR
    if (function_exists('weaverii_ftp_plugins_dir'))
	return weaverii_ftp_plugins_dir();
    else
	return trailingslashit(WP_PLUGIN_DIR);
}

function weaverii_f_themes_dir() {
    // delivers appropraite path for using weaverii_f_ functions.
    return weaverii_f_content_dir() . 'themes/';
}

function weaverii_f_wp_lang_dir() {
    // delivers appropraite path for using weaverii_f_ functions. WP_LANG_DIR
    if (function_exists('weaverii_ftp_wp_lang_dir'))
	return weaverii_ftp_wp_lang_dir();
    else
	return trailingslashit(WP_LANG_DIR);
}

function weaverii_f_uploads_base_dir() {
    // delivers appropraite path for using weaverii_f_ functions.
    if (function_exists('weaverii_ftp_uploads_base_dir')) {
	return weaverii_ftp_uploads_base_dir();
    } else {
	$upload_dir = wp_upload_dir();
	return trailingslashit($upload_dir['basedir']);
    }
}

function weaverii_f_uploads_base_url() {
    $wpdir = wp_upload_dir();		// get the upload directory
    return trailingslashit(trim($wpdir['baseurl']));
}


function weaverii_f_wp_filesystem_error() {
    if (function_exists('weaverii_ftp_wp_filesystem_error'))
	weaverii_ftp_wp_filesystem_error();
}

function weaverii_pop_msg($msg) {
    echo "<script> alert('" . $msg . "'); </script>";
    // echo "<h1>*** $msg ***</h1>\n";
}

function weaverii_log($msg, $data='') {
    $handle = fopen(weaverii_f_uploads_base_dir() . 'weaverii_log.txt', 'a');
    fwrite($handle,$msg . ':' . $data . "\n");
    fclose($handle);
}

function weaverii_f_fail($msg) {
    weaverii_pop_msg($msg);
    return false;
}
?>
