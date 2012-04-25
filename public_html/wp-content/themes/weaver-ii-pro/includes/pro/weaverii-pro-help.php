<?php
/*
Weaver Plus Help

This code is Copyright 2011 by Bruce Wampler, all rights reserved.
This code is licensed under the terms of the accompanying license file: license.html.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
*/

function weaveriip_help_admin() {

    $tdir = get_template_directory_uri();
    $readme = $tdir . '/includes/pro/pro-help.html';
?>
    <div>
    <h3>Weaver Pro Help</h3>
    <br />
<ul>
       <li><a href="<?php echo $readme; ?>#header_opts" target="_blank">Header Options</a> - fine tune header settings; additional menu options</li>
       <li><a href="<?php echo $readme; ?>#more_opts" target="_blank">More Options</a> - advanced customization options for posts and other site options</li>
       <li><a href="<?php echo $readme; ?>#font_control" target="_blank">Font Control</a> - adjust the font of any text element - standard or Google Web Fonts</li>
       <li><a href="<?php echo $readme; ?>#TotalCSS" target="_blank">Total CSS</a> - style almost every CSS rule used by Weaver</li>
       <li><a href="<?php echo $readme; ?>#slider"target="_blank">Slider Menu</a> - add sliding image menus to header, sidebars, or anywhere</li>
       <li><a href="<?php echo $readme; ?>#extra_menus" target="_blank">Extra Menus</a> - add extra text menus anywhere, including sidebar widget</li>
       <li><a href="<?php echo $readme; ?>#link_buttons" target="_blank">Link Buttons</a> - add image link buttons anywhere with shortcode</li>
       <li><a href="<?php echo $readme; ?>#social_buttons" target="_blank">Social Buttons</a> - add social link buttons anywhere, including menu, pages, posts, and widget area</li>
       <li><a href="<?php echo $readme; ?>#header_gadgets" target="_blank">Header Gadgets</a> - easily place images, text, links anywhere on your header</li>
       <li><a href="<?php echo $readme; ?>#widget_areas" target="_blank">Widget Areas</a> - add new widget areas anywhere - pages, posts, or advanced html areas</li>
       <li><a href="<?php echo $readme; ?>#search_form" target="_blank">Search Form</a> - add good looking HTML5 search form anywhere</li>
       <li><a href="<?php echo $readme; ?>#show_feed" target="_blank">Show Feed</a> - include feeds from other sites formatted to match your site's own post styling</li>
       <li><a href="<?php echo $readme; ?>#popup_link" target="_blank">Popup Link</a> - place a link that will popup a new window</li>
       <li><a href="<?php echo $readme; ?>#showhide" target="_blank">Show/Hide Text</a> - include content that the user can show or hide</li>
       <li><a href="<?php echo $readme; ?>#comment_policy" target="_blank">Comment Policy</a> - add comment policy statement after posts - content can include shortcodes</li>
       <li><a href="<?php echo $readme; ?>#shortcoder" target="_blank">Shortcoder</a> - define your own shortcodes</li>
       <li><a href="<?php echo $readme; ?>#php_code" target="_blank">PHP</a> - include PHP code where needed</li>
       <li><a href="<?php echo $readme; ?>#plus_admin" target="_blank">Plus Admin</a> - selectively disable Weaver Plus features</li>
    </ul>


     <hr />
    </div>
<?php
}
?>
