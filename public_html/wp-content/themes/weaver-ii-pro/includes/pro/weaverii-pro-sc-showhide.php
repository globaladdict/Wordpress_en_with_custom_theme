<?php
/*
Weaver II Pro Shortcodes - Version 1.0
Show/Hide
ADMIN+CODE

This code is Copyright 2011 by Bruce Wampler, all rights reserved.
This code is licensed under the terms of the accompanying license file: license.html.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
*/

function weaveriip_has_showhide() {return true;}

function weaveriip_showhide_admin() {
?>
<p class='wvr-option-section'>Weaver Show/Hide - [weaver_showhide] <?php weaveriip_help_link('pro-help.html#showhide','Show/Hide help'); ?></p>

<p><code>[weaver_showhide]Content to show/hide[/weaver_showhide]</code></p>

<p>The <code>[weaver_showhide start='hide' show='text-on-show' hide='text-on-hide']</code> short code allows you to specify a
section of content that the user can selectively show or hide. It will be hidden by default.</p>

<p>Typically, one would place the shortcode immediately after some explanatory text. For example:<br /><br />
<code>Click to view lyrics [weaver_showhide]<br />
lyrics</br>
[/weaver_showhide]</code><br /><br />

When entered into the Page/Post editor as shown above, the explanatory text and show/hide button will be on a separate line,
and the content in a new paragraph following. If you place the <code>[weaver_showhide]CONTENT[/weaver_showhide]</code> on
the same line in the page/post editor, the explanatory text and content will be displayed on the same line.
</p>

<p><strong>Shortcode usage:</strong> <code>[weaver_showhide start='hide' show='html-on-show' hide='html-on-hide']text[/weaver_showhide]</code>
<br />
<ol>
    <li><strong>start='hide|show'</strong> - By default, the content will start hidden. Set this to 'show' to have the
    content start displayed.
    </li>
    <li><strong>show='img|text'; hide='img|text'</strong> - By default, a graphic + and - will be displayed to
    toggle between hidden and displayed. You can provide an alternative pair of images or text strings. You can't mix
    images and text - both must be the same type. You can't use '[' or ']' in the text.
    </li>
</ol>
</p>
<p>The show and hide text/images are wrapped by a &lt;span&gt; with a class '.weaveriip_showhide_show' and '.weaveriip_showhide_hide', respectively.<p>

<?php
}

function weaveriip_showhide_scripts() {
    // Use wp_enqueue_script to add scripts - called from header.php (added to weaverjslib)

    //$url =  trailingslashit(get_template_directory_uri());
   // wp_enqueue_script('weaverHideDiv', $url.'includes/pro/plus-js/weaver-hide-div.js');
}

function weaveriip_has_img($img) {
    if (stristr($img,'.png') > 0 || stristr($img,'.gif') > 0 || stristr($img,'.jpg')> 0)
        return true;
    else
        return false;
}

/* -------------- weaveriip_php--------------- */
function weaveriip_showhide_shortcode($args = '', $text) {

    extract(shortcode_atts(array(
       'start' => 'hide',      // 'hide' or 'show'
       'show' => '',
       'hide' => '',
       'class' => ''
    ), $args));

    $rand = "sh_".rand();
    $url = weaverii_relative_url('includes/pro/plus-js/');

    $is_img = 'img';

    $text = do_shortcode($text);    // allow nested shortcodes

    if ($show == '') {
        $show = $url . 'show.png';
        $show_img = '<img src="' . $show . '" />';
    } else if (weaveriip_has_img($show)) {
        $show_img = '<img src="' . $show . '" />';
    } else {
        $is_img = 'text';
        $show_img = '<span class="weaveriip_showhide_show">' . $show . '</span>';   // text only
    }

    if ($hide == '') {
        $hide = $url . 'hide.png';
        $hide_img = '<img src="' . $hide . '" />';
    } else if (weaveriip_has_img($show)) {
        $hide_img = '<img src="' . $hide . '" />';
    } else {
        $is_img = 'text';
        $hide_img = '<span class="weaveriip_showhide_hide">' . $hide . '</span>';   // text only
    }

    if ($start == 'hide') {
        $style = 'style="display:none;"';
    } else {
        $style = 'style="display:block;"';
        $show_img = $hide_img;
    }

    if ($class != '') {
        if ($class[0] == '.') $class = substr($class,1);
        $class = 'class="' . $class . '"';
    }

    $out = "<a style='text-decoration:none;' href=\"javascript:void(null);\" onclick=\"weaveriip_ToggleDIV(document.getElementById('" .
        $rand . "'), this, '" . $show . "', '" . $hide . "', '" . $is_img . "')\">";

    $lead = stripos($text,'</p>');

    if ($lead !== false && $lead == 0) { // have </p> to start, so can break
        $out .= $show_img . '</a></p>';
        $text = substr($text,4);        // strip the </p>
        $out .= '<div id="'. $rand . '"' . $style .  ' ' . $class . '>';
        $out .= $text;
        $out .= "</p></div><p>";
    } else {                            // no paragraph - so make inline
        $out .= $show_img . '</a>';
        $has_p = stripos($text,'</p>');
        if ($has_p > 0) {
            $out .= '</p>'; // after the </a> to make span work
        }
        $out .= '<span id="'. $rand . '"' . $style . ' ' . $class . '>';
        if ($has_p > 0) {
            $out .= '<p>'; // to make span work
            $lead_br = stripos($text,'<br />');
            if ($lead_br !== false && $lead_br == 0)
                $text = substr($text,6);
        }
        $out .= $text;

        if ($has_p !== false) {
            if ($has_p > 0)
                $out .= "</p></span><p>";
            else
                $out .= "</p></span>";
        } else {
            $out .= "</span>";
        }
    }

    return $out;
}

add_shortcode('weaver_showhide', 'weaveriip_showhide_shortcode');

?>
