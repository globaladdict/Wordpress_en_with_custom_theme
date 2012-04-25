<?php
// Admin panel that gets added to the page edit page for per page options

add_action('admin_menu', 'weaverii_add_page_fields');

function weaverii_add_page_fields() {
    add_meta_box('wii_page-box', 'Weaver II Options For This Page', 'weaverii_page_extras', 'page', 'normal', 'high');
    add_meta_box('wii_post-box', 'Weaver II Options For This Post', 'weaverii_post_extras', 'post', 'normal', 'high');
    $i = 1;
    $args=array( 'public'   => true, '_builtin' => false );
    $post_types=get_post_types($args,'names','and');
    foreach ($post_types  as $post_type ) {
	add_meta_box('wii_post-box' . $i, 'Weaver II Options For This Post', 'weaverii_post_extras', $post_type, 'normal', 'high');
	$i++;
    }
}

function weaverii_page_checkbox($opt, $msg) {
	global $post;
?>
    <input type="checkbox" id="<?php echo($opt); ?>" name="<?php echo($opt); ?>"
	<?php if (get_post_meta($post->ID, $opt, true)) { echo " checked='checked' ";} ?> />
	<?php echo($msg . '&nbsp;&nbsp;');
}

function weaverii_page_layout() {
	global $post;
?>
Select Layout for this Page &nbsp;&nbsp;
	<select name="wvr_page_layout" id="wvr_page_layout">
	<option value=""></option>
        <option value="one-column" <?php if ( get_post_meta($post->ID, 'wvr_page_layout', true) == 'one-column') { echo ' selected="selected"'; }?>>
No sidebars, one column content</option>

	<option value="right-1-col" <?php if ( get_post_meta($post->ID, 'wvr_page_layout', true) == 'right-1-col') { echo ' selected="selected"'; }?>>
Single column sidebar on Right</option>

	<option value="left-1-col" <?php if ( get_post_meta($post->ID, 'wvr_page_layout', true) == 'left-1-col') { echo ' selected="selected"'; }?>>
Single column sidebar on Left</option>

	<option value="right-2-col" <?php if ( get_post_meta($post->ID, 'wvr_page_layout', true) == 'right-2-col') { echo ' selected="selected"'; }?>>
Double Cols, Right (top wide)</option>

	<option value="left-2-col" <?php if ( get_post_meta($post->ID, 'wvr_page_layout', true) == 'left-2-col') { echo ' selected="selected"'; }?>>
Double Cols, Left (top wide)</option>

	<option value="right-2-col-bottom" <?php if ( get_post_meta($post->ID, 'wvr_page_layout', true) == 'right-2-col-bottom') { echo ' selected="selected"'; }?>>
Double Cols, Right (bottom wide)</option>

	<option value="left-2-col-bottom" <?php if ( get_post_meta($post->ID, 'wvr_page_layout', true) == 'left-2-col-bottom') { echo ' selected="selected"'; }?>>
Double Cols, Left (bottom wide)</option>


	<option value="split" <?php if ( get_post_meta($post->ID, 'wvr_page_layout', true) == 'split') { echo ' selected="selected"'; }?>>
Split - sidebars on Right and Left</option>
	</select>&nbsp;Select sidebar layout to override default Page layout for this page.

<?php
}

function weaverii_pwp_type() {
	global $post;
?>
Display posts as: &nbsp;&nbsp;
	<select name="wvr_pwp_type" id="wvr_pwp_type">
	<option value="" <?php if ( get_post_meta($post->ID, 'wvr_pwp_type', true) == '') { echo ' selected="selected"'; }?>></option>

	<option value="full" <?php if ( get_post_meta($post->ID, 'wvr_pwp_type', true) == 'full') { echo ' selected="selected"'; }?>>
Full post</option>

	<option value="excerpt" <?php if ( get_post_meta($post->ID, 'wvr_pwp_type', true) == 'excerpt') { echo ' selected="selected"'; }?>>
Excerpt</option>

	<option value="title" <?php if ( get_post_meta($post->ID, 'wvr_pwp_type', true) == 'title') { echo ' selected="selected"'; }?>>
Title only</option>

<option value="title_featured" <?php if ( get_post_meta($post->ID, 'wvr_pwp_type', true) == 'title_featured') { echo ' selected="selected"'; }?>>
Title + Featured Image</option>
	</select> &nbsp;How to display posts on this Page with Posts - default is to use global "Post Specifics" settings

<?php
}

function weaverii_pwp_cols() {
	global $post;
?>
Dispaly post columns: &nbsp;&nbsp;
	<select name="wvr_pwp_cols" id="wvr_pwp_cols">
	<option value="1" <?php if ( get_post_meta($post->ID, 'wvr_pwp_cols', true) == '1') { echo ' selected="selected"'; }?>>
1 Column</option>

	<option value="2" <?php if ( get_post_meta($post->ID, 'wvr_pwp_cols', true) == '2') { echo ' selected="selected"'; }?>>
2 Columns</option>

	<option value="3" <?php if ( get_post_meta($post->ID, 'wvr_pwp_cols', true) == '3') { echo ' selected="selected"'; }?>>
3 Columns</option>
	</select> &nbsp;Display posts in this many columns - left to right, then top to bottom

<?php
}

function weaverii_page_extras() {
	global $post;

 	echo("<p>\n");
	_e("<strong>Page Templates</strong>", 'weaver-ii'/*a*/ );
	weaverii_help_link('help.html#PageTemplates',__('Help for Weaver II Page Templates', 'weaver-ii'/*a*/ ));
	echo '<span style="float:right;">(This Page\'s ID: '; the_ID() ; echo ')</span>';
	weaverii_html_br();
	_e('Please click the (?) for more information about all the Weaver II Page Templates.', 'weaver-ii'/*a*/ );
	echo("</p><p>\n");
	_e("<strong>Per Page Options</strong>", 'weaver-ii'/*a*/ );
	weaverii_help_link('help.html#optsperpage', __('Help for Per Page Options', 'weaver-ii'/*a*/ ));
	weaverii_html_br();
	_e("These settings let you hide various elements on a per page basis.", 'weaver-ii'/*a*/ );
	weaverii_html_br();

	weaverii_page_checkbox('ttw-hide-page-title',__('Hide Page Title', 'weaver-ii'/*a*/ ));
	weaverii_page_checkbox('ttw-hide-site-title',__('Hide Site Title/Description', 'weaver-ii'/*a*/ ));
	weaverii_page_checkbox('ttw-hide-menus',__('Hide Menus', 'weaver-ii'/*a*/ ));
	weaverii_page_checkbox('ttw-hide-header-image',__('Hide Standard Header Image', 'weaver-ii'/*a*/ ));
	weaverii_html_br();
	weaverii_page_checkbox('ttw-hide-header',__('Hide Entire Header', 'weaver-ii'/*a*/ ));
	weaverii_page_checkbox('ttw-hide-header-widget',__('Hide Header Widget Area', 'weaver-ii'/*a*/ ));
	weaverii_page_checkbox('ttw-hide-footer',__('Hide Entire Footer', 'weaver-ii'/*a*/ ));
	weaverii_html_br();
	weaverii_page_checkbox('ttw-hide-on-menu',__('Hide Page on the Primary Menu', 'weaver-ii'/*a*/ ));
	weaverii_page_checkbox('wvr-hide-page-infobar',__('Hide Info Bar on this page', 'weaver-ii'/*a*/ ));
	weaverii_html_br();
	weaverii_page_checkbox('wvr-hide-on-menu-logged-in',__('Hide Page on the Primary Menu if logged in', 'weaver-ii'/*a*/ ));
	weaverii_page_checkbox('wvr-hide-on-menu-logged-out',__('Hide Page on the Primary Menu if NOT logged in', 'weaver-ii'/*a*/ ));
	weaverii_html_br();
	weaverii_page_checkbox('ttw-stay-on-page',__('Menu "Placeholder" page. Useful for top-level menu item - don\'t go anywhere when menu item is clicked.', 'weaver-ii'/*a*/ ));
	weaverii_html_br();
	weaverii_page_checkbox('hide_visual_editor',__('Disable Visual Editor for this page. Useful if you enter simple HTML or other code.', 'weaver-ii'/*a*/ ));
	if (weaverii_allow_multisite()) {
	    weaverii_html_br();
	    weaverii_page_checkbox('wvr_raw_html',__('Allow Raw HTML and scripts. Disables auto paragraph, texturize, and other processing.', 'weaver-ii'/*a*/ ));
	}
	weaverii_html_br();
	weaverii_page_layout();
	weaverii_html_br();

	_e("<strong>Selective Display of Widget Areas</strong><br />
	These settings let you hide display of widget areas that would normally be displayed for a given page template. (Note that
	different page templates don't necessarily display the same widget areas.)", 'weaver-ii'/*a*/ );
	weaverii_html_br();
	weaverii_page_checkbox('hide_sidebar_primary',__('Hide Primary (top) Area', 'weaver-ii'/*a*/ ));
	weaverii_page_checkbox('hide_sidebar_right',__('Hide Upper/Right Area', 'weaver-ii'/*a*/ ));
	weaverii_page_checkbox('hide_sidebar_left',__('Hide Lower/Left Area', 'weaver-ii'/*a*/ ));
	weaverii_html_br();
	weaverii_page_checkbox('top-widget-area',__('Hide Top Area', 'weaver-ii'/*a*/ ));
	weaverii_page_checkbox('bottom-widget-area',__('Hide Bottom Area', 'weaver-ii'/*a*/ ));

	weaverii_page_checkbox('sitewide-top-widget-area',__('Hide Sitewide Top Area', 'weaver-ii'/*a*/ ));
	weaverii_page_checkbox('sitewide-bottom-widget-area',__('Hide Sitewide Bottom Area', 'weaver-ii'/*a*/ ));
	?>
	<br />
	Use Weaver II <em>Advanced Options&rarr;Per Page Widget Areas</em> tab to define widget areas to use here.
	<?php weaverii_help_link('help.html#PPWidgets',__('Help for Per Page Widget Areas', 'weaver-ii'/*a*/ )); ?>
	<br />
	<input type="text" size="15" id="ttw_show_extra_areas" name="ttw_show_extra_areas"
	value="<?php echo esc_textarea(get_post_meta($post->ID, "ttw_show_extra_areas", true)); ?>" />
	<?php _e("<em>Additional Top Widget Area</em> - Enter name of a Per Page Widget Top Area to display.", 'weaver-ii'/*a*/ ); ?> <br />

	<input type="text" size="15" id="ttw_show_replace_primary" name="ttw_show_replace_primary"
	value="<?php echo esc_textarea(get_post_meta($post->ID, "ttw_show_replace_primary", true)); ?>" />
	<?php _e("<em>Primary (top) Replacement</em> - Enter name of a Per Page Widget Area to replace the standard Primary (top) area.", 'weaver-ii'/*a*/ ); ?> <br />

	<input type="text" size="15" id="ttw_replace_right" name="ttw_replace_right"
	value="<?php echo esc_textarea(get_post_meta($post->ID, "ttw_replace_right", true)); ?>" />
	<?php _e("<em>Upper/Right Replacement</em> - Enter name of a Per Page Widget Area to replace the standard Upper/Right area.", 'weaver-ii'/*a*/ ); ?> <br />
	<input type="text" size="15" id="ttw_replace_left" name="ttw_replace_left"
	value="<?php echo esc_textarea(get_post_meta($post->ID, "ttw_replace_left", true)); ?>" />
	<?php _e("<em>Lower/Left Replacement</em> - Enter name of a Per Page Widget Area to replace the standard Lower/Left area.", 'weaver-ii'/*a*/ ); ?> <br />

	<?php // No need to hide other widget areas - it would make no sense to hide the alt widget area, for example ?>
</p>
<p>
	<?php _e('<strong>Settings for "Page with Posts" Template</strong>', 'weaver-ii'/*a*/ );
	weaverii_help_link('help.html#PerPostTemplate',__('Help for Page with Posts Template', 'weaver-ii'/*a*/ ) );

	$template = !empty($post->page_template) ? $post->page_template : "Default Template";
	if ($template == 'paget-posts.php') {
	?>
	<br />
	<?php _e('These settings are optional, and can filter which posts are displayed when you use the "Page
	with Posts" template. The settings will be combined for the final filtered list of posts displayed.
	(If you make mistakes in your settings, it won\'t be apparent until you display the page.)', 'weaver-ii'/*a*/ ); ?><br />


	<input type="text" size="30" id="ttw_category" name="ttw_category"
	value="<?php echo esc_textarea(get_post_meta($post->ID, "ttw_category", true)); ?>" />
	<?php _e("<em>Category</em> - Enter list of category slugs of posts to include. (-slug will exclude specified category)", 'weaver-ii'/*a*/ ); ?> <br />

	<input type="text" size="30" id="ttw_tag" name="ttw_tag"
	value="<?php echo esc_textarea(get_post_meta($post->ID, "ttw_tag", true)); ?>" />
	<?php _e("<em>Tags</em> - Enter list of tag slugs of posts to include.", 'weaver-ii'/*a*/ ); ?> <br />

	<input type="text" size="30" id="ttw_onepost" name="ttw_onepost"
	value="<?php echo esc_textarea(get_post_meta($post->ID, "ttw_onepost", true)); ?>" />
	<?php _e("<em>Single Post</em> - Enter post slug of a single post to display.", 'weaver-ii'/*a*/ ); ?> <br />

	<input type="text" size="30" id="ttw_orderby" name="ttw_orderby"
	value="<?php echo esc_textarea(get_post_meta($post->ID, "ttw_orderby", true)); ?>" />
	<?php _e("<em>Order by</em> - Enter method to order posts by: author, date, title, or rand.", 'weaver-ii'/*a*/ ); ?> <br />

	<input type="text" size="30" id="ttw_order" name="ttw_order"
	value="<?php echo esc_textarea(get_post_meta($post->ID, "ttw_order", true)); ?>" />
	<?php _e("<em>Sort order</em> - Enter ASC or DESC for sort order.", 'weaver-ii'/*a*/ ); ?> <br />

	<input type="text" size="30" id="ttw_posts_per_page" name="ttw_posts_per_page"
	value="<?php echo esc_textarea(get_post_meta($post->ID, "ttw_posts_per_page", true)); ?>" />
	<?php _e("<em>Posts per Page</em> - Enter maximum number of posts per page.", 'weaver-ii'/*a*/ ); ?> <br />

	<input type="text" size="30" id="ttw_author" name="ttw_author"
	value="<?php echo esc_textarea(get_post_meta($post->ID, "ttw_author", true)); ?>" />
	<?php _e('<em>Author</em> - Enter author (use username, including spaces)', 'weaver-ii'/*a*/ ); ?> <br />

	<input type="text" size="30" id="wvr_post_type" name="wvr_post_type"
	value="<?php echo esc_textarea(get_post_meta($post->ID, "wvr_post_type", true)); ?>" />
	<?php _e('<em>Custom Post Type</em> - Enter slug of one custom post type to display', 'weaver-ii'/*a*/ ); ?> <br />

	<?php weaverii_pwp_type(); ?><br />
	<?php weaverii_pwp_cols(); ?><br />

	<?php weaverii_page_checkbox('ttw_hide_sticky',__('Hide Sticky Posts', 'weaver-ii'/*a*/ )); ?>
	<?php weaverii_page_checkbox('ttw_hide_pp_infotop',__('Hide top info line', 'weaver-ii'/*a*/ )); ?>
	<?php weaverii_page_checkbox('ttw_hide_pp_infobot',__('Hide bottom info line', 'weaver-ii'/*a*/ )); ?>
	<?php weaverii_page_checkbox('wvr_show_pp_featured_img',__('Show post featured image', 'weaver-ii'/*a*/ )); ?>
</p>
<?php
	} else {	// NOT a page with posts
?>	<p><strong>Note:</strong> After you choose the "Page with Posts" template from the <em>Template</em>
	option in the <em>Page Attributes</em> box, <strong>and</strong> <em>Publish</em> or <em>Save Draft</em>,
	settings for "Page with Posts" will be displayed here. (Current page template: <?php echo $template; ?>)
	</p>
<?php
	}
?>
<hr />
<p style="line-height:1.3em;">
<?php 	_e('<strong>Per Page Code Insertion</strong>', 'weaver-ii'/*a*/ );
	weaverii_help_link('help.html#ExtraPP', __('Help for Extra Per Page Options', 'weaver-ii'/*a*/ ));
	weaverii_html_br();
	_e('Weaver supports code and HTML insertion for the following areas. To add code, manually define the specified <em>Custom Field Name</em> and <em>Value</em>):', 'weaver-ii'/*a*/ );

	weaverii_html_br();
	_e('&nbsp;&nbsp;Define <em>page-head-code</em>, and the value contents will be added to the &lt;HEAD&gt; section. Include &lt;style>...&lt;/style> if adding CSS.', 'weaver-ii'/*a*/ );
	weaverii_html_br();
	_e('&nbsp;&nbsp;Define the following <em>Custom Field Names</em> and values to specify the equivalent HTML Insertion areas for this page:', 'weaver-ii'/*a*/ );
	weaverii_html_br();
	echo '&nbsp;&nbsp;&nbsp;&nbsp;<em>preheader, header, premain, precontent, presidebar_left, presidebar_right, precomments, prefooter, footer, postfooter</em>';
	weaverii_html_br();
?>
</p>
	<input type='hidden' id='wii_post_meta' name='wii_post_meta' value='wii_post_meta'/>
<?php
}

function weaverii_post_extras() {
	global $post; ?>
<p>
	<?php
	_e("<strong>Per Post Options</strong>", 'weaver-ii'/*a*/ );
	weaverii_help_link('help.html#PerPage', __('Help for Per Post Options', 'weaver-ii'/*a*/ ));
	weaverii_html_br();
	_e("These settings let you control display of this individual post.", 'weaver-ii'/*a*/ );
	weaverii_html_br();
	weaverii_page_checkbox('ttw-force-post-full',__('Display as full post where normally excerpted.', 'weaver-ii'/*a*/ ));
	weaverii_page_checkbox('ttw-force-post-excerpt',__('Display post as excerpt', 'weaver-ii'/*a*/ ));
	weaverii_html_br();
	weaverii_page_checkbox('ttw-show-featured',__('Show Featured Image with post', 'weaver-ii'/*a*/ ));
	// Can't add an option to hide featured in header per post because we don't know the post at header time.

	weaverii_page_checkbox('ttw-show-post-avatar',__('Show author avatar with post', 'weaver-ii'/*a*/ ));
	weaverii_page_checkbox('ttw-favorite-post',__('Mark as a favorite post (adds star to title)', 'weaver-ii'/*a*/ ));
	weaverii_html_br();

	weaverii_page_checkbox('hide_top_post_meta',__('Hide top post info line.', 'weaver-ii'/*a*/ ));
	weaverii_page_checkbox('hide_bottom_post_meta',__('Hide bottom post info line.', 'weaver-ii'/*a*/ ));
	weaverii_html_br();

	weaverii_page_checkbox('ttw_hide_sidebars',__('Hide Sidebars when this post displayed on Single Post page.', 'weaver-ii'/*a*/ ));
	weaverii_html_br();
	weaverii_page_checkbox('hide_visual_editor',__('Disable Visual Editor for this page. Useful if you enter simple HTML or other code.', 'weaver-ii'/*a*/ ));
	if (weaverii_allow_multisite()) {
	    weaverii_html_br();
	    weaverii_page_checkbox('wvr_raw_html',__('Allow Raw HTML and scripts. Disables auto paragraph, texturize, and other processing.', 'weaver-ii'/*a*/ ));
	}
	?>
</p>
<p>
	<?php _e('The above settings are not used by the [weaver_show_posts] shortcode.', 'weaver-ii'/*a*/ ); ?><br />
	<?php _e('<strong>Per Post Style</strong>', 'weaver-ii'/*a*/ );
		weaverii_help_link('help.html#perpoststyle', __('Help for Per Post Style', 'weaver-ii'/*a*/ ));?> <br />
	<?php _e("Enter optional per post CSS style rules. <strong>Do not</strong> include the &lt;style> and &lt;/style> tags.
	    Include the {}'s. Don't use class names if rules apply to whole post, but do include class names
	    (e.g., <em>.entry-title a</em>) for specific elements. Custom styles will not be displayed by the Post Editor."); ?> <br />
	<textarea name="ttw_per_post_style" rows=2 style="width: 95%"><?php echo(get_post_meta($post->ID, "ttw_per_post_style", true)); ?></textarea>
	<br>
	<?php _e('<strong>Post Format</strong>', 'weaver-ii'/*a*/ );
	weaverii_help_link('help.html#gallerypost', __('Help for Per Post Format', 'weaver-ii'/*a*/ ));
	weaverii_html_br();
	_e('Weaver II supports Post Formats as shown in the "Format" option box to the right. Click the ? for more info.', 'weaver-ii'/*a*/ );
	weaverii_html_br();

	_e('<em>Note:</em> when you add settings for the post here, values will be created and displayed in the "Custom Fields" box.', 'weaver-ii'/*a*/ ); ?>
</p>
	<input type='hidden' id='wii_post_meta' name='wii_post_meta' value='wii_post_meta'/>

<?php
}

function weaverii_save_post_fields($post_id) {
    // for backward compatibility, we will retain the ttw prefix names so old sites will still work with per page options - mostly...
    $default_post_fields = array('ttw_category', 'ttw_tag', 'ttw_onepost', 'ttw_orderby', 'ttw_order', 'ttw_author', 'ttw_posts_per_page',
	'hide_sidebar_primary','hide_sidebar_right','hide_sidebar_left','top-widget-area','bottom-widget-area','sitewide-top-widget-area',
	'sitewide-bottom-widget-area','wvr_post_type',
	'ttw-hide-page-title','ttw-hide-site-title','ttw-hide-menus','ttw-hide-header-image','ttw-hide-footer','ttw-hide-header','ttw_hide_sticky',
	'ttw-force-post-full','ttw-force-post-excerpt','ttw-show-post-avatar','ttw-favorite-post','ttw_show_extra_areas','ttw_hide_sidebars',
	'ttw_show_replace_primary','ttw_replace_right','ttw_replace_left','hide_top_post_meta','hide_bottom_post_meta',
	'ttw-show-featured','ttw-hide-featured-header','ttw-stay-on-page', 'ttw-hide-on-menu', 'wvr_show_pp_featured_img',
	'ttw_hide_pp_infotop','ttw_hide_pp_infobot','ttw_show_replace_alternative', 'ttw_per_post_style', 'hide_visual_editor',
	'wvr_page_layout', 'wvr_pwp_type', 'wvr_pwp_cols', 'ttw-hide-header-widget', 'wvr-hide-page-infobar',
	'wvr-hide-on-menu-logged-in','wvr-hide-on-menu-logged-out'
	);
if (weaverii_allow_multisite()) {
	array_push($default_post_fields, 'wvr_raw_html');
}

    $all_post_fields = $default_post_fields;

    if (isset($_POST['wii_post_meta'])) {
        foreach ($all_post_fields as $post_field) {
	    if (isset($_POST[$post_field])) {
                $data = stripslashes($_POST[$post_field]);
		if ($post_field == 'ttw_show_extra_areas' || $post_field == 'ttw_replace_right' ||
		    $post_field == 'ttw_replace_left') {
		    $data = strtolower($data);	// force to lower case
		}
                if (get_post_meta($post_id, $post_field) == '') {
                    add_post_meta($post_id, $post_field, weaverii_filter_textarea($data), true);
                }
                else if ($data != get_post_meta($post_id, $post_field, true)) {
                    update_post_meta($post_id, $post_field, weaverii_filter_textarea($data));
                }
		else if ($data == '') {
                    delete_post_meta($post_id, $post_field, get_post_meta($post_id, $post_field, true));
		}
	    } else {
		delete_post_meta($post_id, $post_field, get_post_meta($post_id, $post_field, true));
	    }
        }
    }
}

add_action("save_post", "weaverii_save_post_fields");
add_action("publish_post", "weaverii_save_post_fields");
?>
