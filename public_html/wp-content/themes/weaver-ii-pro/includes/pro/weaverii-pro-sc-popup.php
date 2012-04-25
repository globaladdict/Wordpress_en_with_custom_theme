<?php
/*
Weaver II Pro Shortcodes - Version 1.0
POPUP LINK
ADMIN+CODE

This code is Copyright 2011 by Bruce Wampler, all rights reserved.
This code is licensed under the terms of the accompanying license file: license.html.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
*/
function weaveriip_has_popup_link() {return true;}

function weaveriip_popup_link_admin() {
?>
<p class='wvr-option-section'>Popup Link - [weaver_popup_link] <?php weaveriip_help_link('pro-help.html#popup_link','Popup Link help'); ?></p>

<p><code>[weaver_popup_link href='url' h='height-px' w='width_px']link-content-text/image[/weaver_popup_link]</code></p>

<p>The <code>[weaver_popup_link]</code> short code allows you to display any web-address in a "popup" new browser window.
The power of this is that you can display content such as help, media, or whatever, in a new browser window
while the visitor continues to browser you site.</p>

<p><strong>Shortcode usage:</strong> <code>[weaver_popup_link href='url' h='height-px' w='width_px']link-content-text/image[/weaver_popup_link]</code>
<br />
<ol>
    <li><strong>link-content-text/image</strong> - This shortcodes works much like a standard &lt;a&gt; tag. The content
    between the beginning and closing shortcode tags will be displayed to identify the popup link. Just like with a regular
    &lt;a> tag, the link content can be an image or regular text. Note that this shortcode is fairly simple minded, and
    simply opens a minimally sized browser window. It does not use fancy JavaScript or Flash to accomplish the goal.
    </li>

    <li><strong>href=</strong> - The 'href' works just like the 'href' in a regular &lt;a> tag - it is the full url of a page
    you want displayed in a new browser window. This can be an external web page, or an internal site page. One of the
    intended uses of the <em>Weaver Pop Up Page Template</em> is to serve as a target for this shortcode. When you create a
    'Pop Up' page, and also check the 'Hide Entire Header', 'Hide Entire Footer', 'Hide Sidebars', and 'Hide Page on
    the Primary Menu' per page options, the page will be displayed only with the content you enter into the page
    content area with the page editor. This content could be an image, a media player, or whatever you want.
    </li>
    <li><strong>h=</strong> - The desired height of the popup window. Most browsers will honor this size request, but
    not all browsers do (Chrome has minimum window sizes at the moment, for example). This height should correspond to
    the exact height of your popup content. Most current browsers also will leave their top bar and other parts
    displayed along with your content.
    </li>
    <li><strong>w=</strong> - The desired width of the popup window. Like the 'h' value, some browsers have minimum display sizes.
    </li>
    </ol>
</p>

<?php
}

/* -------------- weaveriip_popup_link --------------- */
function weaveriip_popup_link_shortcode($args = '', $link) {
    /* implement [weaver_popup_link opt1="val1" opt2="value"]link-html[/weaver_popu_link] shortcode */

    extract(shortcode_atts(array(
	'href' => '#',
	'w' => '100',
	'h' => '100'
    ), $args));

    $link = do_shortcode($link);

    $content = '<a href="' . $href . '" onClick="window.open(this.href,' .
    "'_blank','toolbar=no,location=no,directories=no,status=no,scrollbars=no,resizable=no, menubar=no, width=$w,height=$h');return(false)\">$link</a>";
    return $content;
}

add_shortcode('weaver_popup_link', 'weaveriip_popup_link_shortcode');

?>
