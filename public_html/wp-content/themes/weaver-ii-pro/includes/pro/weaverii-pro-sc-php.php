<?php
/*
Weaver II Pro PHP - Version 1.0
PHP
ADMIN+CODE

This code is Copyright 2011 by Bruce Wampler, all rights reserved.
This code is licensed under the terms of the accompanying license file: license.html.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
*/

function weaveriip_has_php() {return true;}
function weaveriip_php_admin() {
?>
<p class='wvr-option-section'>PHP - [weaver_php] <?php weaveriip_help_link('pro-help.html#php_code','PHP shortcode help'); ?></p>

<p><code>[weaver_php]php code[/weaver_php]</code></p>

<p>The <code>[weaver_php]</code> short code allows you to use php within a page, post, or text widget.</p>

<p><strong>Shortcode usage:</strong> <code>[weaver_php]php code[/weaver_php]</code>
<br />
The [weaver_php] and [/weaver_php] act like &lt;?php and ?&gt;. The PHP code is executed using the
PHP <em>exec()</em> function and any resulting output added to the HTML page. If your PHP has any errors,
or your system has exec() disabled, there will be no output.</p>
<p>
<span style="color:red;"><strong>Important note:</strong></span> If your php code
spans multiple lines (i.e., you use the Enter key), then you <em>must</em> use the HTML editor view,
<em>and</em> check the Raw HTML per page option in the page/post editor screen.
Short PHP snippets on just one line will work from either the HTML or Visual editors.
</p>

<?php
}

/* -------------- weaveriip_php--------------- */
function weaveriip_php_do_eval($code) {
    $char_codes = array( '&#8216;', '&#8217;', '&#8220;', '&#8221;', '&#8242;', '&#8243;', '&#8211;', '&#8212;', '&#8230;', '&#215;' );
    $replacements = array( "'", "'", '"', '"', "'", '"', '--', '---', '...', 'x' );
    $php = str_replace( $char_codes, $replacements, $code );    // untexturize

    $php  .= ';';

    $err_level = error_reporting(0);
    $out = '';
    ob_start();

    if(version_compare(PHP_VERSION, '5.0.0', '>')) {
       try { eval($php); } catch(Exception $e) {}
    } else {
        eval($php);
    }

    $out .= ob_get_clean();
    error_reporting($err_level);
    return $out;
}

function weaveriip_php_shortcode($args = '', $code) {
     return weaveriip_php_do_eval($code);
}

add_shortcode('weaver_php', 'weaveriip_php_shortcode');

?>
