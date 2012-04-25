<?php
/*
Weaver II Pro Total CSS

This code is Copyright 2011 by Bruce Wampler, all rights reserved.
This code is licensed under the terms of the accompanying license file: license.html.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.

*/
function weaveriip_has_totalcss_admin() {return true;}

function weaveriip_totalcss_admin() {
    /* options - these are coded into Weaver
      'wvp_post_pretitle', 'wvp_post_prebody', 'wvp_post_postbody'
    */
    global $weaveriip_css;

    if (!weaverii_pro_isset('wvp_css')) weaveriip_totalcss_init();
?>

    <div><a name="total_css_top"></a>
    <p class='wvr-option-section'>Weaver II Pro - Total CSS <?php weaveriip_help_link('pro-help.html#TotalCSS','Total CSS help'); ?></p>
<?php
    echo ('&nbsp;|&nbsp;');
    $count = 0;
    foreach ($weaveriip_css as $option => $row) {
	if ($row['id'][0] == '_') {
	    echo('<a href="#' . $row['id'] . '">' . $row['tag'] . '</a>&nbsp;|&nbsp;');
	} else {
	    $count++;
	}
    }
?>
<br />
    <p>These settings will be most useful for advanced web designers. This tab allows you to add custom CSS rules to almost every CSS tag used by Weaver.
    There are <?php echo $count; ?> CSS tags listed here.
    These rules are emitted, in the order shown here, at the <em>end</em> of the generated style file (or in-line style), but come before styles in the &lt;HEAD&gt; Section. Rules for the main menu
    areas (#access, etc.) are not included here. Most links are handled in the Main Options. Many of
    these tags duplicate equivalent cases in Main Options. <span style="color:red">If your rules here don't seem to work, try adding !important
    to the rule since there can be existing rues that can take CSS precedence over some of these rules.</span></p>

    <p><small>Weaver II will auto-add the required {}'s. If you want to double up on rules, you can add rules after the first {} - e.g. {background:green;} #main {border:1px solid red;}. You can't add any tags before the first {}. Just leave an empty {} if needed.</small>
    </p>

    <form name="weaveriip_options_form" method="post">

        <fieldset class="options">
	<span style="font-weight:bold; color:blue;">Weaver CSS Rules</span><br />
	<table class="optiontable">
<?php
	foreach ($weaveriip_css as $option => $val) {
	    weaveriip_css_row($val);
	}
?>
    <tr><td>&nbsp;</td></tr>
    <tr>
	<th scope="row" align="right" style="color:blue;">CSS Box Lines:&nbsp;</th>
	<td>
	    <input type="text" style="width:30px;height:22px;" class="regular-text" name="css_edit_lines"
                id="css_edit_lines" value="<?php echo (weaverii_esc_textarea(weaverii_pro_getopt('css_edit_lines'))); ?>" />
	    <small>Option: Number of lines to display in each edit box on this page.</small>
	</td>
    </tr>
	</table>
	</fieldset>
	<br />
	<input class="button-primary" type="submit" name="weaverii_pro_save_pro" value="Save Total CSS Options"/>
	<input type="hidden" name="weaveriip_save_totalcss" value="Weaver II Pro Total CSS Options Saved" />
	<?php weaverii_nonce_field('weaverii_pro_save_pro'); ?>
    </form>
    <hr />
    </div>
<?php
}

function weaveriip_css_row($row) {
    // echo a CSS row
    if ($row['id'][0] == '_') {
?>
    <tr><th scope="row" align="left" style="color:blue"><br /><a name="<?php echo $row['id'];?>"></a><?php echo weaverii_esc_textarea($row['tag']); ?>&nbsp;&nbsp;</th>
	<td ><br /><?php echo weaverii_esc_textarea($row['info']); ?>&nbsp;&nbsp;&nbsp;<a href="#total_css_top"><strong>Top</strong></a>
	<span style="float:right;"><input class="button-primary" type="submit" name="weaverii_pro_save_pro" value="Save Total CSS Options"/></span>
	</td>
    </tr>
<?php
    } else {
	$rows = weaverii_pro_getopt('css_edit_lines');
	if (!$rows) $rows = 1;
?>
    <tr><th scope="row" align="right" style="width:220px"><?php echo weaverii_esc_textarea($row['tag']); ?>:&nbsp;</th>
	<td ><textarea name="<?php echo $row['id']; ?>" rows=<?php echo $rows; ?> style="width: 300px"><?php
	      echo(weaverii_esc_textarea(weaverii_pro_getopt($row['id']))); ?></textarea> <small><?php echo weaverii_esc_textarea($row['info']); ?></small></td>
    </tr>
<?php
    }
}

if (true) {			// folding editor trick
$weaveriip_css = array(

    array('tag' => 'WRAP AREAS', 'id' => '_areas', 'info' =>'The main areas supported by Weaver'),
    array('tag' => '#wrapper', 'id' => 'css_wrapper', 'info' =>'Wraps entire site'),
    array('tag' => '#branding', 'id' => 'css_header', 'info' =>'Wraps entire header area, up to #main'),
    array('tag' => '#main', 'id' => 'css_main', 'info' =>'Wraps everything between #header and #footer, including sidebars'),
    array('tag' => '#container', 'id' => 'css_container', 'info' =>'Wraps #content and Weaver top/bottom widget areas'),
    array('tag' => '#content', 'id' => 'css_content', 'info' =>'Wraps post/page content'),
    array('tag' => '#content .page', 'id' => 'css_content_page', 'info' =>'Page content'),
    array('tag' => '#content .post', 'id' => 'css_content_post', 'info' =>'Post content'),
    array('tag' => '#colophon', 'id' => 'css_footer', 'info' =>'Wraps entire footer area'),


    array('tag' => 'GLOBAL ELEMENTS', 'id' => '_global', 'info' =>'Styles for major global elements - many are overridden by General Content rules'),
    array('tag' => 'a', 'id' => 'css_a', 'info' =>'default <a>'),
    array('tag' => 'a:link', 'id' => 'css_a_link', 'info' =>'<a> link'),
    array('tag' => 'a:visited', 'id' => 'css_a_visited', 'info' =>'<a> visited'),
    array('tag' => 'a:active', 'id' => 'css_a_active', 'info' =>'<a> active'),
    array('tag' => 'a:hover', 'id' => 'css_a_hover', 'info' =>'<a> hover'),
    array('tag' => 'a img', 'id' => 'css_a_img', 'info' =>'<a><img></a>'),
    array('tag' => 'abbr, acronym', 'id' => 'css_abbr', 'info' =>'<abbr> or <acronym>'),
    array('tag' => 'blockquote', 'id' => 'css_blockquote', 'info' =>'<blockquote>'),
    array('tag' => 'blockquote:before', 'id' => 'css_bq_before', 'info' =>'<blockquote> before'),
    array('tag' => 'blockquote:after', 'id' => 'css_bq_after', 'info' =>'<blockquoteo> after'),
    array('tag' => 'blockquote cite', 'id' => 'css_bqcite', 'info' =>'<blockquote><cite>'),
    array('tag' => 'blockquote em', 'id' => 'css_bqem', 'info' =>'<blockquote><em>'),
    array('tag' => 'big', 'id' => 'css_big', 'info' =>'<big>'),
    array('tag' => 'body', 'id' => 'css_body', 'info' =>'<body>'),
    array('tag' => 'cite', 'id' => 'css_cite', 'info' =>'<cite>'),
    array('tag' => 'del', 'id' => 'css_del', 'info' =>'<del>'),
    array('tag' => 'dd', 'id' => 'css_dd', 'info' =>'<dd>'),
    array('tag' => 'dl', 'id' => 'css_dl', 'info' =>'<dl>'),
    array('tag' => 'dt', 'id' => 'css_dt', 'info' =>'<dt>'),
    array('tag' => 'em, i', 'id' => 'css_em', 'info' =>'<em> or <i>'),
    array('tag' => 'h1', 'id' => 'css_h1', 'info' =>'<h1>'),
    array('tag' => 'h2', 'id' => 'css_h2', 'info' =>'<h2>'),
    array('tag' => 'h3', 'id' => 'css_h3', 'info' =>'<h3>'),
    array('tag' => 'h4', 'id' => 'css_h4', 'info' =>'<h4>'),
    array('tag' => 'h5', 'id' => 'css_h5', 'info' =>'<h5>'),
    array('tag' => 'h6', 'id' => 'css_h6', 'info' =>'<h6>'),
    array('tag' => 'hr', 'id' => 'css_hr', 'info' =>'<hr>'),
    array('tag' => 'input', 'id' => 'css_input', 'info' =>'<input>'),
    array('tag' => 'input[type="text"]', 'id' => 'css_input_text', 'info' =>'<input> text area'),
    array('tag' => 'ins', 'id' => 'css_ins', 'info' =>'<ins>'),
    array('tag' => 'kbd', 'id' => 'css_kbd', 'info' =>'<kbd>'),
    array('tag' => 'ol', 'id' => 'css_ol', 'info' =>'<ol>'),
    array('tag' => 'ol ol', 'id' => 'css_olol', 'info' =>'nested <ol>'),
    array('tag' => 'ol ol ol', 'id' => 'css_ololol', 'info' =>'nested <ol>'),
    array('tag' => 'ol ol ol ol', 'id' => 'css_olololol', 'info' =>'nested <ol>'),
    array('tag' => 'p', 'id' => 'css_p', 'info' =>'<p>'),
    array('tag' => 'pre', 'id' => 'css_pre', 'info' =>'<pre>'),
    array('tag' => 'strong, b', 'id' => 'css_strong', 'info' =>'<strong> or <b>'),
    array('tag' => 'sub', 'id' => 'css_sub', 'info' =>'<sub>'),
    array('tag' => 'sup', 'id' => 'css_sup', 'info' =>'<sup>'),
    array('tag' => 'textarea', 'id' => 'css_textarea', 'info' =>'textarea'),
    array('tag' => 'ul', 'id' => 'css_ul', 'info' =>'<ul>'),
    array('tag' => 'ul ul', 'id' => 'css_ulul', 'info' =>'nested <ul>'),

    array('tag' => 'HEADER', 'id' => '_header', 'info' =>'Elements in the main header area'),
    array('tag' => '#site-title', 'id' => 'css_site_title', 'info' =>'Site Title'),
    array('tag' => '#site-title a', 'id' => 'css_site_title_a', 'info' =>'Site Title link attributes'),
    array('tag' => '#site-description', 'id' =>'css_site_description', 'info' => 'Site Description'),
    array('tag' => '#header_image img', 'id' => 'css_branding_img', 'info' =>'The standard header image.'),


    array('tag' => 'MENU BAR', 'id' => '_menu', 'info' =>'Some of the attributes associated with menus'),
    array('tag' => '.menu-add', 'id' => 'css_menu_add', 'info' =>'Wraps Weaver\s menu right add area'),
    array('tag' => '.menu-add a', 'id' => 'css_menu_add_a', 'info' =>'Wraps Weaver\s menu right add area links'),
    array('tag' => '.menu-add img', 'id' => 'css_menu_add_img', 'info' =>'Wraps Weaver\s menu right add area img'),
    array('tag' => '.menu-add-left', 'id' => 'css_menu_add_left', 'info' =>'Wraps Weaver\s menu left add area'),
    array('tag' => '.menu-add-left a', 'id' => 'css_menu_add_left_a', 'info' =>'Wraps Weaver\s menu left add area links'),
    array('tag' => '.menu-add-left img', 'id' => 'css_menu_add_left_img', 'info' =>'Wraps Weaver\s menu left add area img'),
    array('tag' => '#nav-top-menu', 'id' => 'css_nav_top_menu', 'info' =>'Wraps the top (Secondary) menu'),
    array('tag' => '#nav-bottom-menu', 'id' => 'css_nav_bottom_menu', 'info' =>'Wraps the bottom (Primary) menu'),
    array('tag' => '#infobar', 'id' => 'css_infobar', 'info' =>'Wraps Info Bar'),
    array('tag' => '#breadcrumbs', 'id' => 'css_breadcrumbs', 'info' =>'Spans breadcrumbs'),
    array('tag' => '#infobar_paginate', 'id' => 'css_infobar_paginate', 'info' =>'Wraps Info Bar Blog Navigation'),

    array('tag' => 'GENERAL CONTENT', 'id' => '_general_content', 'info' =>'Styling affecting all Page/Post content'),
    array('tag' => '#content input', 'id' => 'css_con_input', 'info' =>'<input> in #content'),
    array('tag' => '#content textarea', 'id' => 'css_con_textarea', 'info' =>'<textarea> in #content'),
    array('tag' => '#content p', 'id' => 'css_con_p', 'info' =>'<p> in #content'),
    array('tag' => '#content ul', 'id' => 'css_con_ul', 'info' =>'<ul> in #content'),
    array('tag' => '#content ol', 'id' => 'css_con_ol', 'info' =>'<ol> in #content'),
    array('tag' => '#content dd', 'id' => 'css_con_dd', 'info' =>'<dd> in #content'),
    array('tag' => '#content pre', 'id' => 'css_con_pre', 'info' =>'<pre> in #content'),
    array('tag' => '#content hr', 'id' => 'css_con_hr', 'info' =>'<hr> in #content'),
    array('tag' => '#content ul ul', 'id' => 'css_con_ulul', 'info' =>'<ul><ul> in #content'),
    array('tag' => '#content ol ol', 'id' => 'css_con_olol', 'info' =>'<ol><ol> in #content'),
    array('tag' => '#content kbd', 'id' => 'css_con_kbd', 'info' =>'<kbd> in #content'),
    array('tag' => '#content tt', 'id' => 'css_con_tt', 'info' =>'<tt> in #content'),
    array('tag' => '#content var', 'id' => 'css_con_var', 'info' =>'<var> in #content'),
    array('tag' => '#content code', 'id' => 'css_con_code', 'info' =>'<code> in #content'),
    array('tag' => '#content dt', 'id' => 'css_con_dt', 'info' =>'<dt> in #content'),
    array('tag' => '#content th', 'id' => 'css_con_th', 'info' =>'<th> in #content'),
    array('tag' => '#content h1', 'id' => 'css_con_h1', 'info' =>'<h1> in #content'),
    array('tag' => '#content h2', 'id' => 'css_con_h2', 'info' =>'<h2> in #content'),
    array('tag' => '#content h3', 'id' => 'css_con_h3', 'info' =>'<h3> in #content'),
    array('tag' => '#content h4', 'id' => 'css_con_h4', 'info' =>'<h4> in #content'),
    array('tag' => '#content h5', 'id' => 'css_con_h5', 'info' =>'<h5> in #content'),
    array('tag' => '#content img', 'id' => 'css_con_img', 'info' =>'<img> in #content'),
    array('tag' => '#content .entry-title', 'id' => 'css_con_entrytitle', 'info' =>'Page/Post Title'),
    array('tag' => '.entry-content', 'id' => 'css_entry_content', 'info' =>'Page/Post content'),
    array('tag' => '.entry-summary', 'id' => 'css_entry_con_summary', 'info' =>'Page/Post summary content'),
    array('tag' => '#content .entry-summary p:last-child', 'id' => 'css_entry_con_sum_last', 'info' =>'Page/Post content summary - last p'),
    array('tag' => '.entry-content fieldset', 'id' => 'css_entry_content_fs', 'info' =>'Page/Post content'),
    array('tag' => '.entry-content', 'id' => 'css_entry_content_fieldset', 'info' =>'Page/Post content <fieldset>'),
    array('tag' => '.entry-content fieldset legend', 'id' => 'css_entry_content_fs_legend', 'info' =>'Page/Post content <fieldset><legend>'),
    array('tag' => '.entry-content input', 'id' => 'css_entry_content_input', 'info' =>'Page/Post content <input>'),
    array('tag' => '.entry-content label', 'id' => 'css_entry_content_label', 'info' =>'Page/Post content <label>'),
    array('tag' => '.entry-content select', 'id' => 'css_entry_content_select', 'info' =>'Page/Post content <select>'),
    array('tag' => '.entry-content sup', 'id' => 'css_entry_contentsup', 'info' =>'Page/Post content <sup>'),
    array('tag' => '.entry-content sub', 'id' => 'css_entry_contentsub', 'info' =>'Page/Post content <sub>'),
    array('tag' => '.entry-content blockquote.left', 'id' => 'css_entry_content_bq_left', 'info' =>'Page/Post content <blockquote> on left'),
    array('tag' => '.entry-content blockquote.right', 'id' => 'css_entry_content_bq_right', 'info' =>'Page/Post content <blockquote> on right'),
    array('tag' => '#content table', 'id' => 'css_cnt_table', 'info' =>'<table>'),
    array('tag' => '#content tr th', 'id' => 'css_cnt_tr-th', 'info' =>'<table><tr><th>'),
    array('tag' => '#content thead th', 'id' => 'css_cnt_thead-th', 'info' =>'<table><thead><th>'),
    array('tag' => '#content tr td', 'id' => 'css_cnt_tr-td', 'info' =>'<table><tr><td>'),
    array('tag' => '#content tr.odd td', 'id' => 'css_cnt_tr-td-odd', 'info' =>'<table><tr><td> odd rows'),
    array('tag' => '#content tr.even td', 'id' => 'css_cnt_', 'info' =>'<table><tr><td> even rows'),

    array('tag' => '#content .attachment-thumbnail', 'id' => 'css_con_att_thumb', 'info' =>'Page/Post attachment thumbnail'),
    array('tag' => '#content .attachment-thumbnail-single', 'id' => 'css_con_att_thumb_single', 'info' =>'Page/Post attachment - single'),
    array('tag' => '#entry-author-info', 'id' => 'css_con_author_info', 'info' =>'Author Information'),
    array('tag' => '#entry-author-info #author-avatar', 'id' => 'css_con__auth_avatar', 'info' =>'Page/Post Author Avatar'),
    array('tag' => 'entry-author-info #author-description', 'id' => 'css_con_auth_desc', 'info' =>'Page/Post Author Description'),
    array('tag' => '#entry-author-info h2', 'id' => 'css_con_auth_h2', 'info' =>'Page/Post Author Info Title'),
    array('tag' => '#content .video-player', 'id' => 'css_con_video', 'info' =>'Page/Post Video Player'),
    array('tag' => '#content .entry-content img.avatar', 'id' => 'css_con_img_avatar', 'info' =>'Page/Post avatar img'),



    array('tag' => 'POST SPECIFIC CONTENT', 'id' => '_post_content', 'info' =>'Styling affecting just post content'),
    array('tag' => '.entry-meta', 'id' => 'css_entry_meta', 'info' =>'Post Top Information Line'),
    array('tag' => '.entry-utility', 'id' => 'css_entry_utility', 'info' =>'Post Bottom Information Line'),
    array('tag' => '.entry-format', 'id' => 'css_entry_format', 'info' =>'Post Format Pre-title'),
    array('tag' => '.entry-title a:link', 'id' => 'css_con_alink', 'info' =>'Page/Post link'),
    array('tag' => '.entry-title a:visited', 'id' => 'css_con_avisited', 'info' =>'Page/Post visited link'),
    array('tag' => '.entry-title a:active', 'id' => 'css_con_aactive', 'info' =>'Page/Post active link'),
    array('tag' => '.entry-title a:hover', 'id' => 'css_con_ahover', 'info' =>'Page/Post hover link'),
    array('tag' => ".home .sticky, #container.page-with-posts .sticky", 'id' => 'css_sticky', 'info' =>'Sticky Posts'),
    array('tag' => '#nav-above', 'id' => 'css_con_nav_above', 'info' =>'Links to previous and next posts - top of page'),
    array('tag' => '#nav-below', 'id' => 'css_con_nav_below', 'info' =>'Links to previous and next posts - bottom of page'),
    array('tag' => '#content vcard', 'id' => 'css_con_vcard', 'info' =>'Author info'),

    array('tag' => '.page-link', 'id' => 'css_page_link', 'info' =>'Page-links for paginated posts'),



    array('tag' => 'FOOTER', 'id' => '_footer', 'info' =>'Footer'),
    array('tag' => '#site-ig-wrap', 'id' => 'css_siteigwrap', 'info' =>'Wraps Info and Generator divs'),
    array('tag' => '#site-info', 'id' => 'css_siteinfo', 'info' =>'Auto generated site copyright info'),
    array('tag' => '#site-info a', 'id' => 'css_siteinfo_a', 'info' =>'#site-info <a>'),
    array('tag' => '#site-generator', 'id' => 'css_sitegenerator', 'info' =>'Powered by part'),
    array('tag' => '#site-generator a', 'id' => 'css_sitegenerator_a', 'info' =>'Powered by part <a>'),




    array('tag' => 'ARCHIVE PAGES', 'id' => '_archive_pages', 'info' =>'Archive pages: archives, categories, author, etc.'),
    array('tag' => '.page-title', 'id' => 'css_page_title', 'info' =>'Page Title'),
    array('tag' => '.page-title span', 'id' => 'css_page_title_span', 'info' =>'Page Title sub field'),
    array('tag' => '.page-title a:link', 'id' => 'css_page_title_alink', 'info' =>'Link'),
    array('tag' => '.page-title a:visited', 'id' => 'css_page_title_visited', 'info' =>'Visited'),
    array('tag' => '.page-title a:active', 'id' => 'css_page_title_aactive', 'info' =>'Active'),
    array('tag' => '.page-title a:hover', 'id' => 'css_page_title_ahover', 'info' =>'Hover'),



    array('tag' => 'IMAGES', 'id' => '_comments', 'info' =>'Images in #content areas'),
    array('tag' => '.entry-content img,.comment-content img,.widget img', 'id' => 'css_ent_img', 'info' =>'.entry-content img,.comment-content img,.widget img'),
    array('tag' => '.size-full', 'id' => 'css_size-full', 'info' =>'img.size-full - image borders'),
    array('tag' => '.size-large', 'id' => 'css_size-large', 'info' =>'size-large - image borders'),
    array('tag' => '.size-medium', 'id' => 'css_size-medium', 'info' =>'.size-medium - image borders'),
    array('tag' => '.size-thumbnail', 'id' => 'css_size-thumbnail', 'info' =>'.size-thumbnail - image borders'),
    array('tag' => '.gallery img', 'id' => 'css_galleryimg', 'info' =>'.gallery img - image borders'),
    array('tag' => '.gallery-thumb img', 'id' => 'css_gallery-thumbimg', 'info' =>'.gallery-thumb img - image borders'),


    array('tag' => 'img.wp-smiley', 'id' => 'css_wp-smiley', 'info' =>'img.wp-smiley'),
    array('tag' => '.wp-caption', 'id' => 'css_wp-caption', 'info' =>'.wp-caption'),
    array('tag' => '.wp-caption img', 'id' => 'css_wp-captionimg', 'info' =>'.wp-caption img'),
    array('tag' => '.wp-caption .wp-caption-text', 'id' => 'css_wp-cap-txt', 'info' =>'.wp-caption .wp-caption-text'),
    array('tag' => '.gallery-caption', 'id' => 'css_gal-capt', 'info' =>'.gallery-caption'),
    array('tag' => '#content img', 'id' => 'css_cont_img', 'info' =>'#content img - shadows'),
    array('tag' => '#content .attachment img', 'id' => 'css_cont_att_img', 'info' =>'#content .attachment img'),
    array('tag' => '#content .attachment-thumbnail', 'id' => 'css_con-att-thumb', 'info' =>'#content .attachment-thumbnail'),
    array('tag' => '#content .attachment-thumbnail-single', 'id' => 'css_con-att-th-sing', 'info' =>'#content .attachment-thumbnail-single'),


    array('tag' => 'WIDGET AREAS', 'id' => '_widgets', 'info' =>'Widget areas and Widgets'),
    array('tag' => '#sidebar_header', 'id' => 'css_sideheader', 'info' =>'Horizontal Header Widget Area'),
    array('tag' => '#header_widget_table', 'id' => 'css_sideheader', 'info' =>'Table that contains Horizontal Header Widgets'),
    array('tag' => '.header-widget', 'id' => 'css_sideheader', 'info' =>'Widgets in the Header Widget Area'),


    array('tag' => '#sidebar_primary', 'id' => 'css_sideleft', 'info' =>'Primary (top) Sidebar'),
    array('tag' => '#sidebar_right', 'id' => 'css_sideright', 'info' =>'Upper/Right Sidebar'),
    array('tag' => '#sidebar_left', 'id' => 'css_sideleft', 'info' =>'Lower/Right Sidebar'),
    array('tag' => '#sidebar_wrap_left', 'id' => 'css_sidebar_wrap_left', 'info' =>'Wraps all left sidebar widget areas'),
    array('tag' => '#sidebar_wrap_right', 'id' => 'css_sidebar_wrap_right', 'info' =>'Wraps all right sidebar widget areas'),

    array('tag' => '#sidebar_wrap_footer', 'id' => 'css_footer_widgets', 'info' =>'Wraps all footer widget areas'),
    array('tag' => '.widget-in-footer', 'id' => 'css_footer_widgets_widget', 'info' =>'Widget areas within footer'),
    array('tag' => '#first', 'id' => 'css_firstw', 'info' =>'First footer widget area'),
    array('tag' => '#second', 'id' => 'css_secondw', 'info' =>'Second footer widget area'),
    array('tag' => '#third', 'id' => 'css_thirdw', 'info' =>'Third footer widget area'),
    array('tag' => '#fourth', 'id' => 'css_fourthw', 'info' =>'Fourth footer widget area'),
    array('tag' => '.sidebar_top,.sidebar_extra', 'id' => 'css_ttw_sidetop_w', 'info' =>'All Weaver top widget areas.'),
    array('tag' => '#sitewide-top-widget-area', 'id' => 'css_ttw_sitetop_w', 'info' =>'Weaver sitewide top widget area'),
    array('tag' => '#top-widget-area', 'id' => 'css_ttw_top_w', 'info' =>'Weaver top widget area'),
    array('tag' => '#blog-top-widget-area', 'id' => 'css_ttw_blogtop_w', 'info' =>'Weaver top widget area'),
    array('tag' => '#bottom-widget-area', 'id' => 'css_ttw_bot_w', 'info' =>'Weaver bottom widget area'),
    array('tag' => '.sidebar_bottom', 'id' => 'css_ttw_sidebottom_w', 'info' =>'All Weaver bottom widget areas.'),
    array('tag' => '#blog-bottom-widget-area', 'id' => 'css_ttw_blogbot_w', 'info' =>'Weaver bottom widget area'),
    array('tag' => '#sitewide-bottom-widget-area', 'id' => 'css_ttw_sitebot_w', 'info' =>'Weaver sitewide bottom widget area'),

    array('tag' => '.widget_search #s', 'id' => 'css_wdg_search-s', 'info' =>'.widget_search #s'),
    array('tag' => '.widget_search label', 'id' => 'css_wdg_search-label', 'info' =>'.widget_search label'),
    array('tag' => '.widget-area', 'id' => 'css_wdg_area', 'info' =>'.widget-area'),
    array('tag' => '.widget-title', 'id' => 'css_wdg_title', 'info' =>'.widget-title'),
    array('tag' => '.widget-area .entry-meta', 'id' => 'css_wdg_entry-meta', 'info' =>'.widget-area .entry-meta'),
    array('tag' => '.widget-area ul', 'id' => 'css_wdg_ul', 'info' =>'.widget-area ul'),
    array('tag' => '.widget-area ul ul', 'id' => 'css_wdg_ulul', 'info' =>'.widget-area ul ul'),
    array('tag' => '.wp_tag_cloud div', 'id' => 'css_wdg_tagdiv', 'info' =>'#wp_tag_cloud div'),
    array('tag' => '#wp-calendar', 'id' => 'css_wdg_cal', 'info' =>'#wp-calendar'),
    array('tag' => '#wp-calendar #today', 'id' => 'css_wdg_cal_today', 'info' =>'Today\'s date'),
    array('tag' => '#wp-calendar caption', 'id' => 'css_wdg_calcap', 'info' =>'#wp-calendar caption'),
    array('tag' => '#wp-calendar thead', 'id' => 'css_wdg_calthead', 'info' =>'#wp-calendar thead'),
    array('tag' => '#wp-calendar thead th', 'id' => 'css_wdg_caltheadth', 'info' =>'#wp-calendar thead th'),
    array('tag' => '#wp-calendar tbody', 'id' => 'css_wdg_caltbody', 'info' =>'#wp-calendar tbody'),
    array('tag' => '#wp-calendar tbody td', 'id' => 'css_wdg_caltbodytd', 'info' =>'#wp-calendar tbody td'),
    array('tag' => '#wp-calendar tbody .pad', 'id' => 'css_wdg_caltbodypad', 'info' =>'#wp-calendar tbody .pad'),
    array('tag' => '#wp-calendar tfoot #next', 'id' => 'css_wdg_caltfootnet', 'info' =>'#wp-calendar tfoot #next'),
    array('tag' => '#wp-calendar a', 'id' => 'css_wdg_cal-a', 'info' =>'#wp-calendar a'),
    array('tag' => '#main .widget-area ul', 'id' => 'css_wdg_main-ul', 'info' =>'#main .widget-area ul'),
    array('tag' => '#main .widget-area ul ul', 'id' => 'css_wdg_main-ulul', 'info' =>'#main .widget-area ul ul'),



array('tag' => 'MISC', 'id' => '_misc', 'info' =>'Other rules that don\'t fit elsewhere'),
    array('tag' => '.wvr-show-posts', 'id' => 'css_wvr-show-posts', 'info' =>'For [weaver_show_posts] shortcode'),
    array('tag' => '.wvr-show-posts .hentry', 'id' => 'css_wvr-show-posts-hentry', 'info' =>'For [weaver_show_posts] shortcode'),
    array('tag' => '.widget-area .wvr-show-posts .hentry', 'id' => 'css_wid-wvr-show-posts-hentry', 'info' =>'For [weaver_show_posts] shortcode'),
    array('tag' => '.widget-area .wvr-show-posts .entry-title', 'id' => 'css_wid-wvr-show-posts-entry-title', 'info' =>'For [weaver_show_posts] shortcode'),
    array('tag' => '.widget-area .wvr-show-posts .attachment-thumbnail', 'id' => 'css_wid-wvr-show-posts-attch', 'info' =>'For [weaver_show_posts] shortcode'),

    array('tag' => '.attachment .entry-content .entry-caption', 'id' => 'css_att-capt', 'info' =>'For Attachment display pages'),
    array('tag' => '.attachment .entry-content .nav-previous a:before', 'id' => 'css_att-capt-abefore', 'info' =>'For Attachment display pages'),
    array('tag' => '.attachment .entry-content .nav-previous a:before', 'id' => 'css_att-capt-aafter', 'info' =>'For Attachment display pages')

);
}

function weaveriip_totalcss_init() {
    weaverii_pro_setopt('wvp_css',true);
    weaverii_pro_update_options('cssadmin');
}

function weaveriip_save_totalcss() {
    global $weaveriip_totalcss_checkbox_opts, $weaveriip_totalcss_text_opts, $weaveriip_totalcss_bg_opts;
    /* Save options from plus header: wvrx_plus_save_posts */

    if (!weaverii_pro_isset('wvp_css')) weaveriip_totalcss_init();
    if (isset($_POST['css_edit_lines'])) {
	$value = weaverii_filter_code($_POST['css_edit_lines']);
	if (!empty($value) && (!is_numeric($value) || !is_int((int)$value)))
	    $value = 1;
	if ($value < 1 || $value > 25)
	    $value = 1;
	weaverii_pro_setopt('css_edit_lines', $value);
    }
    global $weaveriip_css;
    foreach ($weaveriip_css as $option => $val) {
	if (isset($_POST[$val['id']]) && $_POST[$val['id']] != '' &&  $_POST[$val['id']] != '{}') {
	    $css = weaverii_filter_code($_POST[$val['id']]);
	    $css = weaveriip_bracket($css,'{', '}');
	    weaverii_pro_setopt($val['id'], $css);
	} else {
	    weaverii_pro_setopt($val['id'], false);
	}
    }

    weaverii_pro_update_options('save_totalcss');

    /* and let the user know something happened */
    echo '<div id="message" class="updated fade"><p><strong>Weaver II Pro More Options Saved</strong></p></div>';
}

function weaveriip_totalcss_output_style($sout) {

    if (!weaverii_pro_isset('wvp_css')) weaveriip_totalcss_init();

    weaverii_f_write($sout,"/* Weaver II Pro Total CSS */\n");

    global $weaveriip_css;
    foreach ($weaveriip_css as $option => $val) {
	$css = weaverii_pro_getopt($val['id']);
	if ($css) {
	    weaverii_f_write($sout,$val['tag'] . $css . "\n");
	}
    }
}
?>
