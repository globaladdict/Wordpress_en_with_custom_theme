<?php
/* Weaver II Pro Globals
*/
    $weaverii_pro_opts = array();

    $weaveriip_slider_opts = false;

    $weaverii_fonts_defs = array(

    array('label' => 'OVERALL FONTS', 'tag'=>'', 'id' => '_overall', 'info' =>'Google Fonts for Titles/Content.'),

    array('label'=>'Content Font',
	'tag' => 'body',
	'id' => 'wiip_fonts_content', 'info' =>'Font used for most content and widget text.'),

    array('label'=> 'Titles Font', 'tag' =>
	'h3#comments-title,h3#reply-title,.menu_bar,
#author-info,#infobar,#nav-above, #nav-below,#cancel-comment-reply-link,.form-allowed-tags,
#site-info,#site-title,#wp-calendar,#comments-title,.comment-meta,.comment-body tr th,.comment-body thead th,
.entry-content label,.entry-content tr th,.entry-content thead th,.entry-format,.entry-meta,.entry-title,
.entry-utility,#respond label,.navigation,.page-title,.pingback p,.reply,.widget-title,
.wp-caption-text,input[type=submit]',
	'id' => 'wiip_fonts_title', 'info' =>'Font used for post, page, and widget titles, info labels, and menus.'),

    array('label' => 'MENU FONTS', 'tag'=>'', 'id' => '_menus', 'info' =>'Fonts used on menus'),
    array('label'=> 'Menu Bars', 'tag' =>
	'.menu_bar',
	'id' => 'wiip_fonts_menubar', 'info' =>'Font used for main menu bars.'),
    array('label' => 'Extra Vertical Menu', 'tag'=>'.menu-vertical', 'id' => 'wiip_fonts_menu_vertical', 'info' =>'Basic Rollover Vertical Menu (.menu-vertical)'),
    array('label' => 'Extra Horizontal Menu', 'tag'=>'.menu-horizontal', 'id' => 'wiip_fonts_menu_horizontal', 'info' =>'Simple Horizontal One Level Menu (.menu-horizontal)'),


    array('label' => 'TITLES &amp; HEADINGS', 'tag'=>'yyy', 'id' => '_titles-headings', 'info' =>'Titles and Headings'),
    array('label' => 'Headings',
	'tag'=>'#content h1, #content h2, #content h3, #content h4, #content h5, #content h6, #content dt, #content th,
	h1, h2, h3, h4, h5, h6,.page-title,.page-link,#entry-author-info h2,h3#comments-title, h3#reply-title,
	.comment-author cite,.entry-content fieldset legend',
	'id' => 'wiip_fonts_titles-headings', 'info' =>'Content are headings and other labels (h1, h2, etc.). Includes Titles if not specified otherwise below.'),
    array('label' => 'Site Title', 'tag'=>'#site-title', 'id' => 'wiip_fonts_site_title', 'info' =>'Main Site Title'),
    array('label' => 'Site Description', 'tag'=>'#site-description', 'id' => 'wiip_fonts_site_desc', 'info' =>'Site Description'),
    array('label' => 'Page Title', 'tag'=>'#content .entry-title', 'id' => 'wiip_fonts_page_title', 'info' =>'Title on Pages'),
    array('label' => 'Post Entry Titles', 'tag'=>'#content .entry-title a', 'id' => 'wiip_fonts_post_entry_title', 'info' =>'Titles for posts'),
    array('label' => 'Post Format Title', 'tag'=>'#content h5.entry-format', 'id' => 'wiip_fonts_entry_format', 'info' =>'Pre-Title for posts with Post Format specified'),
    array('label' => 'Widget Title', 'tag'=>'.widget-title,.widget_search label,#wp-calendar caption', 'id' => 'wiip_fonts_wdg_title', 'info' =>'Widget titles and labels'),


    array('label' => 'OTHER FONTS', 'tag'=>'yyy', 'id' => '_otherfonts', 'info' =>'Content and other fonts'),
    array('label' => 'Page Content Text', 'tag'=>'#content, #content input, #content textarea', 'id' => 'wiip_fonts_page_content', 'info' =>'Main Content'),
    array('label' => 'Post Content Text', 'tag'=>'#content .post, #content .post input, #content .post textarea', 'id' => 'wiip_fonts_post_content', 'info' =>'Post Content (same as Main unless otherwise specified here)'),
    array('label' => 'Widget Area Text', 'tag'=>'.widget-area', 'id' => 'wiip_fonts_wdg_content', 'info' =>'Widget area content'),
    array('label' => 'Post Info text', 'tag'=>'.entry-meta, .entry-content label, .entry-utility', 'id' => 'wiip_fonts_post_info', 'info' =>'Post information text'),
    array('label' => 'Navigation', 'tag'=>'.navigation', 'id' => 'wiip_fonts_navigation', 'info' =>'Next/Previuos posts links'),
    array('label' => 'Captions', 'tag'=>'#content .wp-caption p.wp-caption-text, #content .gallery .gallery-caption', 'id' => 'wiip_fonts_captions', 'info' =>'Captions, e.g., below media images'),
    array('label' => 'Standard Links', 'tag'=>'a', 'id' => 'wiip_fonts_links', 'info' =>'Most links'),
    array('label' => 'Post Info links', 'tag'=>'.entry-meta a, .entry-utility a', 'id' => 'wiip_fonts_meta_links', 'info' =>'inks in post information lines'),
    array('label' => 'Widget Links', 'tag'=>'yyy', 'id' => 'wiip_fonts_wdg_links', 'info' =>'Links in widgets'),


    array('label' => 'CUSTOM FONT RULES', 'tag'=>'', 'id' => '_menus', 'info' =>'Specify fonts for other CSS elements'),
    array('label' => 'Custom 1', 'tag'=>'+++', 'id' => 'wiip_fonts_custom1', 'info' =>'Custom font - include rule name in edit box'),
    array('label' => 'Custom 2', 'tag'=>'+++', 'id' => 'wiip_fonts_custom2', 'info' =>'Custom font - example: ".my-class {font-style:italic;}"'),
    array('label' => 'Custom 3', 'tag'=>'+++', 'id' => 'wiip_fonts_custom3', 'info' =>'Custom font'),
    array('label' => 'Custom 4', 'tag'=>'+++', 'id' => 'wiip_fonts_custom4', 'info' =>'Custom font'),
  );
?>
