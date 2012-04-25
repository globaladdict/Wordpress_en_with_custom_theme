<?php
/*
Weaver II Pro Shortcodes - Version 1.0
SEARCH
ADMIN+CODE

This code is Copyright 2011 by Bruce Wampler, all rights reserved.
This code is licensed under the terms of the accompanying license file: license.html.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
*/

function weaveriip_has_search() {return true;}
function weaveriip_search_admin() {
?>
<p class='wvr-option-section'>Search Form - [weaver_search] <?php weaveriip_help_link('pro-help.html#search_form','Search Form help'); ?></p>

<p><code>[weaver_search width=nn]</code></p>

<p>The <code>[weaver_search]</code> short code allows you to display a search box within a page, post, or text widget.</p>

<p><strong>Shortcode usage:</strong> <code>[weaver_search width=nn]</code>
</p>
<p>
You can change the width (in px) of the search form using the shortcode 'width' parameter.</p>
<p>You can change other display features of the Search
form from the <em>Main Options &rarr; General Appearance</em> tab.
</p>
<?php
}

function weaveriip_search_shortcode($args = '') {
    extract(shortcode_atts(array(
       'width' => ''
    ), $args));

    $out = '';

    $placeholder = weaverii_getopt('wii_search_msg');
    if ($placeholder == '')
        $placeholder = 'Search ' . get_bloginfo( 'name');

    $use_img = 'images/search_button.gif';
    if (weaverii_getopt('wii_go_button'))
        $use_img = 'images/go_button.gif';

    $imgurl = weaverii_relative_url($use_img);

    $use_img = weaverii_getopt('wii_search_button');
    if (strlen($use_img) > 0) {
        $imgurl = $use_img;
    }
    $f =  '<form role="search" method="get" id="searchform" action="' . home_url( '/' ) . '" >
	<section class="search"><label class="screen-reader-text" for="s">' . __('Search for:','weaver-ii') . '</label>
	<input style="width:' . $width . 'px;" type="search" value="' . get_search_query() . '" name="s" id="s" placeholder="'. $placeholder .'" />
        <input style="margin-bottom:-5px;" type="image" src="' . $imgurl . '" onsubmit="submit-form();">
	</section>
	</form>';

    $out .= apply_filters('get_search_form',$f);

    return $out;
}

add_shortcode('weaver_search', 'weaveriip_search_shortcode');
?>
