<?php
function weaverii_convert_old_weaver() {
    /* convert existing Weaver 2.2 options from DB to current settings */
if (true) {
    // no leading char means exact direct conversoin
    // leading ! means n/a
    // leading * means extra conversion processing required
    // leading ^ means widget area conversion - give only one notice
    // leading # means manual conversion required
    // leading - means internal value - no report required
    $convert_list = array (     // main opts list - false means not per-site option (i.e., it is a theme option)
    'ttw_after_header' => 'wii_after_header_int|Space After Header',
    'ttw_allow_attachment_comments' => 'wii_after_header_int|Allow comments for attachments',
    'ttw_always_excerpt' => 'wii_excerpt_blog|Display posts as excerpts',
    'ttw_always_fullpost' =>'wii_fullpost_archive|Display full posts',
    'ttw_body_bgcolor' => 'wii_body_bgcolor|Outside BG',
    'ttw_body_bgcolor_css' => 'wii_body_bgcolor_css|Outside BG',
    'ttw_bold_menu' => 'wii_bold_menu|Bold Menu Text',
    'ttw_border_adjust_sidebar' => '!No_longer_needed_by_Weaver_II|Sidebar Border Adjust',
    'ttw_caption_color' => 'wii_caption_color|Caption text color',
    'ttw_caption_color_css' => 'wii_caption_color_css|Caption text color',
    'ttw_container_bgcolor' => 'wii_container_bgcolor|Container Area BG',
    'ttw_container_bgcolor_css' => 'wii_container_bgcolor_css|Container Area BG',
    'ttw_content_bgcolor' => 'wii_content_bgcolor|Content BG',
    'ttw_content_bgcolor_css' => 'wii_content_bgcolor_css|Content BG',
    'ttw_content_color' => '*wii_content_color|Content text',
    'ttw_content_color_css' => 'wii_content_color_css|Content text',
    'ttw_content_font' => '*wii_content_font|Content Font',
    'ttw_contentlist_bullet' => '*wii_contentlist_bullet|Content List Bullet',
    'ttw_desc_color' => 'wii_desc_color|Site Description',
    'ttw_desc_color_css' => 'wii_desc_color_css|Site Description',
    'ttw_excerpt_length' => 'wii_excerpt_length|Excerpt length',
    'ttw_excerpt_more_msg' => 'wii_excerpt_more_msg|<em>Continue reading</em> Message',
    'ttw_fadebody_bg' => 'wii_fadebody_bg|Fade Outside BG',
    'ttw_footer_bgcolor' => 'wii_footer_bgcolor|Footer BG',
    'ttw_footer_bgcolor_css' => 'wii_footer_bgcolor_css|Footer BG',
    'ttw_footer_border_color' => 'wii_border_color|Footer Border',
    'ttw_footer_border_color_css' => 'wii_footer_border_color_css|Footer Border',
    'ttw_footer_widget_bgcolor' => 'wii_footer_widget_bgcolor|Footer Widget Areas BG',
    'ttw_footer_widget_bgcolor_css' => 'wii_footer_widget_bgcolor_css|Footer Widget Areas BG',
    'ttw_footer_widget_count' => '!No_longer_needed_by_Weaver_II._Footer_widgets_automatically_spaced.|Horizontal Footer Widget Area Blocks',
    'ttw_footer_last' => 'wii_footer_last|Footer &lt;div> Last',
    'ttw_force_widg_frontpage' => '!No_longer_needed_by_Weaver_II._New_top/bottom_widgets_available.|Always Show Top/Bottom widget area on front page',
    'ttw_gradient_menu' => 'wii_gradient_menu|Menu Bar Gradient',
    'ttw_use_superfish' => 'wii_use_superfish|Use Menu Effects',
    'ttw_header_bgcolor' => 'wii_header_bgcolor|Header BG',
    'ttw_header_bgcolor_css' => 'wii_header_bgcolor_css|Header BG',
    'ttw_header_image_height' => 'wii_header_image_height_int|Header Image Height',
    'ttw_header_image_width' => '*wii_header_image_width_int|Theme Width',
    'ttw_site_margins' => '*wii_site_margins|Theme Margin',
    'ttw_header_underline' => 'wii_header_underline_int|Bar under Titles',
    'ttw_header_first' => 'wii_header_first|Header &lt;div> First',
    'ttw_hide_author_bio' => 'wii_hide_author_bio|Hide Author Bio',
    'ttw_hide_comments_closed' => '*wii_show_comments_closed|Hide <em>Comments Off</em>',
    'ttw_hide_footer' => 'wii_hide_footer|Hide Entire Footer',
    'ttw_hide_menu' => 'wii_hide_menu|Hide Menu Bars',
    'ttw_hide_featured_header' => 'wii_hide_featured_header|Hide Featured Image for Header',
    'ttw_hide_page_featured' => 'wii_hide_page_featured|Hide Featured Image for Pages',
    'ttw_hide_post_fill' => 'wii_post_icons|Hide Post Info Fill-in',
    'ttw_hide_singleton_cat' => 'wii_hide_singleton_cat|Hide Category if Only One',
    'ttw_hide_single_sidebars' => '^Use_New_Per_Page_Layout|Hide Sidebars on Single Post',
    'ttw_hide_special_post_sidebars' => '^Use_Weaver_Pro_Layout_Options|Hide Sidebars on Special Post pages',
    'ttw_hide_site_title' => 'wii_hide_site_title|Hide Site Title/Description',
    'ttw_hide_special_posts' => '^Use_Weaver_Pro_Layout_Options|Hide Special Post Pages widget area',
    'ttw_hide_widg_pages' => '^Use_New_Widget_Areas|Hide Top/Bottom widget area in pages',
    'ttw_hide_widg_posts' => '^Use_New_Widget_Areas|Hide Top/Bottom widget area in blog',
    'ttw_hr_color' => 'wii_hr_color|&lt;HR&gt; color',
    'ttw_hr_color_css' => 'wii_hr_color_css|&lt;HR&gt; color',
    'ttw_ilink_color' => 'wii_ilink_color|Post Info Link',
    'ttw_ilink_color_css' => 'wii_ilink_color_css|Post Info Link',
    'ttw_ilink_hover_color' => 'wii_ilink_hover_color|Post Info Link Hover',
    'ttw_ilink_hover_color_css' => 'wii_ilink_hover_color_css|Post Info Link Hover',
    'ttw_ilink_visited_color' => 'wii_ilink_visited_color|Post Info Link Visited',
    'ttw_ilink_visited_color_css' => 'wii_ilink_visited_color_css|Post Info Link Visited',
    'ttw_info_color' => 'wii_info_color|Post Info text',
    'ttw_info_color_css' => 'wii_info_color_css|Post Info text',
    'ttw_infotop_bgcolor' => 'wii_infotop_bgcolor|Top Post Info BG',
    'ttw_infotop_bgcolor_css' => 'wii_infotop_bgcolor_css|Top Post Info BG',
    'ttw_infobottom_bgcolor' => 'wii_infobottom_bgcolor|Bottom Post Info BG',
    'ttw_infobottom_bgcolor_css' => 'wii_infobottom_bgcolor_css|Bottom Post Info BG',
    'ttw_input_bgcolor' => 'wii_input_bgcolor|Input Area BG',
    'ttw_input_bgcolor_css' => 'wii_input_bgcolor_css|Input Area BG',
    'ttw_large_tagline' => '*wii_desc_font_size|Larger Site Description',
    'ttw_link_color' => 'wii_link_color|Standard Link',
    'ttw_link_color_css' => 'wii_link_color_css|Standard Link',
    'ttw_link_hover_color' => 'wii_link_hover_color|Standard Link Hover',
    'ttw_link_hover_color_css' => 'wii_link_hover_color_css|Standard Link Hover',
    'ttw_link_visited_color' => 'wii_link_visited_color|Standard Link Visited',
    'ttw_link_visited_color_css' => 'wii_link_visited_color_css|Standard Link Visited',
    'ttw_link_site_image' => 'wii_link_site_image|Header Image Links to Site',
    'ttw_list_bullet' => '*wii_list_bullet|Widget List Bullet',
    'ttw_main_bgcolor' => 'wii_main_bgcolor|Main Area BG',
    'ttw_main_bgcolor_css' => 'wii_main_bgcolor_css|Main Area BG',
    'ttw_media_lib_border' => 'wii_media_lib_border_color|Non-Captioned Image Border Color',
    'ttw_media_lib_border_css' => 'wii_media_lib_border_color_css|Non-Captioned Image Border Color',
    'ttw_media_lib_captioned_border' => '!Captioned_image_borders_no_longer_available|Captioned Image Border Color',
    'ttw_media_lib_captioned_border_css' => '!Captioned_image_borders_no_longer_available|Captioned Image Border Color',
    'ttw_menu_addsearch' => 'wii_menu_addsearch|Add Search to Menu Bar',
    'ttw_menu_addlogin' => 'wii_menu_addlogin|Add Log in to Menu Bar',
    'ttw_menu_nohome' => 'wii_|No Home Menu Item',
    'ttw_menubar_color' => '*wii_menubar_bgcolor|Menu Bar',
    'ttw_menubar_color_css' => '*wii_menubar_bgcolor_css|Menu Bar',
    'ttw_menubar_curpage_color' => 'wii_menubar_curpage_color|Menu Bar current page',
    'ttw_menubar_curpage_color_css' => 'wii_menubar_curpage_color_css|Menu Bar current page',
    'ttw_menubar_hover_color' => '*wii_menubar_hover_color|Menu Bar text hover',
    'ttw_menubar_hover_color_css' => '*wii_menubar_hover_color_css|Menu Bar text hover',
    'ttw_menubar_hoverbg_color' => '*wii_menubar_hover_bgcolor|Menu Bar hover BG',
    'ttw_menubar_hoverbg_color_css' => '*wii_menubar_hover_bgcolor_css|Menu Bar hover BG',
    'ttw_menubar_text_color' => '*wii_menubar_text_color|Menu Bar text',
    'ttw_menubar_text_color_css' => '*wii_menubar_text_color_css|Menu Bar text',
    'ttw_move_menu' => 'wii_move_menu|Move Primary Menu to Top',
    'ttw_page_bgcolor' => 'wii_page_bgcolor|Wrapper Page BG',
    'ttw_page_bgcolor_css' => 'wii_page_bgcolor_css|xxx',
    'ttw_page_title_color' => 'wii_page_title_color|Page Title Text',
    'ttw_page_title_color_css' => 'wii_page_title_color_css|Page Title Text',
    'ttw_plink_color' => 'wii_plink_color|Post Entry Title Link',
    'ttw_plink_color_css' => 'wii_plink_color_css|Post Entry Title Link',
    'ttw_plink_hover_color' => 'wii_ttw_plink_hover_color|Post Entry Title Link Hover',
    'ttw_plink_hover_color_css' => 'wii_plink_hover_color_css|Post Entry Title Link Hover',
    'ttw_plink_visited_color' => 'wii_plink_visited_color|Post Entry Title Link Visited',
    'ttw_plink_visited_color_css' => 'wii_plink_visited_color_css|Post Entry Title Link Visited',
    'ttw_post_hide_date' => 'wii_post_hide_date|Hide Post Date',
    'ttw_post_hide_author' => 'wii_post_hide_author|Hide Post Author',
    'ttw_post_hide_cats'=> 'wii_post_hide_cats|Hide Post Category, Tags',
    'ttw_post_bgcolor' => 'wii_post_bgcolor|xxx',
    'ttw_post_bgcolor_css' => 'wii_post_bgcolor_css|xxx',
    'ttw_post_icons' => 'wii_post_icons|Use Icons in Post Info',
    'ttw_post_title_color' => 'wii_plink|Post Format Title',
    'ttw_post_title_color_css' => 'wii_plink_css|Post Format Title',
    'ttw_rounded_corners' => 'wii_rounded_corners|Rounded Corners',
    'ttw_rounded_corners_radius' => 'wii_rounded_corners_radius|Corner Radius',
    'ttw_show_featured_image_excerptedposts' => 'wii_show_featured_image_excerptedposts|Show the Featured Image for excerpted posts',
    'ttw_show_featured_image_fullposts' => 'wii_show_featured_image_fullposts|Show Featured Image for full posts',
    'ttw_show_post_avatar' => 'wii_show_post_avatar|Show avatar with posts',
    'ttw_show_tiny_avatar' => 'wii_show_tiny_avatar|Make avatar tiny',
    'ttw_side1_bgcolor' => '*wii_widget_primary_bgcolor|Primary Widget Area BG',
    'ttw_side1_bgcolor_css' => '*wii_widget_primary_bgcolor_css|Primary Widget Area BG',
    'ttw_side2_bgcolor' => 'wii_widget_right_bgcolor|Secondary Widget Area BG',
    'ttw_side2_bgcolor_css' => 'wii_widget_right_bgcolor_css|Secondary Widget Area BG',
    'ttw_side3_bgcolor' => '^Alt_Widget_Area_Not_Available._Use_New_Widget_Area_Options.|Alt Template Widget Area BG',
    'ttw_side3_bgcolor_css' => '^Alt_Widget_Area_Not_Available._Use_New_Widget_Area_Options.|Alt Template Widget Area BG',
    'ttw_sidebar_width' => '^Please_set_new_sidebar_widths_manaully|Sidebar Width',
    'ttw_sidebars' => '^Please_select_new_style_sidebars_manually|Main Sidebar Columns',
    'ttw_small_content_font' => '#Option_no_longer_available._Use_Fonts:_Site_Base_Font_Size|Smaller Content Font',
    'ttw_stickypost_bgcolor' => 'wii_stickypost_bgcolor|Sticky Post BG',
    'ttw_stickypost_bgcolor_css' => 'wii_stickypost_bgcolor_css|Sticky Post BG',
    'ttw_text_color' => 'wii_content_headings_color|Heading text',
    'ttw_text_color_css' => 'wii_content_headings_color_css|Heading text',
    'ttw_title_color' => 'wii_title_color|Site Title',
    'ttw_title_color_css' => 'wii_title_color_css|Site Title',
    'ttw_title_font' => '*wii_title_font|Titles Font',
    'ttw_title_on_header' => 'wii_title_on_header|Move Title over Header Image',
    'ttw_title_on_header_xy_X' => 'wii_title_on_header_xy_X|Move Title over Header Image',
    'ttw_title_on_header_xy_Y' => 'wii_title_on_header_xy_Y|Move Title over Header Image',
    'ttw_title_on_header_xy_desc_X' => 'wii_title_on_header_xy_desc_X|Move Title over Header Image',
    'ttw_title_on_header_xy_desc_Y' => 'wii_title_on_header_xy_desc_Y|Move Title over Header Image',
    'ttw_topbottom_bgcolor' => '*wii_widget_top_bgcolor|Top/Bottom Widget Areas BG',
    'ttw_topbottom_bgcolor_css' => '*wii_widget_top_bgcolor_css|Top/Bottom Widget Areas BG',
    'ttw_useborders' => 'wii_useborders|Area Border',
    'ttw_useborders_topbot' => '*wii_widget_top_std_border|Area Border on Top/Bottom widget areas',
    'ttw_weaver_tables' => '*wii_weaverii_tables|Table Style',
    'ttw_wide_top_bottom' => '#Please_use_new_widget_area_left/right_indent|Full Width Top/Bottom widget areas',
    'ttw_widget_color' => 'wii_widget_color|Widget Area Text',
    'ttw_widget_color_css' => 'wii_widget_color_css|Widget Area Text',
    'ttw_widget_header_underline' => 'wii_widget_header_underline_int|Bar under Widget Titles',
    'ttw_widget_item_bgcolor' => 'wii_widget_widget_bgcolor|Individual Widget BG',
    'ttw_widget_item_bgcolor_css' => 'wii_widget_widget_bgcolor_css|Individual Widget BG',
    'ttw_widget_title_color' => 'wii_widget_title_color|Widget Title',
    'ttw_widget_title_color_css' => 'wii_widget_title_color_css|Widget Title',
    'ttw_wlink_color' => 'wii_wlink_color|Widget Link',
    'ttw_wlink_color_css' => 'wii_wlink_color_css|Widget Link',
    'ttw_wlink_hover_color' => 'wii_wlink_hover_color|Widget Link Hover',
    'ttw_wlink_hover_color_css' => 'wii_wlink_hover_color_css|Widget Link Hover',
    'ttw_wlink_visited_color' => 'wii_wlink_visited_color|Widget Link Visited',
    'ttw_wlink_visited_color_css' => 'wii_wlink_visited_color_css|Widget Link Visited',
    'ttw_wrap_shadow' => 'wii_wrap_shadow||Wrap site with shadow',			// Wrap site with shadow

    'ttw_footer_opts' => 'wii_footer_insert|insert into footer',
    'ttw_head_opts' => '*wii_head_opts|<HEAD> Section',
    'ttw_add_css'=> '*wii_add_css|Add CSS Rules to Weaver\'s style rules',
    'ttw_preheader_insert' => 'wii_preheader_insert|Pre-Header Code',
    'ttw_hide_front_preheader' => 'wii_hide_front_preheader|xxx',
    'ttw_hide_rest_preheader' => 'wii_hide_rest_preheader|xxx',
    'ttw_header_insert' => 'wii_header_insert|Site Header Insert Code',
    'ttw_custom_header_insert' => '!Not_ready_wii_|Custom Header Page Template Code',
    'ttw_header_frontpage_only' => '#Option_changed._Please_manually_set_new_values.|Show Header Insert on Front Page Only',
    'ttw_postheader_insert' => 'wii_premain_insert|Post-Header Code',
    'ttw_hide_front_postheader' => 'wii_hide_front_premain|xxx',
    'ttw_hide_rest_postheader' => 'wii_hide_rest_premain|xxx',
    'ttw_prefooter_insert' => 'wii_prefooter_insert|Pre-Footer Code',
    'ttw_hide_front_prefooter' => 'wii_hide_front_prefooter|xxx',
    'ttw_hide_rest_prefooter' => 'wii_hide_rest_prefooter|xxx',
    'ttw_postfooter_insert' => 'wii_postfooter_insert|Post-Footer Code',
    'ttw_hide_front_postfooter' => 'wii_hide_front_postfooter|xxx',
    'ttw_hide_rest_postfooter' => 'wii_hide_rest_postfooter|xxx',
    'ttw_presidebar_insert' => 'wii_presidebar_left_insert|Pre-Sidebar Code',
    'ttw_hide_front_presidebar' => 'wii_hide_front_presidebar_left|xxx',
    'ttw_hide_rest_presidebar' => 'wii_hide_rest_presidebar_left|xxx',
    'ttw_hide_PIE' => '_wii_hide_PIE|Don\'t use PIE IE extension',
    'ttw_menu_addhtml-left' => 'wii_menu_addhtml-left|add html to left menu',
    'ttw_menu_addhtml' => 'wii_menu_addhtml|add html to right menu',
    'ttw_notab_mainoptions' => '!Not_supported|no tabs on main options',
    'ttw_perpagewidgets' => 'wii_perpagewidgets|Add widget areas for per page',
    'ttw_hide_auto_css_rules' => '_wii_hide_auto_css_rules|Don\'t auto-display CSS rules',
    'ttw_css_rows' => '_wii_css_rows|expand # CSS+ rows',
    'ttw_force_inline_css'=>'_wii_inline_style|Use Inline CSS',
    'ttw_copyright' => '_wii_copyright|Alternate copyright',
    'ttw_hide_poweredby' => '_wii_hide_poweredby|Hide powered by',
    'ttw_end_opts' => 'wii_postfooter|The Last Thing',
    'ttw_metainfo'=>'#Please_manually_add_to_Advanced_Options:_SEO_Tags|meta info for header',
    'ttw_hide_metainfo'=>'_wii_hide_metainfo|Use SEO Plugin',
    'ttw_hide_theme_thumbs'=>'_wii_hide_theme_thumbs|Hide thumbs on admin screen',
    'ttw_show_preview'=>'!Not_supported|show the preview box',
    'ttw_hide_updatemsg'=>'!Not_supported|hide the version update message',
    'ttw_hide_editor_style' => '_wii_hide_editor_style|disable editor styling',
    'ttw_theme_head_opts' => '*wii_add_theme_css|Predefined Theme CSS Rules',
    'wvr_hide_if_are_oldWeaver_opts' => '!Not_supported_wii_|show if old options to import',
    'ftp_hostname' => '!Not_supported|FTP Host Name',
    'ftp_username' => '!Not_suppoted|FTP User Name',
    'ftp_password' => '!Not_suppoted|FTP Password',
    'ftp_hide_check_message' => '!Not_supported|Disable FTP',


       /* plus current subtheme 0 non-sapi */
    'ttw_subtheme' => 'wii_subtheme|Subtheme name',
    'ttw_theme_image' =>'-Np_longer_needed_by_Weaver_II|image name not used',
    'ttw_theme_description' => 'wii_theme_description|Theme Description',
    'ttw_themename' => 'wii_themename|theme name',
    'ttw_version_id'=>'-No_longer_needed_by_Weaver_II|version is not per-site',
    'ttw_style_version'=>'-No_longer_needed_by_Weaver_II|Style Version',
    'ttw_last_advanced'=> '-No_longer_needed_by_Weaver_II'
    );
}

// Weaver Plus
if (true) {
    $wvp_ignore = array(
    'wvp_sitetitle_size','wvp_sitedesc_size', 'wvp_post_single_hidehtml','wvp_post_blog_hidehtml','wvp_site_fontsize',
    'wvp_post_pretitle','wvp_post_prebody','wvp_post_postbody'
    );

    // change wvp_ to wii_, add to weaver opts
    $wvp_to_wii_opts = array(
    'wvp_post_info_move_top', 'wvp_post_info_move_bottom', 'wvp_post_info_hide_top', 'wvp_post_info_hide_bottom',
    'wvp_hide_prevnext', 'wvp_post_no_titlelink', 'wvp_entrytitle_size', 'wvp_featured_blog_width', 'wvp_featured_single_width',
    'wvp_hide_p_category','wvp_hide_p_tag','wvp_hide_p_date','wvp_hide_p_search','wvp_hide_tooltip'
    );
}

    $old_main = get_option('weaver_main_settings');
    if (empty($old_main)) {
	weaverii_error_msg("Previous Version of Weaver not available to convert.");
	return;
    }
    $old_adv = get_option('weaver_advanced_settings');
    if (empty($old_adv)) {
	weaverii_error_msg("Previous Version of Weaver not available to convert.");
	return;
    }

    $old = array_merge($old_main,$old_adv);

    $converted = 0;
    $skipped = 0;
    $special = 0;
    $notes = 0;
    $manual = 0;
    $errors = 0;
    $need_widget_notice = false;
    $css_found = false;

    global $weaverii_opts_cache;
    $weaverii_opts_cache = array();
    delete_option('weaverii_settings');
    echo "<div style=\"border: 4px ridge red; padding:8px; background:#f4f0f0;max-width:800px;\"><h3>Weaver to Weaver II Conversion Report ";
    weaverii_help_link('help.html#UpgradingWeaver','Help for Advanced Options');
    echo "</h3>
    <p style=\"font-weight:bold;color:blue;\">You may want to Copy/Paste this report into a new WordPress Private or Draft Page, or into a word processor page, for future reference.</p>";
    $sb_areas = array ('primary', 'right', 'left', 'top', 'bottom', 'footer', 'widget');
    foreach ($sb_areas as $val) {
	weaverii_setopt('wii_widget_' . $val . '_bgcolor', 'transparent',false);	// widget areas need to be transparent
    }

    foreach ($old as $opt => $val) {	// WEAVER settings
	if ($val  && isset($convert_list[$opt])) {
	    $cvt = $convert_list[$opt];
	    $new_name = strtok($cvt,'|');
	    $info = strtok('|');
	    $msg = substr(str_replace('_',' ',$new_name),1);

	    switch ($new_name[0]) {
	    case '!':
		$notes++;
		echo("<span class=\"wvr_yellow\">Conversion Notice:</span> <em>$info:</em> $msg<br >\n");
		break;
	    case '-':
		break;
	    case '#':
		$manual++;
		echo("<span class=\"wvr_red\">Manual conversion required:</span> <em>$info:</em> $msg<br >\n");
		break;
	    case '^':	// widget area
		if ($opt == 'ttw_sidebars') {	// we can sort of do this one
		    switch ($val) {
			case 'Default - One, right side':  //Default - One, right side
			    weaverii_setopt('wii_layout_default', 'right-1-col',false);
			    break;
			case 'One, wide right side':  //One, wide right side
			    weaverii_setopt('wii_layout_default', 'right-1-col',false);
			    $need_widget_notice = true;
			    break;
			case 'One, left side':  //One, left side
			    weaverii_setopt('wii_layout_default', 'left-1-col',false);
			    break;
			case 'Two, left and right sides':  //Two, left and right sides
			    weaverii_setopt('wii_layout_default', 'split',false);
			    break;
			case 'Two, unequal widths, right side':  //Two, unequal widths, right side
			    weaverii_setopt('wii_layout_default', 'right-2-col',false);
			    $need_widget_notice = true;
			    break;
			case 'Two, unequal widths, left side':  //Two, unequal widths, left side
			    weaverii_setopt('wii_layout_default', 'left-2-col',false);
			    $need_widget_notice = true;
			    break;
			case 'None':  //None
			    weaverii_setopt('wii_layout_default', 'one-column',false);
			    break;
			case 'Default - One, right side':  //Default - One, right side
			default:
			    weaverii_setopt('wii_layout_default', 'right-1-col',false);
			    break;
		    }
		    break;
		}
		$need_widget_notice = true;
		break;
	    case '*':	// special handling
		$special++;
		$converted++;
		$new_name = substr($new_name,1);
		switch ($new_name) {
		    case 'wii_add_css':
		    case 'wii_add_theme_css':
			$manual++;
			echo("<span class=\"wvr_red\">CSS Rules detected.</span> The following <em>$info</em>
have been added to Weaver II's <strong>Custom CSS Rules</strong>, but may require manual changes:
<br /><span style=\"padding-left:20px;\"><code>" . esc_textarea($val) . "</code></span><br />\n");
			$fixed = str_replace('<style>','',$val);
			$fixed = str_replace('<style type="text/css">','',$fixed);
			$fixed = str_replace('</style>', '',$fixed);
			$prev = weaverii_getopt('wii_add_css');
			if ($prev != '') $prev = $prev . "\n" . $fixed;
			else $prev = $fixed;
			weaverii_setopt('wii_add_css',$prev,false);
			if (strstr($fixed , '<style') !== false) {
			    echo ("<span class=\"wvr_red\">Warning - unmatched &lt;style&gt; found.</span> You will have to manually
				    convert the CSS in \"Custom CSS Rules\".\n");
			    $manual++;
			}

			break;
		    case 'wii_content_font':  // Content Font
		    case 'wii_title_font:':	//Titles Font
			echo("<span class=\"wvr_red\">Font settings detected.</span> You may have to manually adjust font selections.<br />\n");
			$manual++;
			break;
		    case 'wii_contentlist_bullet':  // Content List Bullet
		    case 'wii_list_bullet':  // Widget List Bullet
			if ($val != 'circle' && $val != 'disc' && $val != 'square') {
			    $oldval = $val;
			    $val = 'disc';
			    if ($oldval != 'default')
			    echo("<span class=\"wvr_red\">Additional manual conversion may be required for list bullet:</span> <em>$info:
<br /><span style=\"padding-left:20px;\">" . esc_textarea($oldval) . "</span><br />\n");
			    $manual++;
			}
			weaverii_setopt($new_name,$val,false);
			    break;
		    case 'wii_content_color':
			weaverii_setopt('wii_content_color',$val,false);
			weaverii_setopt('wii_body_color',$val,false);
			break;
		    case 'wii_head_opts':
			$bare = str_replace("\n",'',$val);
			$bare = str_replace(' ','',$bare);
			if ($bare == '<!--AddyourownCSSsnippetsbetweenthestyletags.--><styletype="text/css"></style>')
			    break;
			echo("<span class=\"wvr_red\">CSS Rules possibly detected.</span> The following <em>&lt;HEAD&gt; Section</em>
code has been added to Weaver II's settings, and may require manual changes. CSS rules should be moved to the
<strong>Custom CSS Rules</strong> section.
<br /><span style=\"padding-left:20px;\"><code>" . esc_textarea($val) . "</code></span><br />\n");
			$manual++;
			weaverii_setopt($new_name,$val,false);
			break;
		    case 'wii_header_image_width_int':  // Theme Width (this is both the header and theme width)
			weaverii_setopt('wii_header_image_width_int',$val,false);
			weaverii_setopt('wii_theme_width_int',$val,false);
			break;
		    case 'wii_menubar_bgcolor':		// Menu Bar'
		    case 'wii_menubar_bgcolor_css':  // Menu Bar',
		    case 'wii_menubar_hover_color':
		    case 'wii_menubar_hover_color_css:':
		    case 'wii_menubar_text_color':  // Menu Bar text',
		    case 'wii_menubar_text_color_css':  // Menu Bar text',
			$sub = str_replace('menu','submenu',$new_name);
			weaverii_setopt($new_name,$val,false);
			weaverii_setopt($sub,$val,false);
			break;
		    case 'wii_menubar_hover_bgcolor':  // Menu Bar hover BG',
		    case 'wii_menubar_hover_bgcolor_css':  // Menu Bar hover BG',
			weaverii_setopt($new_name,$val,false);
			weaverii_setopt('wii_submenubar_bgcolor',$val,false);
			weaverii_setopt('wii_submenubar_hover_bgcolor',$val,false);
			break;
		    case 'wii_site_margins':  // Theme Margin
			weaverii_setopt('wii_site_margins_T',$val,false);
			weaverii_setopt('wii_site_margins_B',$val,false);
			weaverii_setopt('wii_site_margins_L',$val,false);
			weaverii_setopt('wii_site_margins_R',$val,false);
			break;
		    case 'wii_show_comments_closed':  // Hide <em>Comments Off</em>
			weaverii_setopt($new_name,!$val,false);
			break;
		    case 'wii_desc_font_size':  // Larger Site Description
			weaverii_setopt($new_name,'200',false);
			break;
		    case 'wii_widget_primary_bgcolor':  // Primary Widget Area BG
			weaverii_setopt('wii_widget_primary_bgcolor',$val,false);
			weaverii_setopt('wii_widget_left_bgcolor',$val,false);
			weaverii_setopt('wii_widget_right_bgcolor',$val,false);
			break;
		    case 'wii_widget_primary_bgcolor_css':  // Primary Widget Area BG
			weaverii_setopt('wii_widget_primary_bgcolor_css',$val,false);
			weaverii_setopt('wii_widget_left_bgcolor_css',$val,false);
			weaverii_setopt('wii_widget_right_bgcolor_css',$val,false);
			break;
		    case 'wii_widget_top_bgcolor':  // Top/Bottom Widget Areas BG
			weaverii_setopt('wii_widget_top_bgcolor',$val,false);
			weaverii_setopt('wii_widget_bottom_bgcolor',$val,false);
			break;
		    case 'wii_widget_top_bgcolor_css':  // Top/Bottom Widget Areas BG
			weaverii_setopt('wii_widget_top_bgcolor_css',$val,false);
			weaverii_setopt('wii_widget_bottom_bgcolor_css',$val,false);
			break;
		    case 'wii_widget_top_std_border':  // Area Border on Top/Bottom widget areas
			weaverii_setopt('wii_widget_top_std_border',$val,false);
			weaverii_setopt('wii_widget_bottom_std_border',$val,false);
			break;
		    case 'wii_weaverii_tables':  // Table Styes
			switch ($val) {
			    case 'Default':
				weaverii_setopt($new_name,'wide',false);
				break;
			    case 'Weaver':
				weaverii_setopt($new_name,'default',false);
				break;
			    case 'Bold Headings':
				weaverii_setopt($new_name,'bold',false);
				break;
			    case 'Full Width':
				weaverii_setopt($new_name,'fullwidth',false);
				break;
			    case 'None':
				weaverii_setopt($new_name,'plain',false);
				break;
			    default:
				weaverii_setopt($new_name,'default',false);
				break;
			}
			break;
		} // end switch
		break;
	    default:
	   	$converted++;
		weaverii_setopt($new_name,$val,false);
	    }	// end switch
	} else {
	    if ($val) {
		$errors++;
		echo("Conversion Error for $opt: No conversion available</br>\n");
	    }
	    else
		$skipped++;
	}
    }

    // Now do Weaver Plus options

    $old_plus = get_option('weaver_plus',array());

    $plus = array();	// converted plus options
    $plus_num = 0;

    if (!empty($old_plus) && weaverii_init_base())
    foreach ($old_plus as $opt => $val) {		// WEAVER PLUS SETTINGS
	if ($val == '')
	    continue;

	$plus_num++;
	// ignore these $wvp_ignore
	if (array_search($opt, $wvp_ignore) !== false)
	    continue;

	// change wvp_ to wii_ and add to weaver ii opts $wvp_to_wii_opts
	if (array_search($opt, $wvp_to_wii_opts) !== false) {
	    $fixed = str_replace('wvp_', 'wii_',$opt);
	    weaverii_setopt($fixed,$val,false);
	    continue;
	}

	if (strpos($opt,'ttw_') !== false) {
	    continue;	// bug in Weaver - ignore these...
	}

	if (strpos($opt, 'wvp_bg_') !== false) { 	// wvp_bg_ -> _wii_bg_ : weaver opts
	    $fixed = str_replace('wvp_', 'wii_',$opt);
	    weaverii_setopt($fixed,$val,false);
	    continue;
	}

	// fonts_ -> fonts_ : weaver opts
	if (strpos($opt, 'fonts_') !== false) {
	    weaverii_setopt('wiip_' . $opt,$val,false);
	    continue;
	}

	// everything starting with 'css_' is a straight through copy (total css) : PRO opts
	// everything starting with 'slider' is straight through (slider menu shortcode) : PRO opts
	// buttons => buttons :PRO opts
	// hdr_ -> no change: PRO opts
	// 'wvpsc_ - no change : PRO opts
	// wvr_disclaimer - no change : PRO opts
	// wvp_add_social_to_menu : PRO opts

	$plus[$opt] = $val;
    }
    if (!empty($plus) && weaverii_init_base()) {
	global $weaverii_pro_opts;
	delete_option('weaverii_pro');
	$weaverii_pro_opts = $plus;

	weaverii_pro_update_options('convert');
    }

if ($need_widget_notice) {
	echo("<span class=\"wvr_red\">Manual attention required:</span> The options for sidebars and widget areas have changed <strong>significantly</strong> in Weaver II. <em>Please see the help file discussion about this topic.</em>
You will have to make some manual adjustments to your sidebar and widget settings.<br />\n");
    }

    if (!weaverii_getopt('wii_layout_default'))
	weaverii_setopt('wii_layout_default', 'right-1-col',false);
    if (!weaverii_getopt('wii_layout_default_archive'))
	weaverii_setopt('wii_layout_default_archive', 'one-column',false);
    weaverii_setopt('wii_comment_content_bgcolor','transparent',false);	// decent compromise
    weaverii_setopt('wii_infobar_hide','checked',false);			// just hide it...
    weaverii_setopt('wii_hide_old_weaver',10,false);				// kill the message


    weaverii_setopt('wii_version_id',WEAVERII_VERSION_ID);	// an force db save as well (not false)
    weaverii_init_opts('convert_old_weaver'); // changed some things, so re-save

    echo '<hr /><strong>Page Template Usage</strong><p>The following pages use old style Weaver Page Templates. They will
    require manual conversion to the new style Weaver II Page Templates. Please see the Help file
    for hints on converting old Weaver II templates to the new Weaver II templates.&nbsp;';
    weaverii_help_link('help.html#converttemplates','Help for Converting Page Templates');
    echo '</p>';
    $tpl_num = 0;
    $pages = get_pages();
    foreach ($pages as $page) {		// PAGE TEMPLATE LIST
	$template = get_post_meta( $page->ID, '_wp_page_template', true );
	if ($template == 'default' || !$template)
	    continue;
	switch ($template) {
	    case 'page-altleft.php':
		$name = 'Alternative sidebar, left';
		break;
	    case 'page-altright.php':
		$name = 'Alternative sidebar, right';
		break;
	    case 'page-customheader.php':
		$name = 'Custom Header (see Adv Opts admin)';
		break;
	    case 'page-multicolcontent.php':
		$name = '2 Col Content (split w/ &lt;!--more--&gt;)';
		break;
	    case 'page-onecolumniframe.php':
		$name = 'One column, iframe full width';
		break;
	    case 'page-posts-excerpt.php':
		$name = 'Page with Posts (excerpts)';
		break;
	    case 'page-posts-excerpt2col.php':
		$name = 'Page with Posts (excerpts - 2 cols)';
		break;
	    case 'page-posts-title.php':
		$name = 'Page with Posts (title)';
		break;
	    case 'page-posts-title2col.php':
		$name = 'Page with Posts (title - 2 cols)';
		break;
	    case 'page-posts.php':
		$name = 'Page with Posts';
		break;
	    case 'page-posts2col.php':
		$name = 'Page with Posts (2 cols)';
		break;
	    case 'page-sitemap.php':
		$name = 'Sitemap';
		break;
	    case 'page-wrapperonly.php':
		$name = 'Blank - (see Adv Opts admin)';
		break;
	    case 'page-sitemap.php':
		$name = 'Sitemap';
		break;
	    case 'pg-popup.php':
		$name = 'Pop Up';
		break;
	    case 'onecolumn-page.php':
		$name = 'One column, no sidebar';
		break;
	    default:
		if (strstr($template,'paget-') !== false)
		    $name = 'Existing Weaver II template - no action required.';
		else
		    $name = 'unknown: (' . $template . ')';
		break;

	}
	echo '<strong><em>' . $page->post_title . '</em></strong> &nbsp; <small>(id:' . $page->ID . ')</small> &nbsp; uses template: <strong>' . $name . '</strong><br>';
	$tpl_num++;
    }

    if ($tpl_num < 1) echo '<p>None of you existing pages use Weaver Page Templates.</p>';

    // check on background and header image

    $updated = false;
    if (weaverii_init_base())
	$updated = weaverii_update_mods(WEAVER_SLUG,WEAVERII_PRO_SLUG);
    else
	$updated = weaverii_update_mods(WEAVER_SLUG,WEAVERII_SLUG);

    echo '<hr /><strong>Appearance settings (Header, Background) copied.</strong>';

    echo '<br /><hr /><strong>Summary for ' . weaverii_getopt('wii_subtheme') . ' theme.</strong>';
    $name = weaverii_getopt('wii_themename');
    if ($name && $name != weaverii_getopt('wii_subtheme')) echo ' (' . $name . ') ';
    if (weaverii_getopt('wii_theme_description')) {
	echo '<br /><em>Description:</em> ' . weaverii_getopt('wii_theme_description');
    }
    echo('<br />');
    echo ("<span class=\"wvr_green\">Compatible values converted:</span> $converted<br />\n");
    if ($plus_num > 0)
	echo ("<span class=\"wvr_green\">Weaver Plus values converted:</span> $plus_num<br />\n");
    // echo ("Values requiring special conversion: $special<br />\n");
    // echo ("Values skipped: $skipped<br />\n");
    echo ("<span class=\"wvr_yellow\">Values no longer supported or needed:</span> $notes<br />\n");
    echo ("<span class=\"wvr_red\">Values requiring manual attention:</span> $manual<br />\n");

    echo("</div>\n");
}

?>
