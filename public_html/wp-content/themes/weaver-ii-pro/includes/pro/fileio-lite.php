<?php
// The Weaver II WP_Filesystem interface to "duplicate" fopen, fwrite, etc.

// Route all file operations through weaverii_f functions so might eventually use WP I/O instead of PHP directly

function weaverii_f_file_access_available() {
    return false;
}

function weaverii_f_open($fn, $how) {
    // 'php://output'
    if ($fn == 'php://output' || $fn == 'echo')
        return 'echo';
    return false;
}

function weaverii_f_write($fn,$data) {
     if ($fn == 'echo') {
        echo $data;
	return true;
    }
    else {
	return false;
    }
}

function weaverii_f_close($fn) {
    if ($fn == 'php://output' || $fn == 'echo')
        return true;
    else return false;
}

function weaverii_f_delete($fn) {
    return false;
}

function weaverii_f_is_writable($fn) {
    return false;
}

function weaverii_f_touch($fn) {
    return false;
}

function weaverii_f_mkdir($fn) {
    return false;
}

function weaverii_f_exists($fn) {
    // this one must use native PHP version since it is used at theme runtime as well as admin
    return @file_exists($fn);
}

function weaverii_f_get_contents($fn) {
    return implode('',file($fn));	// works if no newlines in the file...
}

// =========================== helper functions ===========================
function weaverii_pop_msg($msg) {
    echo "<script> alert('" . $msg . "'); </script>";
    // echo "<h1>*** $msg ***</h1>\n";
}

function weaverii_f_content_dir() {
    return trailingslashit(WP_CONTENT_DIR);
 }

function weaverii_f_plugins_dir() {
    // delivers appropraite path for using weaverii_f_ functions. WP_PLUGIN_DIR
    return trailingslashit(WP_PLUGIN_DIR);
}

function weaverii_f_themes_dir() {
    // delivers appropraite path for using weaverii_f_ functions.
    return weaverii_f_content_dir() . 'themes/';
}

function weaverii_f_wp_lang_dir() {
    // delivers appropraite path for using weaverii_f_ functions. WP_LANG_DIR
    return trailingslashit(WP_LANG_DIR);
}

function weaverii_f_uploads_base_dir() {
    // delivers appropraite path for using weaverii_f_ functions.
    $upload_dir = wp_upload_dir();
    return trailingslashit($upload_dir['basedir']);
}

function weaverii_f_uploads_base_url() {
    $wpdir = wp_upload_dir();		// get the upload directory
    return trailingslashit(trim($wpdir['baseurl']));
}

function weaverii_f_wp_filesystem_error() {
    return;
}

function weaverii_f_fail($msg) {
    weaverii_pop_msg($msg);
    return false;
}
?>
