<?php
/**
 * The template for displaying search forms in Weaver II
 *
 * @package WordPress
 * @subpackage Weaver II
 * @since Weaver II 1.0
 */
weaverii_trace_template(__FILE__);

    $placeholder = weaverii_getopt('wii_search_msg');
    if ($placeholder == '')
        $placeholder = 'Search Site';

    $use_img = 'images/search_button.gif';
    if (weaverii_getopt('wii_go_button'))
        $use_img = 'images/go_button.gif';

    $imgurl = weaverii_relative_url($use_img);

    $use_img = weaverii_getopt('_wii_search_button_url');
    if (strlen($use_img) > 0) {
        $imgurl = $use_img;
    }
    $f =  '<form role="search" method="get" id="searchform" action="' . home_url( '/' ) . '" >
	<section class="search"><label class="screen-reader-text" for="s">' . __('Search for:','weaver-ii') . '</label>
	<input type="search" value="' . get_search_query() . '" name="s" id="s" placeholder="'. $placeholder .'" />
        <input style="margin-bottom:-5px;" type="image" src="' . $imgurl . '" onsubmit="submit-form();">
	</section>
	</form>';

    $ff = apply_filters('get_search_form',$f);
    if ( $echo ) {
	echo $ff;
	return;
    }
    else {
	return $ff;
    }
    return $ff;
?>
