<?php
/* Weaver II - admin Main Options
 *
 * This function will start the main sapi form, which will be closed in admin-adminopts
 */

function weaverii_admin_mainopts() {
?>
<div id="tabwrap_main" style="padding-left:4px;">

<div id="tab-container-main" class='yetiisub'>
    <ul id="tab-container-main-nav" class='yetiisub'>
	<li><a href="#ogenappear" title="Wrapping background colors, rounded corners, borders, fade, shadow, search form"><?php echo(__('General Appearance', 'weaver-ii'/*a*/ )); ?></a></li>
	<li><a href="#olayout" title="Theme width, margins; Sidebar Layouts"><?php echo(__('Layout', 'weaver-ii'/*a*/ )); ?></a></li>
	<li><a href="#ofonts" title="Set fonts for various page elements."><?php echo(__('Fonts', 'weaver-ii'/*a*/ )); ?></a></li>
	<li><a href="#owidgets" title="Backgrounds, margins, borders, text colors of widgets and widget areas"><?php echo(__('Widget Areas', 'weaver-ii'/*a*/ )); ?></a></li>
	<li><a href="#oheaderopts" title="Site Title/Description properties, Header Image"><?php echo(__('Header', 'weaver-ii'/*a*/ )); ?></a></li>
	<li><a href="#omenus" title="Menu text and bg colors and other properties; Info Bar properties"><?php echo(__('Menus', 'weaver-ii'/*a*/ )); ?></a></li>
	<li><a href="#olinks" title="Colors and properties of links"><?php echo(__('Links', 'weaver-ii'/*a*/ )); ?></a></li>
	<li><a href="#ocontent" title="Text colors and bg, image borders, featured image, other properties related to all content"><?php echo(__('Content Areas', 'weaver-ii'/*a*/ )); ?></a></li>
	<li><a href="#opostspecific" title="Properties related to posts: titles, meta info, navigation, excerpts, featured images, and more."><?php echo(__('Post Specifics', 'weaver-ii'/*a*/ )); ?></a></li>
	<li><a href="#ofooter" title="Footer options: bg color, borders, more. Site Copyright."><?php echo(__('Footer', 'weaver-ii'/*a*/ )); ?></a></li>

    </ul>

<h3>Main Options<?php weaverii_help_link('help.html#MainOptions','Help for Main Options'); ?></h3>
<?php
    weaverii_sapi_submit('save_options',__('Save Settings', 'weaver-ii'/*a*/ ));
?>
    <div id="ogenappear" class="tab_mainopt" >
	<?php weaverii_mainopts_general(); ?>
    </div>

    <div id="olayout" class="tab_mainopt" >
    	<?php weaverii_mainopts_layout(); ?>
    </div>

    <div id="ofonts" class="tab_mainopt" >
    	<?php weaverii_mainopts_fonts(); ?>
    </div>

    <div id="owidgets" class="tab_mainopt" >
    	<?php weaverii_mainopts_widgets(); ?>
    </div>

    <div id="oheaderopts" class="tab_mainopt" >
	<?php weaverii_mainopts_header(); ?>
    </div>

    <div id="omenus" class="tab_mainopt" >
	<?php weaverii_mainopts_menus(); ?>
    </div>

    <div id="olinks" class="tab_mainopt" >
	<?php weaverii_mainopts_links(); ?>
    </div>
    <div id="ocontent" class="tab_mainopt" >
	<?php weaverii_mainopts_content(); ?>
    </div>

    <div id="opostspecific" class="tab_mainopt" >
	<?php weaverii_mainopts_posts(); ?>
    </div>

    <div id="ofooter" class="tab_mainopt" >
    	<?php weaverii_mainopts_footer(); ?>
    </div>

</div> <!-- #tab-container-main -->
<?php weaverii_sapi_submit('save_options',__('Save Settings', 'weaver-ii'/*a*/ )); ?>
</div>	<!-- #tabwrap_main -->
   <script type="text/javascript">
	var tabberMainOpts = new Yetii({
	id: 'tab-container-main',
	tabclass: 'tab_mainopt',
	persist: true
	});
</script>
<?php
}

// ======================== Header Options ========================
function weaverii_mainopts_general() {
    $opts = array(
    array('name' => 'General Appearance', 'id' => 'maintab0', 'type' => 'header',
	'info'=> 'Overall settings that affect content and widget areas',
            'help' => 'help.html#GenApp'),
    array('name' => 'Outside BG', 'id' => 'wii_body_bgcolor', 'type' => 'ctext',
	  'info' => 'Background color that wraps entire page. (&lt;body&gt;) Using <em>Appearance->Background</em> will override this value, or allow a background image instead.'),
    array('name' => 'Wrapper Page BG', 'id' => 'wii_page_bgcolor', 'type' => 'ctext',
	  'info' => "Background for top level #wrapper div - default BG if you don't change others."),
    array('name' => 'Default Text Color', 'id' => 'wii_body_color', 'type' => 'ctext',
	  'info' => "Default text color (&lt;body&gt;). Most areas will override this color with their own color."),
    array('name' => 'Main Area BG', 'id' => 'wii_main_bgcolor', 'type' => 'ctext',
	  'info' => 'Background for main page #main div - wraps container, content and sidebars (uses wrapper bg if not set).'),
    array('name' => 'Container Area BG', 'id' => 'wii_container_bgcolor', 'type' => 'ctext',
	  'info' => 'Background for #container div - wraps content and sidebars (uses wrapper bg if not set).'),

    array('name' => 'Rounded Corners', 'id' => 'wii_rounded_corners', 'type' => 'checkbox',
	    'info' => "Check to use rounded corners for main area, menu bars, widgetareas, header and footer"),
    array('name' => 'Rounded Corners (Content)', 'id' => 'wii_rounded_corners_content', 'type' => 'checkbox',
	    'info' => "Check to use rounded corners for content area (page and post content)"),
    array('name' => '<small>Corner Radius</small>', 'id' => 'wii_rounded_corners_radius', 'type' => 'text',
	    'info' => 'Controls how "round" corners are. Specify a value (5 to 15 look best) for corner radius. (Default: 10)'),


    array('name' => 'Fade Outside BG', 'id' => 'wii_fadebody_bg', 'type' => 'checkbox',
	    'info' => 'Will fade the Outside BG color, darker at top to lighter at bottom.'),
    array('name' => 'Wrap site with shadow', 'id' => 'wii_wrap_shadow', 'type' => 'checkbox',
	    'info' => "Will wrap site's main area with a shadow"),


    array('name' => 'Borders', 'type' =>'subheader',
	  'info' => 'Border Attributes for various areas'),
    array('name' => 'Major Area Borders', 'id' => 'wii_useborders', 'type' => 'checkbox',
            'info' => 'Check to include border around site wrapper area and all sidebars.'),
    array('name' => 'Site Wrapper Border', 'id' => 'wii_wrapper_border', 'type' => 'checkbox',
            'info' => 'Check to include border around site wrapper area (<em>Major Area Borders</em> also includes this border)'),
    array('name' => 'For Widget Areas:', 'type'=>'note',
	    'info' => 'You can set borders for individual widget areas from the <em>Widget Areas</em> tab'),
    array('name' => 'Border Attributes', 'type' =>'subheader_alt',
	  'info' => 'Border attributes apply to all areas set to show border'),
    array('name' => '<small>Border Color</small>', 'id' => 'wii_border_color', 'type' => '+color',
            'info' => 'Color of borders. (Default: #222) (Pro)'),
    array('name' => '<small>Border Width</small>', 'id' => 'wii_border_width_int', 'type' => '+val_px',
            'info' => 'Width of borders. (Default: 1px) (Pro)'),
    array('name' => '<small>Border Style</small>', 'id' => 'wii_border_style', 'type' => '+select_id',
            'info' => 'Style of borders - width needs to be > 1 for some styles to work correctly (Pro)',
	    'value' => array(
		array('val' => 'solid', 'desc'=> 'Solid' ),
		array('val' => 'dotted', 'desc'=> 'Dotted' ),
		array('val' => 'dashed', 'desc'=> 'Dashed' ),
		array('val' => 'double', 'desc'=> 'Double' ),
		array('val' => 'groove', 'desc'=> 'Groove' ),
		array('val' => 'ridge', 'desc'=> 'Ridge' ),
		array('val' => 'inset', 'desc'=> 'Inset' ),
		array('val' => 'outset', 'desc'=> 'Outset' )

		)),

    array('name' => 'Search Form', 'type' =>'subheader',
	  'info' => 'Attributes of the Search Form'),
    array('name' => 'Search Message', 'id' =>'wii_search_msg' , 'type' => '+widetext', //code - option done in code
	  'info' => 'New default search message. (Default: Search Site) (Pro)'),
    array('name' => 'Use Go Button', 'id' =>'wii_go_button' , 'type' => '+checkbox',	//code
	  'info' => 'Use "Go" button instead of default "magnifier" button. (Pro)'),
    array('name' => '<small>Search Button URL</small>', 'id' =>'_wii_search_button_url' , 'type' => '+textmedia', //code
	  'info' => 'URL for replacement Search Button image. Should be 20px by 20px. (Default: Magnifier) (Pro) &diams;'),
    array('name' => '', 'type'=>'note',
	    'info' => 'Note: &diams; indicates options saved only with full backup save'),

    array('name' => 'Style Sheet', 'type' =>'subheader',
	  'info' => 'Advanced Option: Use alternative style sheet'),

    array('name' => 'Use style-minimal.css', 'id'=>'wii_minimial_style', 'type' =>'checkbox',
	  'info' => 'Use the alternative "style-minimal.css" style sheet instead of the standard "style.css". Most useful when used for custom themes based on the "Blank" sub-theme. Using this style sheet will likely "break" other sub-themes.'),
    array ('name' => '<small>Custom Replacement CSS File</small>', 'id' => 'wii_custom_style', 'type' => 'textarea',
	   'info' => 'Advanced Option. Specify URL for custom .css file to replace theme standard style.css. Ideally, save file in media library. Will survive theme updates.'),
    );

    weaverii_form_show_options($opts);
}

function weaverii_mainopts_header() {
    $opts = array(
    array('name' => 'Header Options', 'id' => 'maintab1', 'type' => 'header',
            'info' => 'Options affecting site Header',
            'help' => 'help.html#HeaderOpt'),
    array('name' => 'Header BG', 'id' => 'wii_header_bgcolor', 'type' => 'ctext',
            'info' => 'Background for the header area.'),
    array('name' => 'Header Padding: Top/Bottom', 'id' => 'hdr_headertop_padding_', 'type' => 'text_tb',
            'info' => 'Padding at top/bottom of header. (Default: 20/0)'),
    array('name' => '<small>Space After Header</small>', 'id' => 'wii_after_header_int', 'type' => 'val_px',
	    'info' => 'Change the space between Header and Body'),

    array('name' => 'Site Title/Description', 'type' =>'subheader', 'info' => 'Settings related to the Site Title and Description'),
    array('name' => 'Site Title', 'id' => 'wii_title_color', 'type' => 'ctext',
	    'info' => "The site's main title in the header (blog title)"),
    array('name' => 'Site Title Font Size', 'id' => 'wii_title_font_size', 'type' => 'val_percent',
	    'info' => "Title font size (default: 300%)"),
    array('name' => 'Site Description', 'id' => 'wii_desc_color', 'type' => 'ctext',
	    'info' => "The site's description tag line (blog description)"),
    array('name' => 'Site Description Font Size', 'id' => 'wii_desc_font_size', 'type' => 'val_percent',
	    'info' => 'Title font size (default: 133%).'),
    array('name' => 'Hide Site Title/Description', 'id' => 'wii_hide_site_title', 'type' => 'checkbox',
	    'info' => 'Check to hide display of Site Title and Description (Uses "display:none;" to hide.)'),

    array('name' => 'Move Title over Header Image', 'id' => 'wii_title_on_header', 'type' => 'checkbox',
	    'info' => 'Check to move the site Title and Description over the Header Image.'),
    array('name' => '<small>Title Indents</small>', 'id' => 'wii_title_on_header_xy', 'type' => 'text_xy',
	    'info' => 'Adjust default left and top indents for Title over Header Image. (default: x:40, y:44)'),
    array('name' => '<small>Description Indents</small>', 'id' => 'wii_title_on_header_xy_desc', 'type' => 'text_xy',
	    'info' => 'Adjust default left and top indents for Description over Header Image. (default: x:40, y:90)'),

    array('name' => 'Header Image', 'type' =>'subheader', 'info' => 'Settings related to standard header image'),
    array('name' => 'Header Image Height', 'id' => 'wii_header_image_height_int', 'type' => 'val_px',
	    'info' => 'Change the default height of the Header Image. Standard size is 188. Upload new images in Appearance&rarr;Header <u>after</u> changing height. Previously uploaded images will retain their old height.'),
    array('name' => 'Hide Header Image', 'id' => 'wii_hide_header_image', 'type' => 'checkbox',
	    'info' => 'Check to hide display of standard header image on all pages.'),
    array('name' => '<small>Hide Header Image on Normal View</small>', 'id' => 'wii_normal_hide_header_image', 'type' => 'checkbox',
	    'info' => 'Check to hide display of standard header image when site viewed on normal devices (non-Mobile).'),
    array('name' => '<small>Hide Header Image on Mobile View</small>', 'id' => 'wii_mobile_hide_header_image', 'type' => 'checkbox',
	    'info' => 'Check to hide display of standard header image when site viewed on mobile device.'),
    array('name' => '<small>Hide Header Image Front Page</small>', 'id' => 'wii_hide_header_image_front', 'type' => 'checkbox',
	    'info' => 'Check to hide display of standard header image on front page only. (Also see Show Header Widget Area on Front Page.)'),


    array('name' => '<small>Header Image Links to Site</small>', 'id' => 'wii_link_site_image', 'type' => 'checkbox',
	    'info' => 'Check to add a link to site home page for Header Image'),

    array( 'name' => '<small>Hide Featured Image for Header</small>', 'id' => 'wii_hide_featured_header', 'type' => 'checkbox',
	    'info' => 'Hide the "Featured Image" (set in Post/Page edit) from appearing as the header image. (Also see "Show Featured Image in Posts").'),

    array( 'type' => 'submit'),

    array('name' => 'Header Widget Area', 'type' =>'subheader', 'info' => 'Settings for Header Horizontal Widget Area',
	  'help' => 'help.html#HeaderWidgetArea'),
    array('name' => 'Area BG', 'id' => '_wii_hdr_widg_bgcolor', 'type' => 'ctext',
        'info' => 'Background for the header horizontal widget area. &diams;'),
    array('name' => 'Area Font Size', 'id' => '_wii_hdr_widg_fontsize', 'type' => 'val_percent',
	'info' => 'Header Widget Area font size (default: 100%). &diams;'),
    array('name' => 'Area Height', 'id' => '_wii_hdr_widg_h_int', 'type' => 'val_px',
	    'info' => 'Header widget area height. (default:tallest widget) &diams;'),
    array('name' => '<small>Show on Front Page Only</small>', 'id' => '_wii_hdr_widg_frontpage', 'type' => 'checkbox',
	    'info' => 'Display the header widget area on the front page only. (Also see Hide Header Image on Front Page.) &diams;'),
    array('name' => '<small>Hide Entire Area for Normal View</small>', 'id' => '_wii_hdr_widg_hide_normal', 'type' => 'checkbox',
	  'info' => 'Hide entire header widget area on all pages of normal view (non-Mobile devices). &diams;' ),
    array('name' => '<small>Hide Entire Area for Mobile View</small>', 'id' => '_wii_hdr_widg_hide_mobile', 'type' => 'checkbox',
	  'info' => 'Hide entire header widget area for mobile devices. &diams;' ),
    array('name' => 'Header Widget Area Widgets', 'type' =>'subheader', 'info' => 'Settings for widgets within Header Widget Area (Entire section: &diams;)'),

    array('name' => 'First', 'id' => '_wii_hdr_widg_1', 'type' => 'hdr_widget',
	  'info' => '' ),
    array('name' => 'Second', 'id' => '_wii_hdr_widg_2', 'type' => 'hdr_widget',
	  'info' => '' ),
    array('name' => 'Third', 'id' => '_wii_hdr_widg_3', 'type' => 'hdr_widget',
	  'info' => '' ),
    array('name' => 'Fourth', 'id' => '_wii_hdr_widg_4', 'type' => 'hdr_widget',
	  'info' => '' ),
    array('name' => 'Header Widget Padding:', 'id' => 'wii_headern2', 'type' => 'note',
	    'info' => 'To add padding to a widget, use widget\'s "CSS+" and add "{padding:5px 5px 5px 5px;}" - adjust values as needed.'),

    // bg color, font size, min height, max-width; margins?, 1: bg, %, 2:bg, %, 3: bg, %, 4: bg, % bg-image?

    array('name' => 'Advanced', 'type' =>'subheader', 'info' => 'Settings for more advanced users'),
    array('name' => '<small>Header Width (read description!!)</small>', 'id' => 'wii_header_width_int', 'type' => 'val_px',
	    'info' => 'WARNING - this is an advanced option. Leave blank unless you understand what will happen. It will break your mobile view. If set to larger than Theme Width, will make the Header (#branding) wider than Container (#container) area. Caution: this will create a fixed width area, and will not work as you might expect on mobile devices.'),
    array('name' => '<small>Header &lt;div> First</small>', 'id' => 'wii_header_first', 'type' => '+checkbox', //code
	    'info' => 'Place Header  &lt;header> #branding div first - before #wrapper. Advanced option: requires custom CSS to be used effectively. (Pro)'),
    array('name' => 'Note:', 'id' => 'wii_headern1', 'type' => 'note',
	    'info' => 'There are more Header options available on the Dashboard Appearance->Header panel.')
    );

    weaverii_form_show_options($opts);
}

function weaverii_mainopts_menus() {
    $opts = array(
    array('name' => 'Menu Bar and Info Bar', 'id' => 'maintab2', 'type' => 'header',
            'info' => 'Options affecting site Menus and the Info Bar',
            'help' => 'help.html#MenuBar'),
    array('name' =>'Menu Bar','type'=>'subheader',
	    'info' => 'Attributes of main menu bar (Primary, Secondary, and main extra menu)'),
    array('name' => 'Menu Bar BG', 'id' => 'wii_menubar_bgcolor', 'type' => 'ctext',
	    'info' => 'The main menu bar background color'),
    array('name' => 'Menu Bar text', 'id' => 'wii_menubar_text_color', 'type' => 'ctext',
	    'info' => 'Main menu bar text item when not hovering'),
    array('name' => 'Menu Bar hover BG', 'id' => 'wii_menubar_hover_bgcolor', 'type' => 'ctext',
	    'info' => 'The menu item background when hovering over item.'),
    array('name' => 'Menu Bar hover text', 'id' => 'wii_menubar_hover_color', 'type' => 'ctext',
	    'info' => 'Main menu bar text item when hovering'),
    array('name' => '<small>Bold Menu Text</small>', 'id' => 'wii_bold_menu', 'type' => 'checkbox',
	    'info' => 'Check to use bold font style for menu text.'),
    array('name' => '<small>Italic Menu Text</small>', 'id' => 'wii_italic_menu', 'type' => 'checkbox',
	    'info' => 'Check to use italic font style for menu text.'),
    array('name' => 'Use Alternate Slide Open Menu', 'id' => 'wii_slide_open_menu', 'type' => 'checkbox',
	    'info' => "Use alternate style Slide Open Menu instead of Pull Down Menu. (The same Slide Open Menu as used for mobile phone view.)"),


    array('name' =>'Sub-Menu Drop Downs','type'=>'subheader_alt',
	    'info' => 'Attributes of menu drop downs'),
    array('name' => 'Sub-Menu Item BG', 'id' => 'wii_submenubar_bgcolor', 'type' => 'ctext',
	    'info' => 'The sub-menu drop down items'),

    array('name' => 'Sub-Menu text', 'id' => 'wii_submenubar_text_color', 'type' => 'ctext',
	    'info' => 'Sub-menu bar text item when not hovering'),
    array('name' => 'Sub-Menu hover BG', 'id' => 'wii_submenubar_hover_bgcolor', 'type' => 'ctext',
	    'info' => 'The submenu drop down background when hovering over item.'),
    array('name' => 'Sub Menu text hover', 'id' => 'wii_submenubar_hover_color', 'type' => 'ctext',
	    'info' => 'Sub-menu drop down text item when hovering'),
    array('name' => '<small>Bold Sub-Menu Text</small>', 'id' => 'wii_bold_submenu', 'type' => 'checkbox',
	    'info' => 'Check to use bold font style for sub-menu text.'),
    array('name' => '<small>Italic Sub-Menu Text</small>', 'id' => 'wii_italic_submenu', 'type' => 'checkbox',
	    'info' => 'Check to use italic font style for sub-menu text.'),

    array('name' =>'Current Page','type'=>'subheader_alt',
	    'info' => 'Attributes of menu text when indicating current page and its ancestors'),
    array('name' => 'Current Page Text', 'id' => 'wii_menubar_curpage_color', 'type' => 'ctext',
	    'info' => 'Color for the currently displayed page and its ancestors.'),
    array('name' => '<small>Bold Current Page</small>', 'id' => 'wii_menubar_curpage_bold', 'type' => 'checkbox',
	    'info' => 'Bold Face Current Page and ancestors'),
    array('name' => '<small>Italic Current Page</small>', 'id' => 'wii_menubar_curpage_em', 'type' => 'checkbox',
	    'info' => 'Italic Current Page and ancestors'),

    array( 'type' => 'submit'),

    array('name' => 'Mobile', 'type' => 'subheader_alt',
	    'info' => 'Options for Mobile Menus'),
    array('name' => 'Use Pull Down Menu on Phones', 'id' => 'wii_mobile_pulldown_menu', 'type' => 'checkbox',
	    'info' => "Use Pull Down Menu for smart Phone view (same menu as tablets and standard browser). (Default: Slide Open vertical menu)"),
    array('name' => '<small>Hide Right Menu Extras</small>', 'id' => 'wii_mobile_hide_menu_extras', 'type' => 'checkbox',
	    'info' => "Hide right side menu extras on Slide Open Phone Menu - html right, social buttons, search, and login."),
    array('name' => '<small>Text for Home label</small>', 'id' =>'wii_mobile_slide_home_label' , 'type' => 'widetext',
	  'info' => 'This lets you change the Home label on the phone slide open menu bar. (Default: Home)'),
    array('name' => '<small>Text for Menu label</small>', 'id' =>'wii_mobile_slide_nav_label' , 'type' => 'widetext',
	  'info' => 'This lets you change the Menu label on the phone slide open menu bar. (Default: Menu)'),
    array('name' => '<small>Hide Menu Bars for Mobile</small>', 'id' => 'wii_mobile_hide_menu', 'type' => 'checkbox',
	    'info' => "Hide Menu Bars on Mobile View - be sure to provide alternative navigation if you hide them."),
    array('name' => '<small>Hide Secondary Menu Bar for Mobile</small>', 'id' => 'wii_mobile_hide_secondary_menu', 'type' => 'checkbox',
	    'info' => "Hide just the secondary menu on mobile <em>phone</em> view."),

    array('name' => 'Extras', 'type' => 'subheader_alt',
	    'info' => 'Menu Bar enhancements and features'),

    array('name' => 'Menu Bar Gradient', 'id' => 'wii_gradient_menu', 'type' => 'checkbox',
	    'info' => 'Check to add gradient effect to menu bars'),
    array('name' => 'Menu Bar Shadow', 'id' => 'wii_menu_shadow', 'type' => 'checkbox',
	    'info' => 'Add a slight shadow to the Menu Bar. (Does\'t display on older IE versions.)'),
    array('name' => 'Use Menu Effects', 'id' => 'wii_use_superfish', 'type' => 'checkbox',
	    'info' => 'Check to use Menu Effects: arrows for sub-menus, shadows, smooth open'),
    array('name' => __('<small>Arrow color</small>', 'weaver-ii'/*a*/ ), 'id' => 'wii_superfish_arrows', 'type' => 'select_id',
	  'info' => __('Select color for arrow used with Menu Effects', 'weaver-ii'/*a*/ ),
	  'value' => array(
			   array('val' => 'ffffff', 'desc'=> 'White Arrows' ),
			   array('val' => 'c0c0c0', 'desc'=> 'Light Gray Arrows' ),
			   array('val' => '7f7f7f', 'desc' => 'Gray Arrows'),
			   array('val' => '404040', 'desc'=> 'Dark Gray Arrows' ),
			   array('val' => '000000', 'desc' => 'Black Arrows')
		)),

    array('name' => 'Add Search to Menu Bar', 'id' => 'wii_menu_addsearch', 'type' => 'checkbox',
	    'info' => "Add a search box to Primary menu bar on right."),
    array('name' => 'Add Log in to Menu Bar', 'id' => 'wii_menu_addlogin', 'type' => 'checkbox',
	    'info' => "Add a simple Log In link to Primary menu bar on right."),

    array('name' => '<small>Move Primary Menu to Top</small>', 'id' => 'wii_move_menu', 'type' => 'checkbox',
	    'info' => 'Move the Primary Menu to above the image (Secondary Menu will be on bottom)'),

    array('name' => '<small>Hide Menu Bars</small>', 'id' => 'wii_hide_menu', 'type' => 'checkbox',
	    'info' => "Don't want menu bars? Hide them. (If empty, Primary or Secondary custom menus won't display.)"),
    array('name' => '<small>No Home Menu Item</small>', 'id' => 'wii_menu_nohome', 'type' => 'checkbox',
	    'info' => 'Don\'t automatically add Home menu item for home page (as defined in Settings->Reading)'),

    array('name' => 'Add HTML to Menu Bar', 'type' => 'subheader_alt',
	    'info' => 'Add HTML to the left or right end of the primary menu bar.'),
    array('name' => '', 'type' => 'note',
	  'info' => 'The HTML can include images, links, text, and shortcodes. The maximum height for images is 24px. Add <em>style="top:2px"</em>
		to the &lt;img&gt; tag, and adjust the 2px as needed. Wrap text in &lt;span class="add-text"&gt;text&lt;span&gt; for proper centering.'),
    array('name' => 'Add HTML to Left', 'id' => 'wii_menu_addhtml-left', 'type' => 'textarea',
	  'info' => 'Add HTML to left end of menu bar.'),
    array('name' => 'Add HTML to Right', 'id' => 'wii_menu_addhtml', 'type' => 'textarea',
	  'info' => 'Add HTML to right end of menu bar.'),

    array('name' => 'Menu Bar Layout', 'type' => 'subheader_alt',
	    'info' => 'Additional settings for menubar look'),
    array('name' => 'Menu Bar Height', 'id' => 'wii_menu_height_int', 'type' => '+val_px',
	    'info' => 'Height of Menu Bar. Non-default value won\'t work well with gradient. (Default: 38px) (Pro)'),
    array ('name' => 'Menu Item Padding', 'id' =>'wii_menu_spacing_int', 'type' => '+val_px',
	    'info' => 'Adjust padding between menu bar items. Determines separation of menu items. (Default: 10px) (Pro)'),
    array('name' => 'Menu Left Padding (primary)', 'id' => 'wii_menu_leftpad_int', 'type' => '+val_px',
	    'info' => 'You can adjust the position of the primary menu items by adding left padding. (Pro)'),
    array ('name' => 'Menu Left Padding (secondary)','id' => 'wii_menu_leftpad2_int', 'type' => '+val_px',
	    'info' => 'You can adjust the position of the secondary menu items by adding left padding (in px). (Pro)'),

    array ('name' => 'Separator Bars on Menus', 'id' => 'wii_menubar_sep', 'type' => '+checkbox',
	    'info' => 'Add vertical separator bars between items on menu bars. (Pro)'),
    array ('name' => 'Separator Bars on Sub-Menus', 'id' => 'wii_submenu_bars', 'type' => '+checkbox',
	    'info' => 'Add horizontal separator bars between items on sub-menu drop downs. (Pro)'),
    array ('name' => 'Dotted Separator on Sub-Menus', 'id' => 'wii_submenu_dotted', 'type' => '+checkbox',
	    'info' => 'Add horizontal dotted separator line on sub-menu drop downs. This and Separator bars don\'t mix. (Pro)'),

    array ('name' => 'Separator Bar Width','id' => 'wii_separator_width_int','type' => '+val_px',
	    'info' => 'Width of separator bars in px, if used. (Default: 2px) (Pro)'),
    array ('name' => 'Fixed Width Menu Items', 'id' =>'wii_menu_liwidth', 'type' => '+val_px',
	    'info' => 'Make each menu bar item fixed width in px. Should be wide enough for widest text item. (Default: not fixed, try more than 40px) (Pro)'),

    array( 'type' => 'submit'),

    array('name' => 'Info Bar', 'id'=>'', 'type' => 'subheader',
	  'info' => 'Options for the top Info Bar'),
    array('name' => 'Hide Info Bar', 'id'=>'wii_infobar_hide', 'type' => 'checkbox',
	  'info' => 'Do not display the Info Bar'),
    array('name' => 'Hide Breadcrumbs', 'id'=>'wii_info_hide_breadcrumbs', 'type' => 'checkbox',
	  'info' => 'Do not display the Breadcrumbs'),
    array('name' => 'Hide Page Navigation', 'id'=>'wii_info_hide_pagenav', 'type' => 'checkbox',
	  'info' => 'Do not display the numbered Page navigation'),
    array('name' => 'Show Search box', 'id'=>'wii_info_search', 'type' => 'checkbox',
	  'info' => 'Include a Search box on the right'),
    array('name' => 'Show Log In', 'id'=>'wii_info_addlogin', 'type' => 'checkbox',
	  'info' => 'Include a simple Log In link on the right'),
     array('name' => 'Info Bar Location', 'id' => 'wii_infobar_location', 'type' => 'select_id',
	  'info' => 'Infobar can be placed after the menu bar before sidebars and content, or right before content area',
	  'value' => array(
			   array('val' => 'top', 'desc'=> 'After Menu Bar' ),
			   array('val' => 'content', 'desc'=> 'Above Content Area' )
		)),
    array('name' => 'Breadcrumb for Blog', 'id' =>'wii_info_blog_label' , 'type' => 'widetext', //code - option done in code
	  'info' => 'This lets you change the breadcrumb label for your blog page. (Default: Blog)'),
    array('name' => 'Breadcrumb for Home', 'id' =>'wii_info_home_label' , 'type' => 'widetext', //code - option done in code
	  'info' => 'This lets you change the breadcrumb label for your home page. (Default: Home)'),

    array('name' => 'Add HTML', 'id'=>'', 'type' => 'subheader_alt',
	  'info' => 'Add HTML to Info Bar - can include shortcodes'),
    array('name' => 'Left HTML', 'id'=>'wii_info_html1', 'type' => '+textarea',	//code
	  'info' => 'Add HTML code to left end of Info Bar (Pro)'),
    array('name' => 'Middle HTML', 'id'=>'wii_info_html2', 'type' => '+textarea',	//code
	  'info' => 'Add HTML code to middle of Info Bar (Pro)'),
    array('name' => 'Right HTML', 'id'=>'wii_info_html3', 'type' => '+textarea',	//code
	  'info' => 'Add HTML code to right end of Info Bar (Pro)'),
    array('name' => 'Info Bar Attributes', 'id'=>'', 'type' => 'subheader_alt',

	  'info' => 'Additional Attributes for Info Bar'),
    array('name' => 'Background', 'id' => 'wii_infob_bgcolor', 'type' => 'ctext',
	  'info' => 'Background color for Info Bar'),
    array('name' => 'Text Color', 'id' => 'wii_infob_color', 'type' => 'ctext',
	  'info' => 'Text color for Info Bar'),
    array('name' => '<small>Top/Bottom Padding</small>', 'id' => 'wii_infob_padding', 'type' => 'text_tb',
	  'info' => 'Top and Bottom padding for Info Bar'),
    array('name' => '<small>Left/Right Padding</small>', 'id' => 'wii_infob_padding', 'type' => 'text_lr',
	  'info' => 'Left and Right padding for Info Bar'),
    );

    weaverii_form_show_options($opts);

}

function weaverii_mainopts_links() {
    /* other links to consider:
      .page-link a

    */
    $opts = array(
    array('name' => 'Links', 'id' => 'mainopts_links', 'type' => 'header',
        'info'=> 'Color attributes for links',
	'help' => 'help.html#Links'),

    array('name' => 'Standard Link', 'id' => 'wii_link', 'type' => 'link',
	    'info' => 'Default for links - colors used if not overridden by other link settings. Bold, Italic, and Underline are set per link type.'),

    array('name' => 'Post Entry Title Link', 'id' => 'wii_plink', 'type' => 'link',
	  'info' => 'Post entry title link color (Remember: blog entry titles are links).'),

    array('name' => 'Post Info Link', 'id' => 'wii_ilink', 'type' => 'link',
	    'info' => 'Links in post information top and bottom lines.'),

    array('name' => 'Widget Link', 'id' => 'wii_wlink', 'type' => 'link',
	    'info' => 'Color for links in widgets (uses Standard Link colors if left blank).'),

    array('name' => 'Info Bar Link', 'id' => 'wii_ibarlink', 'type' => 'link',
	    'info' => 'Color for links in Info Bar (uses Standard Link colors if left blank).'),

    array('name' => 'Footer Link', 'id' => 'wii_footerlink', 'type' => 'link',
	    'info' => 'Color for links in Footer (includes footer widgets; uses Standard Link colors if left blank).'),

    array('name' => 'Additional Option', 'type'=> 'header_alt',
	  'info' => 'Additional Options for Links'),
    array('name' => 'Hide Menu/Link Tool Tips', 'id' => 'wii_hide_tooltip', 'type' => '+checkbox',
	  'info' => 'Hide the tool tip pop up over all menus and links. (Pro)')

    );

    weaverii_form_show_options($opts);
}

function weaverii_mainopts_content() {
    $opts = array(
    array('name' => 'Content Areas', 'id' => 'maintab2', 'type' => 'header',
        'info'=> 'Settings for the content area (posts and pages)',
	'help' => 'help.html#ContentAreas'),

    array('name' => 'Text','type'=>'subheader_alt',
	  'info' => 'Text related options'),
    array('name' => 'Content BG', 'id' => 'wii_content_bgcolor', 'type' => 'ctext',
	    'info' => 'Background for post and page #content div (uses main bg if not set).'),
    array('name' => '<small>Page/Post Editor BG</small>', 'id' => 'wii_editor_bgcolor', 'type' => 'ctext',
	    'info' => 'Alternative Background Color to use for Page/Post editor if you\'re using transparent or image backgrounds.'),
    array('name' => 'Content text', 'id' => 'wii_content_color', 'type' => 'ctext',
	    'info' => 'Main post and page content text.'),
    array('name' => 'Heading text', 'id' => 'wii_content_headings_color', 'type' => 'ctext',
	    'info' => 'Content non-title headings and other labels'),
    array('name' => 'Page Title Text', 'id' => 'wii_page_title_color', 'type' => 'ctext',
	    'info' => "Main Title for static pages (note: post title is 'Post Entry Title Link')"),
    array('name' => '<small>Page/Post Title Font size</small>', 'id' => 'wii_entrytitle_size_int', 'type' => 'val_percent',
	  'info' => 'Font size for Post and Page titles. (Default: 150%)'),

    array('name' => '<small>Bar under Titles</small>', 'id' => 'wii_header_underline_int', 'type' => 'val_px',
	    'info' => 'Enter size in px if you want a bar under page and post Titles. Leave blank or 0 for no bar.'),
    array('name' => '<small>Input Area BG</small>', 'id' => 'wii_input_bgcolor', 'type' => 'ctext',
	    'info' => 'Background color for text input (search, textareas) boxes.'),
    array('name' => '<small>Input Area Text</small>', 'id' => 'wii_input_color', 'type' => 'ctext',
	    'info' => 'Text color for text input (search, textareas) boxes.'),

    array('name' => 'Padding', 'type'=>'subheader_alt',
	  'info' => 'Padding around content area (adds extra space around edges)'),
    array('name' => 'Content Top/Bottom Padding', 'id' => 'wii_content_padding', 'type' => 'text_tb',
	  'info' => 'Top and Bottom padding for content area'),
    array('name' => 'Content Left/Right Padding', 'id' => 'wii_content_padding', 'type' => 'text_lr',
	  'info' => 'Left and Right padding for content area'),

    array('name' => 'Images', 'type'=>'subheader_alt',
	  'info' => 'Image related options'),
    array('name' => '<small>Image Border Color</small>', 'id' => 'wii_media_lib_border_color', 'type' => 'ctext',
	    'info' => 'Border color for images from media library.'),
    array('name' => '<small>Image Border Width</small>', 'id' => 'wii_media_lib_border_int', 'type' => 'val_px',
	    'info' => 'Border width for images from media library.'),
    array('name' => '<small>No Image Borders', 'id' => 'wii_hide_img_borders', 'type' => 'checkbox',
	  'info' => 'Do not use borders or shadows on images.'),
    array('name' => '<small>No Image Shadows', 'id' => 'wii_hide_img_shadows', 'type' => 'checkbox',
	  'info' => 'Do not use shadows on images. Borders retained if previous option not checked.'),
    array('name' => '<small>Caption text color</small>', 'id' => 'wii_caption_color', 'type' => 'ctext',
	    'info' => 'Color of captions - e.g., below media images.'),

    array('name' => 'Featured Image', 'type'=>'subheader_alt',
	  'info' => 'Featured Image related options'),
    array('name' => '<small>Hide Featured Image on Pages', 'id' => 'wii_hide_page_featured', 'type' => 'checkbox',
	  'info' => 'Hide any small Featured Image associated with a Page (Posts have their own setting.)'),
     array('name' => '<small>Featured Image Width, Pages</small>', 'id' => 'wii_featured_page_width', 'type' => 'val_px',
            'info' => 'Width of Featured Image when shown on pages. Height will remain proportional.' ),


    array('name' => 'Misc', 'type'=>'subheader_alt',
	  'info' => 'Other options related to content'),
    array ('name' => 'Content List Bullet',
	   'id' => 'wii_contentlist_bullet', 'type' => 'select_id', 'info' => 'Bullet used for Unorderd Lists in Content areas',
	    'value' => array(
			   array('val' => 'disc', 'desc' => 'Filled Disc (default)'),
			   array('val' => 'circle', 'desc' => 'Circle'),
			   array('val' => 'square', 'desc' => 'Square'),
			   array('val' => 'none', 'desc' => 'None'),
			   array('val' => 'custom', 'desc' => 'Custom bullet')
			   )
	  ),
    array ('name' => '<small>Custom Bullet URL</small>', 'id' => 'wii_contentlist_bullet_custom_url', 'type' => '+textmedia', //code
	   'info' => 'URL for "Custom" bullet image (Pro)'),

    array('name' => '&lt;HR&gt; color', 'id' => 'wii_hr_color', 'type' => 'ctext',
	    'info' => 'Color of horizontal (&lt;hr&gt;) lines in posts and pages.'),

    array ('name' => 'Table Style', 'id' => 'wii_weaverii_tables', 'type' => 'select_id',
	    'info' => 'Style used for tables in content.',
	    'value' => array(
			   array('val' => 'default', 'desc' => 'Theme Default'),
			   array('val' => 'bold', 'desc' => 'Bold Headings'),
			   array('val' => 'noborders', 'desc' => 'No Borders'),
			   array('val' => 'fullwidth', 'desc' => 'Wide'),
			   array('val' => 'wide', 'desc' => 'Wide 2'),
			   array('val' => 'plain', 'desc' => 'Minimal')
			   )
	  ),

    array('name' => 'Comments', 'type' => 'subheader',
	  'info' => 'Settings for displaying comments'),
    array('name' => 'Comment Headings', 'id' => 'wii_comment_headings_color', 'type' => 'ctext',
	  'info' => 'Color for various headings in comment form'),
    array('name' => 'Comment Content BG', 'id' => 'wii_comment_content_bgcolor', 'type' => 'ctext',
	  'info' => 'BG Color of Comment Content area'),
    array('name' => 'Comment Submit Button BG', 'id' => 'wii_comment_submit_bgcolor', 'type' => 'ctext',
	  'info' => 'BG Color of "Post Comment" submit button'),
    array('name' => '<small>Show Allowed HTML</small>', 'id' => 'wii_form_allowed_tags', 'type' => 'checkbox',
	  'info' => 'Show the allowed HTML tags below comment input box'),
    array('name' => '<small>Hide Comment Title Icon</small>', 'id' => 'wii_hide_comment_bubble', 'type' => 'checkbox',
	  'info' => 'Hide the comment icon before the Comments title'),
    array('name' => '<small>Hide Separator Above Comments</small>', 'id' => 'wii_hide_comment_hr', 'type' => 'checkbox',
	  'info' => 'Hide the (&lt;hr&gt;) separator line above the Comments area'),
    array('name' => '<small>Hide Comment Borders</small>', 'id' => 'wii_hide_comment_borders', 'type' => 'checkbox',
	  'info' => 'Hide Borders around comment sections'),

    );

    weaverii_form_show_options($opts);
?>
    <label><span style="color:green;"><b>Hiding/Enabling Page and Post Comments</b></span></label>
<?php
    weaverii_help_link('help.html#LeavingComments',__('Help for Leaving Comments', 'weaver-ii'/*a*/ ));
?>
    <p>Controlling "Reply/Leave a Comment" visibility for pages and posts is <strong>not</strong> a theme function. It is
    controlled by WordPress settings. Please click the ? just above to see the help file entry!</p>
<?php
}

function weaverii_mainopts_posts() {
    $opts = array(
    array('name' => 'Post Page Specifics', 'id' => 'maintab3', 'type' => 'header',
        'info'=> 'Settings affecting just Post pages',
	'help' => 'help.html#PPSpecifics'),

    array('name' => 'Post BG', 'id' => 'wii_post_bgcolor', 'type' => 'ctext',
	    'info' => 'Background color used for posts.'),
    array('name' => '<small>Post Top/Bottom Padding</small>','id' => 'wii_post_padding', 'type' => 'text_tb',
	  'info' => 'Top and Bottom padding for Posts - most useful if bg color specified'),
    array('name' => '<small>Post Left/Right Padding</small>','id' => 'wii_post_padding', 'type' => 'text_lr',
	  'info' => 'Left and right padding for Posts - most useful if bg color specified'),
    array('name' => 'Sticky Post BG', 'id' => 'wii_stickypost_bgcolor', 'type' => 'ctext',
	    'info' => 'BG color for sticky posts, author info. (Add {border:none;padding:0;} to CSS to make sticky posts same as regular posts.)'),
    array('name' => 'Columns of Posts', 'id' => 'wii_blog_cols', 'type' => '+select_id',	//code
	  'info' => 'Display posts on blog page with this many columns (Pro)',
	  'value' => array(
			   array('val' => '1', 'desc' => '1 Column'),
			   array('val' => '2', 'desc' => '2 Columns'),
			   array('val' => '3', 'desc' => '3 Columns')
		)
	  ),

    array('name' => 'Post Title Area', 'type' => 'subheader_alt',
	  'info' => 'Post title area options'),

    array('name' => '"Post Format" Title', 'id' => 'wii_post_format_color', 'type' => 'ctext',
	    'info' => 'Color for the Post Format Title displayed on posts with Format specified.'),
    array('name'=>'Post Title:','type'=>'note','info'=>'Please use "Links:Post Entry Title Link" to set post title color.'),
    array('name' => 'Hide Comment Bubble', 'id' => 'wii_hide_post_bubble', 'type' => 'checkbox',
	    'info' => "Hide the comment bubble displayed on the post info line"),
    array('name' => '<small>Show avatar with posts</small>', 'id' => 'wii_show_post_avatar', 'type' => 'checkbox',
            'info' => 'Show author avatar at top of posts (also can be set per post with post editor)'),
    array('name' => '<small>Make avatar tiny</small>', 'id' => 'wii_show_tiny_avatar', 'type' => 'checkbox',
            'info' => 'Make the avatar tiny and display right after author name. (Must check "Show avatar", too.)'),
    array('name' => '<small>Post Title - no link</small>', 'id' => 'wii_post_no_titlelink', 'type' => '+checkbox', //code
	  'info' => 'Don\'t make post titles a link. (Pro)'),

    array('name' => 'Navigation', 'type' => 'subheader_alt',
	  'info' => 'Navigation for pages displaying posts'),
    array('name' => 'Blog Navigation Style', 'id' => 'wii_nav_style', 'type' => 'select_id',
	  'info' => 'Style of navigation links on blog pages: "Older/Newer posts", "Previous/Next Post", or by page numbers',
	  'value' => array(
			   array('val' => 'old_new', 'desc' => 'Older/Newer'),
			   array('val' => 'prev_next', 'desc' => 'Previous/Next'),
			   array('val' => 'paged_left', 'desc' => 'Paged - Left'),
			   array('val' => 'paged_right', 'desc' => 'Paged - Right')
		)
	  ),
    array('name' => '<small>Hide Top</small>', 'id' => 'wii_nav_hide_above', 'type' => 'checkbox',
	  'info' => 'Hide the blog navigation links at the top'),
    array('name' => '<small>Hide Bottom</small>', 'id' => 'wii_nav_hide_below', 'type' => 'checkbox',
	  'info' => 'Hide the blog navigation links at the bottom'),
    array('name' => '<small>Show Top on First Page</small>', 'id' => 'wii_nav_show_first', 'type' => 'checkbox',
	  'info' => 'Show navigation at top even on the first page'),

    array('name' => 'Single Page Navigation Style', 'id' => 'wii_single_nav_style', 'type' => 'select_id',
	  'info' => 'Style of navigation links on post Single pages: Previous/Next, by title, or none',
	  'value' => array(
			   array('val' => 'title', 'desc' => 'Post Titles'),
			   array('val' => 'prev_next', 'desc' => 'Previous/Next'),
			   array('val' => 'hide', 'desc' => 'None - no display')
		)
	  ),
    array('name' => '<small>Hide Top</small>', 'id' => 'wii_single_nav_hide_above', 'type' => 'checkbox',
	  'info' => 'Hide the single page navigation links at the top'),
    array('name' => '<small>Hide Bottom</small>', 'id' => 'wii_single_nav_hide_below', 'type' => 'checkbox',
	  'info' => 'Hide the single page navigation links at the bottom'),

    array('name' => 'Post Meta Info Areas', 'type' => 'subheader_alt',
	  'info' => 'Top and Bottom Post Meta Information areas'),
    array('name' => 'Post Info text', 'id' => 'wii_info_color', 'type' => 'ctext',
	    'info' => 'Color for post information text. (also called Meta Info)'),
    array('name' => 'Top Post Info BG', 'id' => 'wii_infotop_bgcolor', 'type' => 'ctext',
	    'info' => "The top post info area ('Posted on x by y' line - add {display:none;} to CSS to hide entire line.)"),

    array('name' => 'Bottom Post Info BG', 'id' => 'wii_infobottom_bgcolor', 'type' => 'ctext',
	    'info' => "The bottom post info area ('Posted in' line - add {display:none;} to CSS to hide entire line.)"),
    array('name' => 'Use Icons in Post Info</small>', 'id' => 'wii_post_icons', 'type' => 'checkbox',
            'info' => 'Check to use icons in Post Info (Meta Info)'),

    array('name' => '<small>Move Top Post Info to Bottom</small>', 'id' => 'wii_post_info_move_top', 'type' => '+checkbox',	//code
	  'info' => 'Move the top post info line to bottom of post. (Pro)'),
    array('name' => '<small>Move Bottom Post Info to Top</small>', 'id' => 'wii_post_info_move_bottom', 'type' => '+checkbox',	//code
	  'info' => 'Move the bottom post info line to top of post. (Pro)'),
    array('name' => '<small>Hide top post info</small>', 'id' => 'wii_post_info_hide_top', 'type' => '+checkbox',	//code
	  'info' => 'Hide entire top info line (posted on, by) of post. (Pro)'),
    array('name' => '<small>Hide top post info on Mobile</small>', 'id' => 'wii_mobile_post_info_hide_top', 'type' => '+checkbox',
	  'info' => 'Hide entire top info line (posted on, by) of post when viewed on Mobile devices. (Pro)'),
    array('name' => '<small>Hide bottom post info</small>', 'id' => 'wii_post_info_hide_bottom', 'type' => '+checkbox',	//code
	  'info' => 'Hide entire bottom info line (posted in, comments) of post. (Pro)'),
    array('name' => '<small>Hide bottom post info on Mobile</small>', 'id' => 'wii_mobile_post_info_hide_bottom', 'type' => '+checkbox', //CSS
	  'info' => 'Hide entire bottom info line (posted in, comments) of post when viewed on Mobile devices. (Pro)'),

    array('name' => 'Note:', 'type' => 'note', 'info' => 'Hiding any meta info item automatically uses Icons instead of words'),
    array('name' => '<small>Hide Post Date</small>', 'id' => 'wii_post_hide_date', 'type' => 'checkbox',
            'info' => 'Hide the post date everywhere it is normally displayed.'),
    array('name' => '<small>Hide Post Author</small>', 'id' => 'wii_post_hide_author', 'type' => 'checkbox',
            'info' => 'Hide the post author everywhere it is normally displayed.'),
    array('name' => '<small>Hide Post Categories</small>', 'id' => 'wii_post_hide_cats', 'type' => 'checkbox',
            'info' => 'Hide the post categories and tags wherever they are normally displayed.'),
    array('name' => '<small>Hide Post Tags</small>', 'id' => 'wii_post_hide_tags', 'type' => 'checkbox',
            'info' => 'Hide the post tags wherever they are normally displayed.'),
    array('name' => '<small>Hide Permalink</small>', 'id' => 'wii_hide_permalink', 'type' => 'checkbox',
            'info' => 'Hide the permalink.'),
    array('name' => '<small>Hide Category if Only One</small>', 'id' => 'wii_hide_singleton_cat', 'type' => 'checkbox',
            'info' => 'If there is only one overall category defined (Uncategorized), don\'t show Category of post.'),
    array('name' => '<small>Hide Author for Single Author Site</small>', 'id' => 'wii_post_hide_single_author', 'type' => 'checkbox',
            'info' => 'Hide author information if site has only a single author.'),

    array('name' => 'Custom Info Lines', 'type' => 'subheader_alt',
	  'info' => 'Replace Info Lines with custom info line templates. Advanced options: see help file', 'help' => 'help.html#CustomInfo'),
    array('name' => '<small>Top Post Info Line<small>', 'id' => '_wvr_custom_posted_on', 'type' => '+textarea',
	  'info' => 'Custom template for top post info line. See help file! (Pro) &diams;'),
    array('name' => '<small>Bottom Post Info Line<small>', 'id' => '_wvr_custom_posted_in', 'type' => '+textarea',
	  'info' => 'Custom template for bottom post info line. (Pro) &diams;'),
    array('name' => '<small>Top Post Info Line (Single)<small>', 'id' => '_wvr_custom_posted_on_single', 'type' => '+textarea',
	  'info' => 'Custom template for top post info line on single pages. (Pro) &diams;'),
    array('name' => '<small>Bottom Post Info Line (Single)<small>', 'id' => '_wvr_custom_posted_in_single', 'type' => '+textarea',
	  'info' => 'Custom template for bottom post info line on single pages. (Pro) &diams;'),


    array('name' => 'Excerpts', 'type' => 'subheader_alt',
	  'info' => 'All about displaying excerpts'),
    array('name' => 'Excerpt Blog Posts', 'id' => 'wii_excerpt_blog', 'type' => 'checkbox',
            'info' => 'Will display excerpts instead of full posts on <em>blog pages</em>. Useful when used with Featured Image.'),
    array('name' => 'Full Post for Archives', 'id' => 'wii_fullpost_archive', 'type' => 'checkbox',
            'info' => 'Display the full posts instead of excerpts on <em>special post pages</em>. (Archives, Categories, etc.) Does not override manually added &lt;--more--> breaks.'),
    array('name' => 'Full Post for Searches', 'id' => 'wii_fullpost_search', 'type' => 'checkbox',
            'info' => 'Display the full posts instead of excerpts for Search results. Does not override manually added &lt;--more--> breaks.'),
    array('name' => '<small>Excerpt length</small>', 'id' => 'wii_excerpt_length', 'type' => 'text',
            'info' => 'Change post excerpt length. (Default: 40 words)'),
    array('name' => '<small><em>Continue reading</em> Message</small>', 'id' => 'wii_excerpt_more_msg', 'type' => 'widetext',
            'info' => 'Change default <em>Continue reading &rarr;</em> message for excerpts. Can include HTML (e.g., &lt;img>).'),

    array('name' => 'Featured Images', 'type' => 'subheader_alt',
	  'info' => 'Display of Post Featured Images'),
    array('name' => '<small>Show Featured Image for full posts</small>', 'id' => 'wii_show_featured_image_fullposts', 'type' => 'checkbox',
            'info' => 'Show the "Featured Image" (set on Post edit page) with full post displays (non-excerpted posts)'),
    array('name' => '<small>Show Featured Image for excerpts</small>', 'id' => 'wii_show_featured_image_excerptedposts', 'type' => 'checkbox',
            'info' => 'Show the "Featured Image" (set on Post edit page) thumbnail with excerpted post displays (non-excerpted posts)'),
    array('name' => '<small>Featured Image Width, Blog</small>', 'id' => 'wii_featured_blog_width', 'type' => 'val_px',
            'info' => 'Width of Featured Image when shown on Blog pages. Height will remain proportional.' ),
    array('name' => '<small>Featured Image Width, Single</small>', 'id' => 'wii_featured_single_width', 'type' => 'val_px',
            'info' => 'Width of Featured Image when shown on Single post page. Height will remain proportional.'),


    array('name' => 'Other Post Related Options', 'type' => 'subheader_alt',
	  'info' => 'Other options related to post display, including single pages'),
    array('name' => '<small>Show <em>Comments are closed.</em></small>', 'id' => 'wii_show_comments_closed', 'type' => 'checkbox',
            'info' => 'If comments are off, and no comments have been made, show the <em>Comments are off.</em> message.' ),
    array('name' => '<small>Hide Author Bio</small>', 'id' => 'wii_hide_author_bio', 'type' => 'checkbox',
            'info' => 'Hide display of author bio box on author and full single post pages.'),
    array('name' => '<small>Allow comments for attachments</small>', 'id' => 'wii_allow_attachment_comments', 'type' => 'checkbox',
            'info' => 'Allow visitors to leave comments for attachments (usually full size media image - only if comments allowed).')
    );

    weaverii_form_show_options($opts);
?>
    <label><span style="color:green;"><b>Hiding/Enabling Page and Post Comments</b></span></label>
<?php
    weaverii_help_link('help.html#LeavingComments',__('Help for Leaving Comments', 'weaver-ii'/*a*/ ));
?>
    <p>Controlling "Reply/Leave a Comment" visibility for pages and posts is <strong>not</strong> a theme function. It is
    controlled by WordPress settings. Please click the ? just above to see the help file entry! (Additional options for comment
    <em>styling</em> are found on the Content Areas tab.)</p>
<?php
}

function weaverii_mainopts_footer() {
    $opts = array(
    array('name' => 'Footer Options', 'id' => 'maintab4', 'type' => 'header',
        'info'=> 'Settings for the footer',
	'help' => 'help.html#FooterOpt'),

    array('name' => 'Footer BG', 'id' => 'wii_footer_bgcolor', 'type' => 'ctext',
            'info' => 'Background for the footer area.'),
    array('name' => 'Footer Border', 'id' => 'wii_footer_border_color', 'type' => 'ctext',
	    'info' => 'Color of the border above the footer area.'),
    array('name' => 'Footer Border', 'id' => 'wii_footer_border_int', 'type' => 'val_px',
	    'info' => 'Height of footer border (Default: 4px)'),
    array('name' => '<small>Hide Entire Footer</small>', 'id' => 'wii_hide_footer', 'type' => 'checkbox',
	    'info' => 'Hide the entire footer area.'),
    array('name' => '<small>Hide "final" area</small>', 'id' => 'wii_hide_final', 'type' => 'checkbox',
	    'info' => 'Hide the display (but NOT functionality) of script and plugin messages at the very bottom of your site.'),
    array('name' => 'Advanced', 'type' =>'subheader', 'info' => 'Settings for more advanced users'),
    array('name' => 'Footer Width', 'id' => 'wii_footer_width_int', 'type' => '+val_px',
	    'info' => 'If set to larger than Theme Width, will make the Footer (#colophon) wider than Container (#container) area. (Pro)'),
    array('name' => '<small>Footer &lt;div> Last</small>', 'id' => 'wii_footer_last', 'type' => '+checkbox',	//code
	    'info' => 'Place #footer &lt;div> last - outside #wrapper. Advanced option: requires custom CSS to be used effectively. (Pro)'),


    array('name' => 'Note:', 'id' => 'wii_footer_note', 'type' => 'note',
	    'info' => 'The footer area supports up to 4 widget areas. These auto-adjust their widths.'),
    );

    weaverii_form_show_options($opts);
?>
           <label><span style="color:blue;"><b>Site Copyright</b></span></label><br/>
	<small>If you fill this in, the default copyright notice in the footer will be replaced with the text here. It will not
	automatically update from year to year.<br /> Use &amp;copy; to display &copy;. You can use other HTML as well. &diams;</small>
	<br />

	<textarea name="<?php weaverii_sapi_advanced_name('_wii_copyright'); ?>" rows=1 style="width:750px;"><?php echo(esc_textarea(weaverii_getopt('_wii_copyright'))); ?></textarea>
	<br>
        <label>Hide Powered By tag: </label><input type="checkbox" name="<?php weaverii_sapi_advanced_name('_wii_hide_poweredby'); ?>" id="_wii_hide_poweredby" <?php checked(weaverii_getopt_checked( '_wii_hide_poweredby' )); ?> />
		<small>Check this to hide the "Proudly powered by" notice in the footer.</small>
        <br /><br />
	You can add other content to the Footer from the Advanced Options:HTML Insertion tab.


<?php
}

function weaverii_mainopts_widgets() {
    $opts = array(
    array('name' => 'Widget Areas', 'id' => 'maintab5', 'type' => 'header',
            'info'=> 'Settings affecting widget areas',
            'help' => 'help.html#WidgetAreas'),

    array('name' => 'Individual Widgets', 'id' => 'wii_widget_widget', 'type' => 'widget_area',
	    'info' => 'Properties for individual widgets (e.g., Text, Recent Posts, etc.)'),
    array('name' => 'Widget Padding', 'id'=> 'wii_widget_widget_padding_int', 'type'=>'val_px',
	  'info' => 'Padding used around all sides of individual widgets. Not usually needed unless widgets have bg color.'),
    array('name' => 'Widget Title', 'id' => 'wii_widget_title_color', 'type' => 'ctext',
	    'info' => 'Color for Widget titles and labels.'),
    array('name' => 'Bar under Widget Titles', 'id' => 'wii_widget_header_underline_int', 'type' => 'val_px',
	    'info' => 'Enter size in px if you want a bar under Widget Titles. Leave blank or 0 for no bar.'),
    array('name' => 'Widget Area Text', 'id' => 'wii_widget_color', 'type' => 'ctext',
	    'info' => 'Color for widget area content (text color).'),
    array ('name' => 'Widget List Bullet',
	   'id' => 'wii_widgetlist_bullet', 'type' => 'select_id', 'info' => 'Bullet used for Unorderd Lists in Widget areas',
	    'value' => array(
			   array('val' => 'disc', 'desc' => 'Filled Disc (default)'),
			   array('val' => 'circle', 'desc' => 'Circle'),
			   array('val' => 'square', 'desc' => 'Square'),
			   array('val' => 'none', 'desc' => 'None'),
			   array('val' => 'custom', 'desc' => 'Custom bullet')
			   )
	  ),
    array ('name' => '<small>Custom Bullet URL</small>', 'id' => 'wii_widgetlist_bullet_custom_url', 'type' => '+textmedia',	//code
	   'info' => 'URL for "Custom" bullet image (Pro)'),
    array( 'type' => 'submit'),

    array('name' => 'Sidebar Widths:', 'type'=>'note', 'info'=>'Widths of Sidebars set under Layout tab.'),
    array('name' => 'Primary Widget Area', 'id' => 'wii_widget_primary', 'type' => 'widget_area',
	    'info' => 'Properties for the Primary Sidebar Widget Area.'),

    array('name' => 'Upper/Right Widget Area', 'id' => 'wii_widget_right', 'type' => 'widget_area',
	    'info' => 'Properties for the Upper/Right Sidebar Widget Area.'),

    array('name' => 'Lower/Left Widget Area', 'id' => 'wii_widget_left', 'type' => 'widget_area',
	    'info' => 'Properties for the Lower/Left Sidebar Widget Area.'),
    array('name' => 'Primary, Right, Left Margins', 'type' => 'subheader_alt',
	 'info' => 'Left and Right margins for Primary, Upper/Right, and Lower/Left Widget areas'),
    array('name' => 'Left/Right Margins', 'id' => 'wii_sidbar_widget_margins', 'type' => 'text_lr',
	  'info' => 'Left and right margins for the sidebar widget areas.'),

    array('name' => 'Top Widget Areas', 'id' => 'wii_widget_top', 'type' => 'widget_area',
	    'info' => 'Properties for all Top Widget areas (Sitewide, Pages, Blog, Archive).'),
    array('name' => 'Left/Right indent', 'id' => 'wii_widget_top_indent_int', 'type' => 'val_percent',
	    'info' => 'Top Widget Areas: Set the left and right indents - centers widget area in content area'),

    array('name' => 'Bottom Widget Areas', 'id' => 'wii_widget_bottom', 'type' => 'widget_area',
	    'info' => 'Properties for all Bottom Widget areas (Sitewide, Pages, Blog, Archive).'),
    array('name' => 'Left/Right indent', 'id' => 'wii_widget_bottom_indent_int', 'type' => 'val_percent',
	    'info' => 'Bottom Widget Areas: Set the left and right indents - centers widget area in content area'),

    array('name' => 'Footer Widget Areas', 'id' => 'wii_widget_footer', 'type' => 'widget_area',
	    'info' => 'Properties for all Footer Widget areas.'),

    array('name' => 'All Widget Areas','type' => 'subheader_alt',
	  'info' => 'Properties that apply to all widget areas.'),
    array('name' => 'Widget Area Padding', 'id'=>'wii_widget_padding_int', 'type'=>'val_px',
	  'info' => 'Padding used around all sides of widget areas.'),

    );

    weaverii_form_show_options($opts);
?>
<label><span style="color:blue;"><b>Define Per Page Widget Areas</b></span></label>
<?php
    weaverii_help_link('help.html#PPWidgets',__('Help for Per Page Widget Areas', 'weaver-ii'/*a*/ ));
?>
    <br/>
    <small>You may define extra widget areas that can then be used in the <em>Per Page</em> settings. Enter
    a list of one or more widget area names separated by commas. Your names should include only letters, numbers, or underscores -
    no spaces or other special characters. The widgets areas will then appear on the Appearance->Widgets menus. They can be included
    on individual pages by adding the name you define here to the "Weaver II Options For This Page" box on the Edit Page screen.</small>
    <br />
    <textarea name="<?php weaverii_sapi_advanced_name('wii_perpagewidgets'); ?>" rows=1 style="width: 95%"><?php echo(esc_textarea(weaverii_getopt('wii_perpagewidgets'))); ?></textarea>
    <br />
    <small>These extra widget areas are also used by the Weaver II Pro Widget Area shortcode.</small>

<p style="color:green;"><strong>Note: Specify the layout of sidebar widget areas on the Layout tab.
</strong></p>
<?php
}

function weaverii_mainopts_fonts() {
    $opts = array(
    array('name' => 'Fonts', 'id' => 'mainopts_fonts', 'type' => 'header',
	'info'=> 'Fonts',
        'help' => 'help.html#Fonts'),
    array ('name' => 'Content Font',
	'id' => 'wii_content_font', 'type' => 'selectold',
	'info' => 'Font used for most content and widget text (Default: "Times New Roman", Times, serif;)',
	'value' => array( '',
	'"Helvetica Neue", Helvetica, sans-serif', 'Arial,Helvetica,sans-serif', 'Verdana,Arial,sans-serif',
	'Tahoma, Arial,sans-serif', '"Arial Black",Arial,sans-serif', '"Avant Garde",Arial,sans-serif', '"Comic Sans MS",Arial,sans-serif',
	'Impact,Arial,sans-serif', 'Trebuchet,Arial,sans-serif', '"Century Gothic",Arial,sans-serif', '"Lucida Grande",Arial,sans-serif',
	'Univers,Arial,sans-serif', '"Times New Roman",Times,serif', '"Bitstream Charter",Times,serif', 'Georgia,Times,serif',
	'Palatino,Times,serif', 'Bookman,Times,serif', 'Garamond,Times,serif', '"Courier New",Courier', '"Andale Mono",Courier'
	 )),
    array ('name' => 'Titles Font', 'id' => 'wii_title_font', 'type' => 'selectold',
	'info' => 'Font used for post, page, and widget titles, info labels, and menus. (Default: "Helvetica Neue", Helvetica, Arial, sans-serif;)',
	'value' => array('',
	'"Helvetica Neue", Helvetica, sans-serif', 'Arial,Helvetica,sans-serif', 'Verdana,Arial,sans-serif',
	'Tahoma, Arial,sans-serif', '"Arial Black",Arial,sans-serif', '"Avant Garde",Arial,sans-serif', '"Comic Sans MS",Arial,sans-serif',
	'Impact,Arial,sans-serif', 'Trebuchet,Arial,sans-serif', '"Century Gothic",Arial,sans-serif', '"Lucida Grande",Arial,sans-serif',
	'Univers,Arial,sans-serif', '"Times New Roman",Times,serif', '"Bitstream Charter",Times,serif', 'Georgia,Times,serif',
	'Palatino,Times,serif', 'Bookman,Times,serif', 'Garamond,Times,serif', '"Courier New",Courier', '"Andale Mono",Courier'
	)),

    array('name' => 'Site Base Font Size', 'id' => 'wii_site_fontsize_int', 'type' => 'val_px',
	  'info' => 'Set the Base Font size. All other font sizes are calculated as a percentage of this size. (Default: 12px)')
    );

    weaverii_form_show_options($opts);

    if (weaverii_init_base())
	weaverii_fonts_pro_admin();
    else {
?>
<h3>Weaver II Pro Font Control</h3>
<p>The Weaver II Pro Font Control panel gives you fine tuned control over the fonts various elements of your site will use.
    You can use a set of standard Web fonts, or for total flexibility, you can use <em>any</em> of the free
    <a href="http://www.google.com/webfonts" target="_blank"><strong>Google Web Fonts</strong></a>. In addition to the
    two general areas available in the basic Weaver II version, the Pro version lets you set the font of virtually every
    text element on your site. You can also specify font size, style, and other attributes.
    <p>
<?php
    }
}

function weaverii_mainopts_layout() {
    $opts = array(
    array('name' => 'Layout', 'id' => 'mainopts_layout', 'type' => 'header',
        'info'=> 'Settings for site layout: theme width and margins, sidebar layout, bg color flow',
	'help' => 'help.html#layout'),
    array( 'name' => 'Theme Width', 'id' => 'wii_theme_width_int', 'type' => 'val_px',
	    'info' => 'Change Theme Width. Standard size is 940px. Header Image width is automatically changed, too. Does not include wrapper padding. (Uses CSS "max-width" to set width, which gives "flexible width" shrinking for displays smaller than the width specified.)'),
    array('name' => '<small>Theme Width Fixed</small>', 'id' => 'wii_theme_width_fixed', 'type' => 'checkbox',
	    'info' => 'Force the theme width to be fixed (use CSS "width" instead of "max-width"). Using this option is not recommended. This setting will also "break" the Mobile View, so you should disable Mobile Support as well.'),
    array('name' => 'Theme Margins: Top/Bottom', 'id' => 'wii_site_margins', 'type' => 'text_tb',
	    'info' => 'Top and bottom margins around whole site. (Default: 20px)'),
    array('name' => 'Theme Margins: Left/Right', 'id' => 'wii_site_margins', 'type' => 'text_lr',
	    'info' => 'Left and right margins around whole site. (Default: 20px)'),
    array('name' => 'Wrapper Padding', 'id' => 'wii_wrapper_padding', 'type' => 'val_px',
	    'info' => 'Wrapper Padding - space between wrapper edges and header, content, sidebars, footer. (Default: 10px)'),


    array('name' => 'Sidebar Layout', 'type' => 'subheader', 'info' => 'Sidebar Layout for each type of page'),
    array('name' => __('Blog, Post, Page Default', 'weaver-ii'/*a*/ ), 'id' => 'wii_layout_default', 'type' => 'select_id',
	  'info' => __('Select the default theme layout for blog, single post, and pages.', 'weaver-ii'/*a*/ ),
	  'value' => array(
			   array('val' => 'right-1-col', 'desc'=> 'Single column sidebar on Right' ),
			   array('val' => 'left-1-col', 'desc' => 'Single column sidebar on Left'),
			   array('val' => 'right-2-col', 'desc' => 'Double Cols, Right (top wide)'),
			   array('val' => 'left-2-col', 'desc' => 'Double Cols, Left (top wide)'),
			   array('val' => 'right-2-col-bottom', 'desc' => 'Double Cols, Right (bottom wide)'),
			   array('val' => 'left-2-col-bottom', 'desc' => 'Double Cols, Left (bottom wide)'),
			   array('val' => 'split', 'desc' => 'Split - sidebars on Right and Left'),
			   array('val' => 'one-column', 'desc' => 'No sidebars, one column content')
		)),

    array('name' => __('Archive-like Default', 'weaver-ii'/*a*/ ), 'id' => 'wii_layout_default_archive', 'type' => 'select_id',
	  'info' => __('Select the default theme layout for all other pages - archives, search, etc.', 'weaver-ii'/*a*/ ),
	  'value' => array(
			   array('val' => 'one-column', 'desc' => 'No sidebars, one column content'),
			   array('val' => 'right-1-col', 'desc'=> 'Single column sidebar on Right' ),
			   array('val' => 'left-1-col', 'desc' => 'Single column sidebar on Left'),
			   array('val' => 'right-2-col', 'desc' => 'Double Cols, Right (top wide)'),
			   array('val' => 'left-2-col', 'desc' => 'Double Cols, Left (top wide)'),
			   array('val' => 'right-2-col-bottom', 'desc' => 'Double Cols, Right (bottom wide)'),
			   array('val' => 'left-2-col-bottom', 'desc' => 'Double Cols, Left (bottom wide)'),
			   array('val' => 'split', 'desc' => 'Split - sidebars on Right and Left')
		)),

    array('name' => __('<small>Page</small>', 'weaver-ii'/*a*/ ), 'id' => 'wii_layout_page', 'type' => 'select_layout',
	  'info' => __('Layout for normal Pages on your site.', 'weaver-ii'/*a*/ ),
	  'value' => ''
	  ),
    array('name' => __('<small>Blog</small>', 'weaver-ii'/*a*/ ), 'id' => 'wii_layout_blog', 'type' => 'select_layout',
	  'info' => __('Layout for main blog page. Includes "Page with Posts" Page templates.', 'weaver-ii'/*a*/ ),
	  'value' => ''
	  ),
    array('name' => __('<small>Post Single Page</small>', 'weaver-ii'/*a*/ ), 'id' => 'wii_layout_single', 'type' => 'select_layout',
	  'info' => __('Layout for Posts displayed as a single page.', 'weaver-ii'/*a*/ ),
	  'value' => ''
	  ),
    array('name' => __('<small>Archive</small>', 'weaver-ii'/*a*/ ), 'id' => 'wii_layout_archive', 'type' => '+select_layout',	//code
	  'info' => __('Layout for archive pages on your site. Used for all archive-like pages unless otherwise specified. (Pro)', 'weaver-ii'/*a*/ ),
	  'value' => ''
	  ),
    array('name' => __('<small>Category Archive</small>', 'weaver-ii'/*a*/ ), 'id' => 'wii_layout_category', 'type' => '+select_layout',	//code
	  'info' => __('Layout for category archive pages. (Pro)', 'weaver-ii'/*a*/ ),
	  'value' => ''
	  ),
    array('name' => __('<small>Tags Archive</small>', 'weaver-ii'/*a*/ ), 'id' => 'wii_layout_tag', 'type' => '+select_layout',	//code
	  'info' => __('Layout for tag archive pages. (Pro)', 'weaver-ii'/*a*/ ),
	  'value' => ''
	  ),
    array('name' => __('<small>Author Archive</small>', 'weaver-ii'/*a*/ ), 'id' => 'wii_layout_author', 'type' => '+select_layout',	//code
	  'info' => __('Layout for author archive pages. (Pro)', 'weaver-ii'/*a*/ ),
	  'value' => ''
	  ),
    array('name' => __('<small>Search Results</small>', 'weaver-ii'/*a*/ ), 'id' => 'wii_layout_search', 'type' => '+select_layout',	//code
	  'info' => __('Layout for search results pages. (Pro)', 'weaver-ii'/*a*/ ),
	  'value' => ''
	  ),
    array('name' => __('<small>Attachments</small>', 'weaver-ii'/*a*/ ), 'id' => 'wii_layout_image', 'type' => '+select_layout',	//code
	  'info' => __('Layout for attachment pages such as images. (Pro)', 'weaver-ii'/*a*/ ),
	  'value' => ''
	  ),

    array('name' => __('Container & Sidebar Color Flow', 'weaver-ii'/*a*/ ), 'id' => 'wii_layout_image', 'type' => 'subheader',
	  'info' => __('Allow color to flow to bottom', 'weaver-ii'/*a*/ )
	  ),
    array('name' => 'Flow color to bottom', 'id' => 'wvr_flow_to_bottom', 'type' => '+checkbox',
	    'info' => 'If checked, Container and Sidebar Wrappers bg colors will flow to bottom of content area. If you do not set bg colors, default bg will be used. IMPORTANT: this option is intented to be used when you provide background colors for the Container and Sidebar Wrapper properties below. (Pro)'),

    array('name' => __('Container Wrapper Properties', 'weaver-ii'/*a*/ ), 'id' => 'wii_layout_image', 'type' => 'subheader',
	  'info' => __('Background, and Column Color Flow of Container wrapper', 'weaver-ii'/*a*/ )
	  ),
    array('name' => 'Background', 'id' => 'sb_container_bgcolor', 'type' => '+ctext',
	    'info' => 'Background color of content area wrapper - most useful when flowing color to bottom (Pro)'),

    array('name' => 'Note:', 'type'=>'note',
	  'info'=>'Width of container automatically calculated based on sidebar widths.
CAUTION: Using CSS+ to add borders or other width changes to the container or sidebar wrappers can break sidebar layout.'),

    array( 'type' => 'submit'),

    array('name' => __('Sidebar Wrappers Properties', 'weaver-ii'/*a*/ ), 'id' => 'wii_layout_image', 'type' => 'subheader',
	  'info' => __('Widths, Background, and Column Color Flow of Sidebars', 'weaver-ii'/*a*/ )
	  ),

    array('name' => 'Default Width for Sidebars', 'id' => 'sb_default_width_int', 'type' => 'val_percent',
	  'info' => 'If specified, will override all default sidebar widths specified below. This is mostly used for compatibility with the previous version of Weaver.'),

    array('name' => 'Right Side, One Column', 'type' => 'subheader_alt',
	    'info' => 'Wrapper area for Single column sidebar on Right (Top+Upper+Lower Widget Areas)'),
    array('name' => 'Sidebar Width', 'id' => 'sb_right_1_col_width_int', 'type' => '+val_percent',
	    'info' => 'Width of sidebar (Default: 25%) (Pro)'),
    array('name' => 'Background', 'id' => 'sb_right_1_col_bgcolor', 'type' => '+ctext',
	    'info' => 'Background color of sidebar wrapper (Pro)'),

    array('name' => 'Left Side, One Column', 'type' => 'subheader_alt',
	    'info' => 'Wrapper area for Single column sidebar on Left (Top+Upper+Lower Widget Areas)'),
    array('name' => 'Sidebar Width', 'id' => 'sb_left_1_col_width_int', 'type' => '+val_percent',
	    'info' => 'Width of sidebar (Default: 25%) (Pro)'),
    array('name' => 'Background', 'id' => 'sb_left_1_col_bgcolor', 'type' => '+ctext',
	    'info' => 'Background color of sidebar wrapper. (Pro)'),

    array('name' => 'Right Side, Two Column', 'type' => 'subheader_alt',
	    'info' => 'Wrapper area for Double column sidebar on Right (Top above Left+Right Widget Areas)'),
    array('name' => 'Sidebar Width', 'id' => 'sb_right_2_col_width_int', 'type' => '+val_percent',
	    'info' => 'Width of sidebar (Primary/Top Widget Area is this width) (Default: 33%) (Pro)'),
    array('name' => 'Background', 'id' => 'sb_right_2_col_bgcolor', 'type' => '+ctext',
	    'info' => 'Background color of sidebar wrapper (Pro)'),

    array('name' => 'Left Side, Two Column', 'type' => 'subheader_alt',
	    'info' => 'Wrapper area for Double column sidebar on Left (Top above Left+Right Widget Areas)'),
    array('name' => 'Sidebar Width', 'id' => 'sb_left_2_col_width_int', 'type' => '+val_percent',
	    'info' => 'Width of sidebar (Primary/Top Widget Area is this width) (Default: 33%) (Pro)'),
    array('name' => 'Background', 'id' => 'sb_left_2_col_bgcolor', 'type' => '+ctext',
	    'info' => 'Background color of sidebar wrapper (Pro)'),

    array('name' => 'Two Column - Left/Right', 'type' => 'subheader_alt',
	    'info' => 'The Left and Right sidebars under the Primary (top) area in Double column sidebars.'),
    array('name' => 'Left Width', 'id' => 'sb_2_left_area_int', 'type' => '+val_percent',
	    'info' => 'Left Width as % of double sidebar area width (Right set automatically) (Default: 55%) (Pro)'),

    array('name' => 'Split Sidebars', 'type' => 'subheader_alt',
	    'info' => 'Wrapper area for Split sidebars - Left side and Right side (Top above Right)'),
    array('name' => 'Sidebar Width - Left', 'id' => 'sb_split_left_width_int', 'type' => '+val_percent',
	    'info' => 'Width of Left Side sidebar (Default: 17%) (Pro)'),
    array('name' => 'Sidebar Width - Right', 'id' => 'sb_split_right_width_int', 'type' => '+val_percent',
	    'info' => 'Width of Right Side sidebar (Default: 17%) (Pro)'),
    array('name' => 'Background - Left', 'id' => 'sb_split_left_bgcolor', 'type' => '+ctext',
	    'info' => 'Background color of left split sidebar wrapper (Pro)'),
    array('name' => 'Background - Right', 'id' => 'sb_split_right_bgcolor', 'type' => '+ctext',
	    'info' => 'Background color of right split sidebar wrapper (Pro)')
    );

    weaverii_form_show_options($opts);


}

?>
