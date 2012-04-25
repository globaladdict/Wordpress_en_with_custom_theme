<?php
/* Weaver II - admin Advanced Options
 *
 */

function weaverii_admin_advancedopts() {
?>
<div id="tabwrap_adv" style="padding-left:5px;">
    <div id="tab-container-adv" class='yetiisub'>
	<ul id="tab-container-adv-nav" class='yetiisub'>
<?php if (weaverii_allow_multisite()) { ?>
	    <li><a href="#adtab0" title="Insert custom HTML, scripts, and CSS into &lt;HEAD&gt; section."><?php echo(__('&lt;HEAD&gt; Section', 'weaver-ii'/*a*/ )); ?></a></li>
	    <li><a href="#adtab1" title="Insert custom HTML into several different page areas."><?php echo(__('HTML Insertion', 'weaver-ii'/*a*/ )); ?></a></li>
<?php } ?>
	    <li><a href="#adtab2" title="Information for Weaver's Page Templates"><?php echo(__('Page Templates', 'weaver-ii'/*a*/ )); ?></a></li>
	    <li><a href="#adtab4" title="Options to control display properties of archive pages."><?php echo(__('Archive-type Pages', 'weaver-ii'/*a*/ )); ?></a></li>
	    <li><a href="#bkimg" title="Add background images to page areas."><?php echo(__('Background Images', 'weaver-ii'/*a*/ )); ?></a></li>
	    <li><a href="#ototcss" title="Set display properties for Mobile devices"><?php echo(__('Mobile', 'weaver-ii'/*a*/ )); ?></a></li>
	    <li><a href="#oseo" title="Set options related to SEO"><?php echo(__('SEO', 'weaver-ii'/*a*/ )); ?></a></li>
	    <li><a href="#adtab3" title="Options related to this site: FavIcon, Home Page, more."><?php echo(__('Site Options', 'weaver-ii'/*a*/ )); ?></a></li>

	</ul>
<h3>Advanced Options<?php weaverii_help_link('help.html#AdvancedOptions','Help for Advanced Options'); ?></h3>
<?php /*
	    <div style="float:right; width:33%; border:1px solid #888; padding-left:8px;"><small>Are you a professional website designer?
	    If Weaver is helping you do your job, please make a donation to this theme!</small></div> */
?>
<?php weaverii_sapi_submit('save_options',__('Save Settings', 'weaver-ii'/*a*/ )); ?><br /><br />

<!-- ***************************************************** -->
<?php if (weaverii_allow_multisite() ) { ?>
<div id="adtab0" class="tab_adv" >
    <?php weaverii_adv_head_section();
?>
</div> <!-- adtab 0 -->

<!-- ***************************************************** -->

<div id="adtab1" class="tab_adv" >
    <?php weaverii_adv_html_insert(); ?>
</div> <!-- adtab1 -->
<?php } // end of major section of not allowed on multisite ?>

<!-- ***************************************************** -->
<div id="adtab2" class="tab_adv" >
    <?php weaverii_adv_page_template(); ?>
</div> <!-- adtab2 -->

<!-- ***************************************************** -->
<div id="adtab4" class="tab_adv" >
    <?php weaverii_adv_archive_pages(); ?>
</div> <!-- archive pages -->

<!-- ***************************************************** -->
<div id="bgimg" class="tab_adv" >
    <?php weaverii_adv_bgimages(); ?>
</div> <!-- total css -->


<!-- ***************************************************** -->
<div id="adtab4" class="tab_adv" >
    <?php weaverii_adv_mobile_opts(); ?>
</div> <!-- total css -->


<!-- ***************************************************** -->
<div id="oseo" class="tab_adv" >
    <?php weaverii_adv_seo_opts(); ?>
</div> <!-- SEO -->

<!-- ***************************************************** -->
<div id="adtab3" class="tab_adv" >
    <?php weaverii_adv_site_opts(); ?>
</div> <!-- site options -->

</div> <!-- tab-container-adv -->
<?php weaverii_sapi_submit('save_options',__('Save Settings', 'weaver-ii'/*a*/ )); ?>
</div> <!-- #tabwrap_adv-->

<script type="text/javascript">
	var tabberAdv = new Yetii({
	id: 'tab-container-adv',
	tabclass: 'tab_adv',
	persist: true
	});
</script>
<?php
}

function weaverii_adv_head_section() {
?>
<label><span style="color:blue; font-weight:bold; font-size: larger;">The Site &lt;HEAD&gt; Section</span></label>
<?php weaverii_help_link('help.html#HeadSection','Help for site HEAD section');?><br />
<p>
    This tab allows you to define custom code and style rules to the &lt;HEAD&gt; Section of every page on your site.
</p>

    <p><small>PLEASE NOTE: Only minimal validation is made on the field values, so be careful not to use invalid code.
    Invalid code is usually harmless, but it can make your site display incorrectly. If your site looks broken after make changes here,
     please double check that what you entered uses valid HTML or CSS rules.</small></p>

    <hr />

	<!-- ======== -->
<?php if (weaverii_allow_multisite()) { ?>
    <a name="headsection" id="headsection"></a>
    <label><span style="color:blue;font-size:larger"><b>&lt;HEAD&gt; Section</b></span></label><br/>

<p>
    This input area allows you to enter custom HTML and JavaScript code to your site.
    Code entered into this box is included right before the &lt;/HEAD&gt; HTML tag on each page of your site.
    This often will include JavaScript code supplied by other sites (such as Google Analytics) that is
    required to use some feature of the outside site. Shortcodes are not supported in this option.
    <small>Note: while you can add CSS bracketed in a
    &lt;style&gt; section here, the preferred way is to add CSS Rules using the "Custom CSS Rules" option below.</small>
</p>
<p>
	For even greater control of how your site looks, you can add code the the &lt;HEAD&gt; section on a per page basis
	using the per page options from the page editor.
    </p>
    <br />
		<textarea name="<?php weaverii_sapi_advanced_name('wii_head_opts'); ?>" rows=5 style="width: 95%"><?php echo(weaverii_esc_textarea(weaverii_getopt('wii_head_opts'))); ?></textarea>
	<!-- ===================================================== -->
  <br /><br />
    <a name="advancedcss" id="advancedcss"></a>
    <label><span style="color:#0000FF; font-weight:bold; font-size: larger;">Custom CSS Rules</span></label><br /><br />

    <!-- ======== -->
    <label><span style="color:#6666FF;"><b>Add your own custom CSS Rules to Weaver II's style rules</b></span></label><br/>
    <p>
	This section allows you to add new CSS Rules to your theme to enhance or override the styling set using
	Weaver's Main Options. For example, Weaver's documentation includes many <em>CSS Snippets</em> that allow you
	to find tune the look of your site. You simply add whatever CSS Rules you need into the box below. Include the
	complete rule. You do <em>not</em> need to add &lt;style&gt; HTML tags to bracket your rules.</p>
    <p>
	Rules you add here
	will be the <em>last</em> CSS Rules included by Weaver, and thus override all other Weaver generated CSS rules.
	It is possible that other plugins might generate CSS that comes after these rules.
    </p>
<textarea name="<?php weaverii_sapi_advanced_name('wii_add_css'); ?>" rows=7 style="width: 95%"><?php echo(weaverii_esc_textarea(weaverii_getopt('wii_add_css'))); ?></textarea>
<?php
    }	// not multisite
}

function weaverii_adv_html_insert() {
?>
<label><span style="color:blue; font-weight:bold; font-size: larger;">HTML Insertion</span></label>
<?php weaverii_help_link('help.html#HTMLInsertion','Help on HTML Code Insertion Areas');?><br />
<p>The <b>Advanced Options&rarr;HTML Insertion</b> tab allows you to insert custom HTML code in many places on your site.
These fields allow you to add HTML code, special CSS rules, or even JavaScripts. You will need at least
a bit of knowledge of HTML coding to use these fields most effectively.</p>

<p><small>The values you put here are saved in the WordPress database, and will survive theme upgrades and other changes.</small></p>

<p><small>PLEASE NOTE: Only minimal validation is made on the field values, so be careful not to use invalid code.
Invalid code is usually harmless, but it can make your site display incorrectly. If your site looks broken after make changes here,
please double check that what you entered uses valid HTML or CSS rules.</small></p>
<hr />
<?php

    $areas = array(
	array ('name'=>'Site Header Insert Code', 'id'=>'header', 'info'=>
"This HTML code will be inserted into the <em>#branding div</em> header area right above where the standard site
header image goes. You can use it for logos, better site name text - whatever. When used in combination with hiding the site title,
header image, and the menu, you can design a completely custom header. If you hide the title, image, and header, no other code is generated
in the #branding div, so this code can be a complete header replacement. You can also use WP shortcodes to embed plugins, including
rotating image slideshows such as <a href=\"http://www.jleuze.com/plugins/meteor-slides/\" target=\"_blank\">Meteor Slides</a>.
And there is automatic support for the
<a href=\"http://wordpress.org/extend/plugins/dynamic-headers/\" target=\"_blank\">Dynamic Headers</a> plugin which allows you
create highly dynamic headers from its control panel - just install and it will work without any other code edits.", 'help' => ''),

	array ('name'=>'Footer Code', 'id'=>'footer', 'info' =>
	    'This code will be inserted into the site footer area, just before the before the copyright and "Powered by" credits, but after any Footer widgets (check option below to move to before widgets). This could include extra information, visit counters, etc.',
	    'help' => ''),

	array ('name'=>'Pre-Wrapper Code', 'id'=>'+prewrapper', 'info' =>
	    'This code will be inserted just before the #wrapper and #branding divs, before any other site content. (Pro)',
	    'help' => ''),
	array ('name'=>'Pre-Header Code', 'id'=>'preheader', 'info' =>
	    'This code will be inserted just before the header area (between the "#wrapper" and the "#branding" divs), above the menus and site image.',
	    'help' => ''),
	array ('name'=>'Pre-Main Code', 'id'=>'+premain', 'info' =>
	    'This code will be inserted after the #branding div and before the #main div. (Pro)',
	    'help' => ''),
	array ('name'=>'Pre-Container Code', 'id'=>'+precontent', 'info' =>
	    'This code will be inserted inside the #container div that wraps content, including before the top widget areas. It will have the same width as the container area. (Pro)',
	    'help' => ''),
	array ('name'=>'Post-Post Content Code', 'id'=>'+postpostcontent', 'info' =>
	    'This code will be inserted after the content area of each post. (Pro)',
	    'help' => ''),
	array ('name'=>'Pre-Comments Code', 'id'=>'+precomments', 'info' =>
	    'This code will be inserted just before the #comments div where comments are displayed. (Pro)',
	    'help' => ''),
	array('name'=>'', 'id'=>'submit', 'info' => '', 'help' => ''),
	array ('name'=>'Post-Comments Code', 'id'=>'+postcomments', 'info' =>
	    'This code will be inserted right after the #comments div where comments are displayed. (Pro)',
	    'help' => ''),
	array ('name'=>'Pre-Footer Code', 'id'=>'+prefooter', 'info' =>
	    'This code will be inserted just before the footer #colophon div. (Pro)',
	    'help' => ''),
	array ('name'=>'Post-Footer', 'id'=>'postfooter', 'info' =>
	    'This code will be inserted just after the footer #colophon div, outside the #wrapper div.',
	    'help' => ''),
	array ('name'=>'Pre-Left Sidebar', 'id'=>'+presidebar_left',
'info' => 'This code will be inserted just before the left sidebar area. (Pro)',
	    'help' => ''),
	array ('name'=>'Pre-Right Sidebar', 'id'=>'+presidebar_right', 'info' =>
	    'This code will be inserted just before the right sidebar area. (Pro)',
	    'help' => '')
    );

    weaverii_sapi_submit('save_options',__('Save Settings', 'weaver-ii'/*a*/ )); echo("<br /><br />\n");

    foreach ($areas as $area => $def) {
	weaverii_add_html_field($def['name'],$def['id'],$def['info'],$def['help']);
    }

}

function weaverii_add_html_field($title, $name, $info, $help='') {

    if ($name=='submit') {
	weaverii_sapi_submit('save_options',__('Save Settings', 'weaver-ii'/*a*/ )); echo("<br /><br />\n");
	return;
    }

    $pro = weaverii_fix_type($name);
    if ($name[0] == '+') $name = substr($name,1); // fix locally

    $area_name = 'wii_' . $name . '_insert';
    $hide_front = 'wii_hide_front_' . $name;
    $hide_rest = 'wii_hide_rest_' . $name;
    $style_id = 'inject_' . $name;

    if ($pro == 'inactive') {
?>
<label><span style="color:#999;"><b><?php echo $title; ?></b> - (Pro Version)</span></label></br />
<?php
	if ($info) echo '<span style="color:#999;">' . $info. "</br> </br>\n";
	weaverii_adv_hidden($area_name);		// keep it working for Pro settings, even on free version
	weaverii_adv_hidden($hide_front);
	weaverii_adv_hidden($hide_rest);
	if ($info) echo '</span>';
	return;
    }
?>
<label><span style="color:blue;"><b><?php echo $title; ?></b></span></label></br />
<?php	if ($info) echo $info;
    echo (" (Style with <code>#$style_id</code>.)");
?>
    <br />
    <textarea name="<?php weaverii_sapi_advanced_name($area_name); ?>" rows=3 style="width: 95%"><?php echo(weaverii_esc_textarea(weaverii_getopt($area_name))); ?></textarea>
    <br />
    <label>Hide on front page: </label><input type="checkbox" name="<?php weaverii_sapi_advanced_name($hide_front); ?>" id="<?php echo $hide_front; ?>" <?php checked(weaverii_getopt_checked($hide_front)); ?> />
    <small>If you check this box, then the code from this area will not be displayed on the front (home) page.</small><br />
    <label>Hide on non-front pages: </label><input type="checkbox" name="<?php weaverii_sapi_advanced_name($hide_rest); ?>" id="<?php echo $hide_rest; ?>" <?php checked(weaverii_getopt_checked( $hide_rest )); ?> />
    <small>If you check this box, then the code from this area will not be displayed on non-front pages.</small>
<?php
    if ($name == 'footer') {
?>
<br /><label>Move to before widget areas: </label><input type="checkbox" name="<?php weaverii_sapi_advanced_name('wii_footer_inject_move'); ?>" id="wii_footer_inject_move" <?php checked(weaverii_getopt_checked( 'wii_footer_inject_move' )); ?> />
    <small>If you check this box, then the code from this area will be inserted <em>before</em> the footer widgets instead of after.</small>
<?php
    }
?>
    <br /><br />
<?php
}

function weaverii_adv_hidden($name) {
?>
<input name="<?php weaverii_sapi_advanced_name($name); ?>" id="<?php echo $name;?>" type="hidden" value="<?php echo weaverii_getopt($name); ?>" />
<?php
}

// ==============================================   PAGE TEMPLATES ===========================================

function weaverii_adv_page_template() {
?>
    <a name="custompage" id="custompage"></a>
    <label><span style="color:#00f; font-weight:bold; font-size: larger;">Custom Page Templates</span></label><br />

    <p>Weaver II includes several page templates - which is the WordPress tool for giving different look and functionality
    do individual static pages. Many of the properties of any given page, independent of the page template, can be
    set using the "Weaver II Options For This Page" box on the regular WordPress Page Editor admin page.</p>

    <p>One of the most requested features included in the Per Page box is the ability to set the sidebar layout for
    each page. If this is not set, the page will use the global options for the page type. The other popular option
    includes the ability to replace any of the sidebar widget areas, as well as the ability to add an additional top
    widget area. To use a new widget area you must first tell Weaver II to create a new one. These
    <strong>Per Page Widget Areas</strong> are defined on the Main Options:Widget Areas tab.</p>
    <h3>Overview of Page Templates</h3>

        <ul style="list-style-type:disc;margin-left:20px;">
	<li>
	The <strong>2 Col Content</strong> template splits content into two columns. You manually set the column
	split using the standard WP '&lt;--more-->' convention. (Note - since WordPress only used the '&lt--more-->' to
	show the "Continue reading..." for posts, it can serve this purpose for this template on pages. Columns will split first
	horizontally, then vertically (you can have more than one &lt;--more--> tag).
	</li>
	<li>
	The <strong>Blank</strong> page template will wrap the content of an associated page with an HTML div with class
	<code>.content-blank</code>  which you can add CSS rules to style using the standard Weaver II options.
	The standard page &lt;article&gt; wrapping is not used. The page title is not displayed. Use Per Page Options
	on Page edit menu to control Menu, Site Title, and Header Image visibility.
	</li>
	<li>
	<strong>Page with Posts</strong> serves as an alternative way to display posts. After you select the Page with Posts
	template, a new set of options will be added to the Per Page menu. There is additional help in the help documentation.
    	<li>
	The <strong>Raw</strong> template allows total custom HTML styling with no predefined div's. It useful for Pop Up pages.
	</li>
	<li>
	The <strong>Sitemap</strong> provides a page with a basic sitemap.
	</li>
	<li>
	The <strong>iframe</strong> template is designed for full width display of html iframes. You can control sidebars
	and titles using standard Per Page options.
	</li>
    </ul>
    <!-- ===================================================== -->

<?php
}

// ============================================== ARCHIVE-TYPE PAGES ===========================================
function weaverii_adv_archive_pages() {
    $opts = array(
    array('name' => 'Archive Type Pages', 'type' => 'header0',
        'info'=> 'Extra options for Archive-like pages - Categories, Tags, etc.',
	'help' => 'help.html#ArchivePages'),

    array('name' => 'Hide Categories Archives Title', 'id' => 'wii_hide_p_category', 'type' => '+checkbox',
	    'info' => 'Hide "Category Archives" title on category pages. (Pro)'),

    array('name' => '<small>Custom CSS</small>', 'id' => 'wii_p_category_css', 'type' => '+textarea',
	  'info' => 'Custom CSS to add to Category Archive page. (Pro)'),

    array('name' => 'Hide Tag Archives Title', 'id' => 'wii_hide_p_tag', 'type' => '+checkbox',
	  'info' => 'Hide "Tag Archives" title on category pages. (Pro)'),
    array('name' => '<small>Custom CSS</small>', 'id' => 'wii_p_tag_css', 'type' => '+textarea',
	  'info' => 'Custom CSS to add to Tag Archive page. (Pro)'),

    array('name' => 'Hide Author Archives Title', 'id' => 'wii_hide_p_author', 'type' => '+checkbox',
	  'info' => 'Hide "Author Archives" title on author pages. (Pro)'),
    array('name' => '<small>Custom CSS</small>', 'id' => 'wii_p_author_css', 'type' => '+textarea',
	  'info' => 'Custom CSS to add to Author Archive page. (Pro)'),

    array('name' => 'Hide Date Archives Title', 'id' => 'wii_hide_p_date', 'type' => '+checkbox',
	  'info' => 'Hide "Date Archives" title on date archive pages. (Pro)'),
    array('name' => '<small>Custom CSS</small>', 'id' => 'wii_p_date_css', 'type' => '+textarea',
	  'info' => 'Custom CSS to add to Date Archive page. (Pro)'),


    array('name' => 'Hide Search Results Title', 'id' => 'wii_hide_p_search', 'type' => '+checkbox',
	  'info' => 'Hide "Search Results" title on search pages. (Pro)'),
    array('name' => '<small>Custom CSS</small>', 'id' => 'wii_p_search_css', 'type' => '+textarea',
	  'info' => 'Custom CSS to add to Search Archive page. (Pro)'),
    );

    weaverii_form_show_options($opts);
}

// ==============================================   SITE OPTIONS ===========================================

function weaverii_adv_site_opts() {
?>
    <h2 style="color:#00f; font-weight:bold; font-size: larger;">Site Options
    <?php weaverii_help_link('help.html#AdvSiteOptions','Help on Advanced Site Options');?></h2>
    These options are available to fine tune various aspects of your site. Technically, these features
    are not part of the theme styling, but cover other aspects of site functionality.<br /><hr /><br />
   <!-- ======== -->


    <label><span style="color:blue;font-size:larger;"><b>FavIcon</b></span></label></br />
    <p>You can add a FavIcon to your site with this option. The preferred FavIcon is in the <code>.ico</code> format
    which has the most universal browser compatibility. However, <code>.png, .gif, and .jpg</code> will
    work for most modern browsers. The standard sizes are 16x16, 32x32, or 48x48 px. You can alternatively load
    a <code>favicon.ico</code> file to the root directory of your site. &diams;</p>
    <p>
<?php
    $icon=weaverii_getopt('_wii_favicon_url');
    if ($icon != '') {
	echo '<img src="' . $icon . '" />&nbsp;';
    }
?>
    <strong>FavIcon URL: </strong>
    <textarea name="<?php weaverii_sapi_advanced_name('_wii_favicon_url'); ?>" id="_wii_favicon_url" rows=1 style="width: 350px"><?php echo(esc_textarea(weaverii_getopt('_wii_favicon_url'))); ?></textarea><?php weaverii_media_lib_button('_wii_favicon_url'); ?>&nbsp;&nbsp;Full path to FavIcon
    </p><br />



   <label><span style="color:blue;font-size:larger;"><b>Preferred Image for Facebook</b></span></label></br />
    <p>Facebook and other sites will display a possibly arbitrarily chosen thumbnail for your site when it is used in a
    link on those sites. If <em>you</em> specify an image to use here, then that image, plus other OpenGraph site information
    for Facebook, will be added to your site's &lt;head&gt; using the proper &lt;meta&gt; tags. We recommend you do this as
    it gives you control, and helps when someone links to your site on Facebook. (Note: some SEO plugins will perform
    this same function, so you might want to leave this blank and use the SEO features instead.) The image must
    be at least 50x50 px, but probably not over 200x200 px, and less than 20K bytes in size. <small>After saving settings,
    enter this site's URL on <a href="http://developers.facebook.com/tools/debug" target="_blank">this page</a> to have Facebook update the information it saves for your site.</small> &diams;</p>
    <p>


<?php
    $imgsrc = weaverii_getopt('_wii_imgsrc_url');
    if ($imgsrc != '') {
	echo '<img src="' . $imgsrc . '" height="40px" />&nbsp;';
    }
?>
<strong>Image URL: </strong>
    <textarea name="<?php weaverii_sapi_advanced_name('_wii_imgsrc_url'); ?>" id="_wii_imgsrc_url" rows=1 style="width: 350px"><?php echo(esc_textarea(weaverii_getopt('_wii_imgsrc_url'))); ?></textarea><?php weaverii_media_lib_button('_wii_imgsrc_url'); ?>&nbsp;&nbsp;Full path to Site's preferred image
    </p><br />

    <label><span style="color:blue;font-size:larger;"><b>Home Page</b></span></label>
    <p>WordPress allows you to specify what page is used for your home page - either the standard WordPress blog,
    or a static page (which can be a Weaver "Page with Posts" page). How to set the Front page displays options
    is not totally obvious - please see the Weaver Help topic for a more complete explanation.</p>
    <p>You can set the front page on the Dashboard <em>Settings&rarr;Reading panel</em>:
    <a href="<?php echo esc_url( home_url( '/' ) . 'wp-admin/options-reading.php' ); ?>"><strong>Set Front Page Displays</strong></a></p><br />


    <label><span style="color:blue;font-size:larger;"><b>Author Avatars</b></span></label>
    <p>For the best look, your site should support Avatars - a small image associated with
    a contributors e-mail address. <a href="http://gravatar.com" target="_blank">Gravatar.com</a>
    is probably the most popular Avatar support, and is closely associated with WordPress. You should set up a Gravatar for
    the main authors of your blog. For contributors without any avatar, you can select an automatically
    generated avatar from several options found on the
    <a href="<?php echo esc_url( home_url( '/' ) . 'wp-admin/options-discussion.php' ); ?>">
    <strong>Settings&rarr;Discussion</strong></a> panel.
    </p>
    <hr />
<?php
}

function weaverii_adv_mobile_opts() {
    $opts = array(
    array('name' => 'Mobile Options', 'type' => 'header0',
        'info'=> 'Options for Mobile Devices',
	'help' => 'help.html#Mobile'),

    array('name' => 'Disable Mobile Support', 'id' => '_wii_mobile_disable', 'type' => 'checkbox',
	    'info' => 'Disable support for mobile devices. Recommended only if you are using a mobile device plugin. &diams;'),

    array('name' => 'Simulate Mobile Device', 'id' => '_wii_sim_mobile', 'type' => 'select_id',
	  'info' => 'Simulate Mobile Device: Select type to see what your site will look like on mobile devices. &diams;',
	  'value' => array(
			   array('val' => 'none', 'desc' => 'Simulation Off'),
			   array('val' => 'WeaverMobile', 'desc'=> 'Smart Phone' ),
			   array('val' => 'WeaverMobileSmallTablet', 'desc' => 'Small Tablet (Fire)'),
			   array('val' => 'WeaverMobileTablet', 'desc' => 'Large Tablet (iPad)')
		)),

    array('name' => '<small>... even if not admin</small>', 'id' => '_wii_sim_mobile_always', 'type' => 'checkbox',
	'info' => 'Normally, the mobile simulation will be displayed only for admins. Checking this allows visitors to view the simulated mobile view. IMPORTANT! Be careful using this option - it is intended for development and demos only and normally should be disabled for productions sites. &diams;'),

    array('name' =>'Small Screen Devices','type'=>'subheader',
	    'info' => 'Settings for smartphones and other small screen devices.'),

    array('name' => 'Show Full Blog Posts', 'id' => 'wii_mobile_full_posts', 'type' => '+checkbox',
	  'info' => 'Show full post text on blog pages - posts are excerpted by default on mobile devices. (Pro)'),

    array('name' => 'Show Footer Widgets', 'id' => 'wii_mobile_show_footerwidgets', 'type' => '+checkbox',
	  'info' => 'Will show footer widget areas on mobile devices. (Pro)'),

    array('name' => 'Hide Top/Bottom Widget Areas', 'id' => 'wii_mobile_hide_topbottom_widgets', 'type' => '+checkbox',
	  'info' => 'Hide Top and Bottom Widget Areas in addition to Sidebars. (Pro)'),

    array('name' => 'No Auto-Underline Links', 'id' => 'wii_mobile_nounderline', 'type' => '+checkbox',
	  'info' => 'Underlined links are easier to use on most mobile devices. This will disable auto-underlined links. (Pro)'),

    array('name' => __('View Toggle', 'weaver-ii'/*a*/ ), 'id' => 'wii_layout_view_toggle', 'type' => '+select_id',
	  'info' => __('How to display the Full View/Mobile View toggle button on mobile devices. (Pro)', 'weaver-ii'/*a*/ ),
	  'value' => array(
			   array('val' => 'both', 'desc' => 'Both top &amp; bottom'),
			   array('val' => 'top', 'desc'=> 'Top only' ),
			   array('val' => 'bottom', 'desc' => 'Bottom only'),
			   array('val' => 'hide', 'desc' => 'Hide view toggle')
		)),
    array('name' => '<small>Alternate Full View HTML</small>', 'id' => '_wvr_mobile_fullmsg', 'type' => '+textarea',
	  'info' => 'HTML to replace standard Full View icon (include style if needed). (Pro) &diams;'),
    array('name' => '<small>Alternate Mobile View HTML</small>', 'id' => '_wvr_mobile_mobilemsg', 'type' => '+textarea',
	  'info' => 'HTML to replace standard Mobile View icon. (Pro) &diams;'),

    array('name' => 'Mobile Home Page', 'id' => 'wii_mobile_home_int', 'type' => '+text',
	  'info' => 'Specify page ID for alternate Home page when site viewed from mobile device. (Pro)'), // !! fix for 1.1

    array('name' => 'Mobile Site Title', 'id' => '_wii_mobile_site_title', 'type' => '+textarea',
	  'info' => 'Specify alternate Site Title if needed (Use &amp;nbsp; to hide Site Title on mobile). (Pro) &diams;'),

    array('name' => '<small>Mobile Site Title Color</small>', 'id' => 'wii_mobile_title_color', 'type' => '+color',
	    'info' => 'Alternate Color for Mobile Site Title. (Pro)'),

    array('name' => 'Mobile Header Image', 'id' => '_wii_mobile_header_url', 'type' => '+textmedia',
	  'info' => 'Specify alternate header image for phone/small tablet mobile view. (Pro) &diams;'),

    array('name' => '<small>Mobile Header Image - Tablet</small>', 'id' => '_wii_mobile_tablet_header_url', 'type' => '+textmedia',
	  'info' => 'Specify alternate header image for tablet mobile view (will ususally not be necessary). (Pro) &diams;'),


    array('name' => 'Custom CSS', 'id' => '_wii_mobile_css', 'type' => '+textarea',
	  'info' => 'Custom site wide CSS included only when viewed on Mobile Device. Note that ".weaver-mobile" wrapping class can also be used for this purpose in the &lt;HEAD&gt; Section Custom CSS option. (Pro) &diams;'),

    array('name'=>'<span style="color:green;">More Mobile Options:</span>','type'=>'note',
	  'info'=>'More mobile options are available for specific areas: Header, Menus, Post Specifics, Shortcodes.'),


    array('name' =>'Tablets','type'=>'subheader',
	    'info' => 'Settings for iPad and other tablets'),

    array('name' => 'Keep Site Margins', 'id' => 'wii_mobile_keep_site_margins', 'type'=>'+checkbox',
	  'info' => 'Retain standard site margins on tablets - will normally reduce outer margins by default. (Pro)'),

    array('name' => 'No Auto-Underline Links', 'id' => 'wii_mobile_tablet_nounderline', 'type' => '+checkbox',
	  'info' => 'Underlined links are easier to use on most tablet devices. This will disable auto-underlined links. (Pro)'),


    array('name' =>'Alternate Mobile Theme','type'=>'subheader',
	    'info' => 'Use Alternate Mobile Theme when site viewed by Mobile Device.'),

    array('name' => 'Use Alternate Mobile Theme', 'id' => '_wii_mobile_alt_theme', 'type' => '+checkbox',
	  'info' => 'Mobile Devices will use the Mobile Theme Settings saved in the "Save Settings to Mobile Settings"
option on the "Save/Restore" tab. (The Alternate Mobile Theme can not be displayed with the Mobile Simulator.) (Pro) &diams;')
    );

    weaverii_check_cache_plugins();

    weaverii_form_show_options($opts);

    if (weaverii_getopt_checked('_wii_mobile_alt_theme')) {
	$temp = get_option('weaverii_settings_mobile');
	if ($temp === false) {
	    echo '<strong style="color:red;">Warning: No Mobile Theme Settings have been saved. You <strong>must</strong> use the "Save Settings to Mobile Settings" from the Save/Restore tab first!</strong><br />';
	}
    }

?>
<br />
   <label><span style="color:blue;"><b>Apple Touch Icon for iOS</b></span></label></br />
    <p>When this site is viewed on an Apple iOS device such as an iPhone or iPad, Apple iOS recognizes a special icon
    that can be displayed on the device's home screen. The recommend size for this icon is a <code>.png</code> file 57x57 px for basic display,
    or 114x114 px for enhanced display. &diams;</p>
    <p>
<?php
    $icon=weaverii_getopt('_wii_apple_touch_icon_url');
    if ($icon != '') {
	echo '<img src="' . $icon . '" />&nbsp;';
    }
?>
<strong>Apple Touch Icon URL: </strong>
    <textarea name="<?php weaverii_sapi_advanced_name('_wii_apple_touch_icon_url'); ?>" id="_wii_apple_touch_icon_url" rows=1 style="width: 350px"><?php echo(esc_textarea(weaverii_getopt('_wii_apple_touch_icon_url'))); ?></textarea><?php weaverii_media_lib_button('_wii_apple_touch_icon_url'); ?>&nbsp;&nbsp;Full path to Apple Touch Icon</p>

<br />
   <label><span style="color:blue;"><b>Caching Plugins for Weaver II</b></span></label></br />
    <p>Because of the advanced Mobile View capabilities provided by Weaver II, many existing WordPress Caching plugins
    will <strong>not</strong> work correctly with Weaver II. We have found that the <strong>Quick Cache</strong> and
    <strong>W3 Total Cache</strong> plugins do work when
    properly configured. Please see the Weaver II help file for instructions on
    using compatible cache plugin &rarr;. <?php weaverii_help_link('help.html#quickcache','Cache Setting for Weaver II');?>
    <p>

<?php
}

function weaverii_adv_seo_opts() {
?>
	<a name="siteopts" id="siteopts"></a>
	<label><span style="color:#00f; font-weight:bold; font-size: larger;">SEO</span></label>
	<?php weaverii_help_link('help.html#SEO','Help on SEO');?><br />
	The following options are related to SEO - Search Engine Optimization. Please note that Weaver II has been
	designed to follow the latest SEO guidelines. Each non-home page will use the recommended
	"Page Title | Site Title" format, and the site is formatted using the appropriate HTML5 tags
	for optimal SEO performance. Unless you have special needs, you probably don't need an SEO
	plugin. But if you do use an SEO plugin, be sure to check the "Use SEO plugin instead" option below
	to allow it to properly override Weaver II's own SEO features.
	<hr />

	<!-- ======== -->
        <label><span style="color:#4444CC;"><b>SEO Tags</b></span></label><br/>
	<small>Every site should have at least "description" and "keywords" meta tags
	for basic SEO support. Please edit these tags to provide more information about your site, which is inserted
	into the &lt;HEAD&gt; section of your site.</small> &diams;
	<br />

	<textarea name="<?php weaverii_sapi_advanced_name('_wii_metainfo'); ?>" rows=4 style="width: 95%"><?php echo(esc_textarea(weaverii_getopt('_wii_metainfo'))); ?></textarea>
	<br>
         <label><em>Use SEO plugin instead:</em> </label><input type="checkbox" name="<?php weaverii_sapi_advanced_name('_wii_hide_metainfo'); ?>" id="_wii_hide_metainfo" <?php checked(weaverii_getopt_checked( '_wii_hide_metainfo' )); ?> />
	<small>You will want to check this box if you are using one of the WordPress SEO plugins. If you check this box, then this meta information will not be added to your site,
	and a standard WP &lt;title&gt; compatible with SEO plugins will be used. &diams;</small>
        <br />
<?php
}
?>
