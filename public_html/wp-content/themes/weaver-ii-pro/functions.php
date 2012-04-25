<?php
/**
 * Weaver II functions and definitions
 *
 * Sets up the theme and provides some helper functions. Some helper functions
 * are used in the theme as custom template tags. Others are attached to action and
 * filter hooks in WordPress to change core functionality.
 *
 * The first function, weaverii_setup(), sets up the theme by registering support
 * for various features in WordPress, such as post thumbnails, navigation menus, and the like.
 *
 * When using a child theme (see http://codex.wordpress.org/Theme_Development and
 * http://codex.wordpress.org/Child_Themes), you can override certain functions
 * (those wrapped in a function_exists() call) by defining them first in your child theme's
 * functions.php file. The child theme's functions.php file is included before the parent
 * theme's file, so the child theme functions would be used.
 *
 * Functions that are not pluggable (not wrapped in function_exists()) are instead attached
 * to a filter or action hook. The hook can be removed by using remove_action() or
 * remove_filter() and you can attach your own function to the hook.
 *
 * We can remove the parent theme's hook only after it is attached, which means we need to
 * wait until setting up the child theme:
 *
 * <code>
 * add_action( 'after_setup_theme', 'my_child_theme_setup' );
 * function my_child_theme_setup() {
 *     // We are providing our own filter for excerpt_length (or using the unfiltered value)
 *     remove_filter( 'excerpt_length', 'weaverii_excerpt_length' );
 *     ...
 * }
 * </code>
 *
 * For more information on hooks, actions, and filters, see http://codex.wordpress.org/Plugin_API.
 *
 * @package WordPress
 * @subpackage Weaver II
 * @since Weaver II 1.0
 */

/**
 * Set the content width based on the theme's design and stylesheet.
 */
if ( ! isset( $content_width ) )
	$content_width = 640;

/**
 * Tell WordPress to run weaverii_setup() when the 'after_setup_theme' hook is run.
 */
add_action( 'after_setup_theme', 'weaverii_setup' );

if ( ! function_exists( 'weaverii_setup' ) ) {
/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which runs
 * before the init hook. The init hook is too late for some features, such as indicating
 * support post thumbnails.
 *
 * To override weaverii_setup() in a child theme, add your own weaverii_setup to your child theme's
 * functions.php file.
 *
 * @uses load_theme_textdomain() For translation/localization support.
 * @uses add_editor_style() To style the visual editor.
 * @uses add_theme_support() To add support for post thumbnails, automatic feed links, and Post Formats.
 * @uses register_nav_menus() To add support for navigation menus.
 * @uses add_custom_background() To add support for a custom background.
 * @uses add_custom_image_header() To add support for a custom header.
 * @uses register_default_headers() To register the default custom header images provided with the theme.
 * @uses set_post_thumbnail_size() To set a custom post thumbnail size.
 *
 * @since Weaver II 1.0
 */
function weaverii_setup() {

	/* Make Weaver II available for translation.
	 */
	global $weaverii_timer;
	$weaverii_timer = microtime(true);	// don't have options loaded, so just always get the current time.

	$tpath = trailingslashit(get_template_directory());

	load_theme_textdomain( 'weaver-ii', $tpath . 'languages' );

	$locale = get_locale();
	$locale_file = $tpath . "languages/$locale.php";
	if ( is_readable( $locale_file ) )
		require_once( $locale_file );

	// This theme styles the visual editor with editor-style.css to match the theme style.
	add_editor_style();

	// Add default posts and comments RSS feed links to <head>.
	add_theme_support( 'automatic-feed-links' );

	// Weaver II supports two nav menus
	register_nav_menus( array(
		'primary' => 'Primary Navigation: if specified, used instead of Default menu',
		'mobile_menu' => 'Mobile Navigation: if specified, replaces Primary/Default menu for Phone View',
		'secondary' => 'Secondary Navigation: if specified, adds 2nd menu bar'
	) );

	// Add support for a variety of post formats
	add_theme_support( 'post-formats', array( 'aside', 'chat', 'gallery',  'image', 'link', 'quote', 'status') );

	// Add support for custom backgrounds
	add_custom_background();

	// This theme uses Featured Images (also known as post thumbnails) for per-post/per-page Custom Header images
	add_theme_support( 'post-thumbnails' );

	// now, need Weaver II settings available for everything else

	weaverii_init_opts('functions');

	$width = weaverii_getopt('wii_header_width_int');
	if (!$width)
	    $width = weaverii_getopt('wii_theme_width_int');
	$height = weaverii_getopt('wii_header_image_height_int');


	// The next four constants set how Weaver II supports custom headers.

	// The default header text color
	define('NO_HEADER_TEXT', true);	// don't include text info in the Headers admin
	define( 'HEADER_TEXTCOLOR', '' );

	// By leaving empty, we allow for random image rotation.
	// No CSS, just IMG call. The %s is a placeholder for the theme template directory URI.
	define( 'HEADER_IMAGE', '%s/images/headers/antique-ivory.jpg' );
	//define( 'HEADER_IMAGE', '' );

	define( 'HEADER_IMAGE_WIDTH', $width );
	define( 'HEADER_IMAGE_HEIGHT', $height );


	// We'll be using post thumbnails for custom header images on posts and pages.
	// We want them to be the size of the header image that we just defined
	// Larger images will be auto-cropped to fit, smaller ones will be ignored. See header.php.
	set_post_thumbnail_size( HEADER_IMAGE_WIDTH, HEADER_IMAGE_HEIGHT, true );

	// Add Weaver II's custom image sizes
	add_image_size( 'large-feature', HEADER_IMAGE_WIDTH, HEADER_IMAGE_HEIGHT, true ); // Used for large feature (header) images
	add_image_size( 'small-feature', 500, 300 ); // Used for featured posts if a large-feature doesn't exist

	// Turn on random header image rotation by default.
	add_theme_support( 'custom-header'); // , array( 'random-default' => true ) );

	// Add a way for the custom header to be styled in the admin panel that controls
	// custom headers. See weaverii_admin_header_style(), below.
	add_custom_image_header( 'weaverii_header_style', 'weaverii_admin_header_style' );

	// ... and thus ends the changeable header business.
	weaverii_register_header_images();
}
} // weaverii_setup


function weaverii_admin_init_cb() {

    weaverii_sapi_options_init(); // This must come first as it hooks update_option used elsewhere

    // Now, init the Weaver II database

    return;
}

if (! function_exists( 'weaverii_register_header_images')) {
function weaverii_register_header_images() {
	// Default custom headers packaged with the theme. %s is a placeholder for the theme template directory URI.
	register_default_headers( array(
	'antique-ivory' => array (
		'url' => "%s/images/headers/antique-ivory.jpg",
		'thumbnail_url' => "%s/images/headers/antique-ivory-thumbnail.jpg",
		'description' => __( 'Antique Ivory', 'weaver-ii'/*a*/ )
	    ),

	'grand-teton' => array(
		'url' => '%s/images/headers/grand-teton.jpg',
		'thumbnail_url' => '%s/images/headers/grand-teton-thumbnail.jpg',
		/* translators: header image description */
		'description' => __( 'Grand Tetons', 'weaver-ii'/*a*/ )
	    ),
	'moon' => array(
		'url' => '%s/images/headers/moon.jpg',
		'thumbnail_url' => '%s/images/headers/moon-thumbnail.jpg',
		/* translators: header image description */
		'description' => __( 'Moon', 'weaver-ii'/*a*/ )
	    ),
	'mum' => array (
		'url' => "%s/images/headers/mum.jpg",
		'thumbnail_url' => "%s/images/headers/mum-thumbnail.jpg",
		'description' => __( 'Mum', 'weaver-ii'/*a*/ )
	    ),
	'ocean-birds' => array(
		'url' => '%s/images/headers/ocean-birds.jpg',
		'thumbnail_url' => '%s/images/headers/ocean-birds-thumbnail.jpg',
		/* translators: header image description */
		'description' => __( 'Ocean Birds', 'weaver-ii'/*a*/ )
	    ),
	'sopris' => array (
		'url' => "%s/images/headers/sopris.jpg",
		'thumbnail_url' => "%s/images/headers/sopris-thumbnail.jpg",
		'description' => __( 'Sopris', 'weaver-ii'/*a*/ )
	    ),
	'sunset' => array(
		'url' => '%s/images/headers/sunset.jpg',
		'thumbnail_url' => '%s/images/headers/sunset-thumbnail.jpg',
		/* translators: header image description */
		'description' => __( 'Sunset', 'weaver-ii'/*a*/ )
	    ),
	'wheat' => array (
		'url' => "%s/images/headers/wheat.jpg",
		'thumbnail_url' => "%s/images/headers/wheat-thumbnail.jpg",
		'description' => __( 'Wheat', 'weaver-ii'/*a*/ )
	    )
	) );
}
}

if ( ! function_exists( 'weaverii_header_style' ) ) {
/**
 * Styles the header image and text displayed on the blog
 *
 * @since Weaver II 1.0s
 */
function weaverii_header_style() {
	// we don't need to do anything
}
} // weaverii_header_style

if ( ! function_exists( 'weaverii_admin_header_style' ) ) {
/**
 * Styles the header image displayed on the Appearance > Header admin panel.
 *
 * Referenced via add_custom_image_header() in weaverii_setup().
 *
 * @since Weaver II 1.0
 */
function weaverii_admin_header_style() {
?>
	<style type="text/css">
	#headimg img {
		width: <?php echo HEADER_IMAGE_WIDTH; ?>px;
		height: auto;
		width: 100%;
	}
	</style>
<?php
}
} // weaverii_admin_header_style


/**
 * Sets the post excerpt length to 40 words.
 *
 * To override this length in a child theme, remove the filter and add your own
 * function tied to the excerpt_length filter hook.
 */
function weaverii_excerpt_length( $length ) {
    $val = weaverii_sc_getopt('excerpt_length');
    if (!$val)
	$val = weaverii_getopt('wii_excerpt_length');
    if ($val > 0 || $val === '0')
	return $val;
    return 40;
}
add_filter( 'excerpt_length', 'weaverii_excerpt_length' );

/**
 * Returns a "Continue Reading" link for excerpts
 */
if (!function_exists('weaverii_continue_reading_link')) {
function weaverii_continue_reading_link($add_a = true) {
    $rep = weaverii_sc_getopt('more_msg');
    if (!$rep)
	$rep = weaverii_getopt('wii_excerpt_more_msg');
    if (!empty($rep))
	$msg = $rep;
    else
	$msg = weaverii_trans('w_14_trans', __( 'Continue reading <span class="meta-nav">&rarr;</span>','weaver-ii'));

    if ($add_a)
	return ' <a class="more-link" href="'. get_permalink() . '">' . $msg . '</a>';
    else
	return $msg;
}
}

/**
 * Replaces "[...]" (appended to automatically generated excerpts) with an ellipsis and weaverii_continue_reading_link().
 *
 * To override this in a child theme, remove the filter and add your own
 * function tied to the excerpt_more filter hook.
 */
function weaverii_auto_excerpt_more( $more ) {
	return ' &hellip;' . weaverii_continue_reading_link();
}
add_filter( 'excerpt_more', 'weaverii_auto_excerpt_more' );

/**
 * Adds a pretty "Continue Reading" link to custom post excerpts.
 *
 * To override this link in a child theme, remove the filter and add your own
 * function tied to the get_weaverii_the_excerpt_featured filter hook.
 */

function weaverii_custom_excerpt_more( $output ) {
	if ( has_excerpt() && ! is_attachment() ) {
		$output .= weaverii_continue_reading_link();
	}
	return $output;
}
add_filter( 'get_the_excerpt', 'weaverii_custom_excerpt_more' );

/**
 * Get our wp_nav_menu() fallback, wp_page_menu(), to show a home link.
 *
 * To override this in a child theme, remove the filter and optionally add
 * your own function tied to the wp_page_menu_args filter hook.
 */
function weaverii_page_menu_args( $args ) {
    if (weaverii_getopt('wii_menu_nohome'))
	$args['show_home'] = false;
    else
	$args['show_home'] = true;

    // look for pages to hide from menu
    $ex_list = '';
    $hide_pages = get_pages(array('hierarchical' => 0, 'meta_key' => 'ttw-hide-on-menu'));	// get list of excluded pages
    if (!empty($hide_pages)) {
	foreach ($hide_pages as $page) {
	    $ex_list .= $page->ID . ',';	/* trailing , doesn't matter */
	}
    }

    if (is_user_logged_in())
	$log = 'wvr-hide-on-menu-logged-in';
    else
	$log = 'wvr-hide-on-menu-logged-out';

    $hide_pages = get_pages(array('hierarchical' => 0, 'meta_key' => $log));	// get list of excluded pages
    if (!empty($hide_pages)) {
	foreach ($hide_pages as $page) {
	    $ex_list .= $page->ID . ',';	/* trailing , doesn't matter */
	}
    }

    if ($ex_list != '')
	$args['exclude'] = $ex_list;
    return $args;
}
add_filter( 'wp_page_menu_args', 'weaverii_page_menu_args' );

/**
 * Register our sidebars and widgetized areas. Also register the default Epherma widget.
 *
 * @since Weaver II 1.0
 */
function weaverii_widgets_init() {


	// Big Top located at the top of the sidebar.
	weaverii_register_sidebar(__( 'Primary (top) Sidebar', 'weaver-ii'/*a*/ ),
	    'primary-widget-area', __( 'Primary (top) sidebar widget area, displays above Upper Sidebar (or Left+Right for multi-column layouts).', 'weaver-ii'/*a*/ ));

    	// Primary located at the top of the sidebar.
	weaverii_register_sidebar(__( 'Upper/Right Sidebar', 'weaver-ii'/*a*/ ),
	    'right-widget-area', __( 'The Upper Sidebar - or Right Sidebar for multi-column layouts.', 'weaver-ii'/*a*/ ));

	// Lower/Left located below the Primary Widget Area in the sidebar. Empty by default.
	weaverii_register_sidebar(__( 'Lower/Left Sidebar', 'weaver-ii'/*a*/ ),
	    'left-widget-area', __( 'The Lower Sidebar - or Left Sidebar for multi-column layouts.', 'weaver-ii'/*a*/ ));

		// Header Horizontal Widget area
	   register_sidebar( array(
	'name' => '&#149; ' . __( 'Header Horizontal Widget Area', 'weaver-ii'/*a*/ ),	/* the &#149; makes our names closer to unique */
	'id' => 'header-widget-area',
	'description' => __('This horizontal widget area is placed right before the standard Header Image. See options on Main Options:Header tab. Be sure to set width for each widget added.', 'weaver-ii'/*a*/ ),
	'before_widget' => "\t\t" . '<td id="%1$s" class="header-widget %2$s">' . "\n",
	'after_widget' => "</td>\n",
	'before_title' => '<span class="header-widget-title">',
	'after_title' => '</span>',
	) );

	## Site-wide top area
	weaverii_register_sidebar(__( 'Sitewide Top Widget Area', 'weaver-ii'/*a*/ ),
	    'sitewide-top-widget-area',
	     __( 'This widget area appears at the top of the content area on all site static pages and post pages (including special post pages) EXCEPT pages using the blank or iframe page templates.', 'weaver-ii'/*a*/ ));

	## Site-wide bottom area
	weaverii_register_sidebar(__( 'Sitewide Bottom Widget Area', 'weaver-ii'/*a*/ ),
	    'sitewide-bottom-widget-area',
	    __( 'This widget area appears at the bottom of the content area on all site static pages and post pages (including special post pages) EXCEPT pages using the blank or iframe page templates.', 'weaver-ii'/*a*/ ));

	## page top widget area
	weaverii_register_sidebar(__( 'Pages Top Widget Area', 'weaver-ii'/*a*/ ),
	    'top-widget-area',
	     __( 'The top widget area appears above the content area of pages. It is not displayed on archive-like post pages (archives, etc.).', 'weaver-ii'/*a*/ ));

	## page bottom widget area
	weaverii_register_sidebar(__( 'Pages Bottom Widget Area', 'weaver-ii'/*a*/ ),
	    'bottom-widget-area', __( 'The bottom widget area appears below the content area. It is not displayed on archive-like post pages.', 'weaver-ii'/*a*/ ));

	## posts top widget area
	weaverii_register_sidebar(__( 'Blog Top Widget Area', 'weaver-ii'/*a*/ ),
	    'blog-top-widget-area',
	     __( 'The blog top widget area appears above the content area of blog pages, including page with posts templates. It is not displayed on archive-like post pages.', 'weaver-ii'/*a*/ ));

	## posts blog bottom widget area
	weaverii_register_sidebar(__( 'Blog Bottom Widget Area', 'weaver-ii'/*a*/ ),
	    'blog-bottom-widget-area', __( 'The blog bottom widget area appears below the content area of blog pages, including page with posts templates. It is not displayed on archive-like post pages.', 'weaver-ii'/*a*/ ));


	## Special Post Pages Top Widget area
	weaverii_register_sidebar(__( 'Archive-like Pages Top Widget Area', 'weaver-ii'/*a*/ ),
	    'postpages-widget-area',
	    __( 'This widget area will appear at the top of archive-like post pages (archives, attachment, author, category, single post).', 'weaver-ii'/*a*/ ));


	// Area 3, located in the footer. Empty by default.
	weaverii_register_sidebar( __( 'First Footer Widget Area', 'weaver-ii'/*a*/ ),
	    'first-footer-widget-area',
	     __( 'The first footer widget area. Note: Footer widget areas auto-adujust width depending on how many areas you use.', 'weaver-ii'/*a*/ ));

	// Area 4, located in the footer. Empty by default.
	weaverii_register_sidebar(__( 'Second Footer Widget Area', 'weaver-ii'/*a*/ ),
	    'second-footer-widget-area',
	    __( 'The second footer widget area', 'weaver-ii'/*a*/ ));

	// Area 5, located in the footer. Empty by default.
	weaverii_register_sidebar(__( 'Third Footer Widget Area', 'weaver-ii'/*a*/ ),
	    'third-footer-widget-area',
	    __( 'The third footer widget area', 'weaver-ii'/*a*/ ));

	weaverii_register_sidebar(__( 'Fourth Footer Widget Area', 'weaver-ii'/*a*/ ),
	    'fourth-footer-widget-area',
	    __( 'The fourth footer widget area', 'weaver-ii'/*a*/ ));

	// Mobile device
	weaverii_register_sidebar(__( 'Mobile Device Widget Area', 'weaver-ii'/*a*/ ),
	    'mobile-widget-area',
	     __( 'This widget area provides an alternate area for Mobile Devices. It is displayed between the content and the footer, and uses the same styling as the Primary (top) Sidebar.', 'weaver-ii'/*a*/ ));

	$extra_areas = weaverii_getopt('wii_perpagewidgets');	// create extra areas?
	if (strlen($extra_areas) > 0) {
	    $extra_list = explode(',', $extra_areas);
	    foreach ($extra_list as $area) {
		weaverii_register_sidebar( __('Per Page Area ', 'weaver-ii'/*a*/ ) . $area,
		    'per-page-'.$area,
		    __('This widget area can be added using "', 'weaver-ii'/*a*/ ) .
		       $area . __('" as the name for Per Page options or the [weaver_widget_area] shortcode. Style it using: ', 'weaver-ii'/*a*/ ) .
		       '".per-page-' . $area .'".'
		    );
	    }

	}
}

add_action( 'widgets_init', 'weaverii_widgets_init' );

if (!function_exists('weaverii_register_sidebar')) {
/**
 * Register widgetized areas: two default sidebars, two content areq sidebars,
 * a top area for specialized post pages, alternative sidebar for template pages,
 * and a header widget area.
 *
 * To override weaverii_widgets_init() in a child theme, remove the action hook and add your own
 * function tied to the init hook.
 *
 * @uses register_sidebar
 */
function weaverii_register_sidebar($name, $id, $desc, $altclass='') {
    if ($altclass != '') $altclass .= ' ';
    register_sidebar( array(
	'name' => '&#149; ' . $name,	/* the &#149; makes our names closer to unique */
	'id' => $id,
	'description' => $desc,
	'before_widget' => '<aside id="%1$s" class="widget ' . $altclass . '%2$s">',
	'after_widget' => '</aside>',
	'before_title' => '<h3 class="widget-title">',
	'after_title' => '</h3>',
	) );
}
}

if (!function_exists('weaverii_inject_area')) {
function weaverii_inject_area($name) {
    $area_name = 'wii_' . $name . '_insert';
    $hide_front = 'wii_hide_front_' . $name;
    $hide_rest = 'wii_hide_rest_' . $name;
    $idinj = 'inject_' . $name;
    $html = weaverii_getopt($area_name);
    $per_page_code = weaverii_get_per_page_value($name);	/* per page values */

    if (!empty($html) || !empty($per_page_code)) {
	if ($name !='postpostcontent')
	    echo("\t<div id=\"$idinj\">\n");
	else
	    echo("\t<div class=\"$idinj\">\n");
	if (!empty($html)) {	/* area insert defined? */
	    if (is_front_page()) {
		if (!weaverii_getopt($hide_front)) echo (do_shortcode($html));
	    } else if (!weaverii_getopt($hide_rest)) {
		echo (do_shortcode($html));
	    }
	}

	if (!empty($per_page_code)) {
	    echo(do_shortcode($per_page_code));
	}
	echo("\t</div><!-- #$idinj -->\n");
    }
}
}

if (!function_exists('weaverii_content_nav')) {
/**
 * Display navigation to next/previous pages when applicable
 */
function weaverii_content_nav( $nav_id , $from_search=false) {
    global $wp_query;

    if ( $wp_query->max_num_pages > 1 ) {
?>
	<nav id="<?php echo $nav_id; ?>">
	    <h3 class="assistive-text"><?php _e( 'Post navigation','weaver-ii'); ?></h3>
<?php
	// @@@@@@@ use prev/next on mobile

	if (weaverii_getopt('wii_nav_style') == 'prev_next' || $from_search ) {
?>
	    <div class="nav-previous"><?php next_posts_link('<span class="meta-nav">&larr; </span>' . __('Previous Post','weaver-ii')); ?></div>
	    <div class="nav-next"><?php previous_posts_link( __('Next Post','weaver-ii') . '<span class="meta-nav">&rarr; </span>'); ?></div>
<?php
	} else if (weaverii_getopt('wii_nav_style') == 'paged_left' && !weaverii_use_mobile('mobile')) {
	    echo ("\t<div class=\"nav-previous\">");
	    if (function_exists ('wp_pagenavi')) {
		wp_pagenavi();
	    } else
	    if ( function_exists( 'wp_paginate' ) ) {
		wp_paginate( 'title=' );
	    } else {
		echo weaverii_get_paginate_archive_page_links( 'plain',2,3 );
	    }
	    echo "\t</div>\n";
	} else if (weaverii_getopt('wii_nav_style') == 'paged_right' && !weaverii_use_mobile('mobile')) {
	    echo ("\t<div class=\"nav-next\">");
	    if (function_exists ('wp_pagenavi')) {
		wp_pagenavi();
	    } else
	    if ( function_exists( 'wp_paginate' ) ) {
		wp_paginate( 'title=' );
	    } else {
		echo weaverii_get_paginate_archive_page_links( 'plain',2,3 );
	    }
	    echo "\t</div>\n";
	} else {	// Older/Newer posts
?>
	    <div class="nav-previous"><?php next_posts_link( weaverii_trans('w_15_trans', __( '<span class="meta-nav">&larr;</span> Older posts','weaver-ii')) ); ?></div>
	    <div class="nav-next"><?php previous_posts_link( weaverii_trans('w_16_trans', __( 'Newer posts <span class="meta-nav">&rarr;</span>','weaver-ii')) ); ?></div>
<?php	} ?>
	</nav><!-- #<?php echo $nav_id;?> -->
<?php
    }
}
}


/**
 * Return the URL for the first link found in the post content.
 *
 * @since Weaver II 1.0
 * @return string|bool URL or false when no link is present.
 */
function weaverii_url_grabber() {
	if ( ! preg_match( '/<a\s[^>]*?href=[\'"](.+?)[\'"]/is', get_the_content(), $matches ) )
		return false;

	return esc_url_raw( $matches[1] );
}

/**
 * Count the number of footer sidebars to enable dynamic classes for the footer
 */
function weaverii_footer_sidebar_class() {
    $count = 0;

    if ( is_active_sidebar( 'first-footer-widget-area' ) )
	$count++;
    if ( is_active_sidebar( 'second-footer-widget-area' ) )
	$count++;
    if ( is_active_sidebar( 'third-footer-widget-area' ) )
	$count++;
    if ( is_active_sidebar( 'fourth-footer-widget-area' ) )
	$count++;
    $class = '';
    switch ( $count ) {
	case '1':
	    $class = 'one';
	    break;
	case '2':
	    $class = 'two';
	    break;
	case '3':
	    $class = 'three';
	    break;
	case '4':
	    $class = 'four';
	    break;
	}
	if ( $class )
	    echo 'class="' . $class . '"';
}

if ( ! function_exists( 'weaverii_comment' ) ) {
/**
 * Template for comments and pingbacks.
 *
 * To override this walker in a child theme without modifying the comments template
 * simply create your own weaverii_comment(), and that function will be used instead.
 *
 * Used as a callback by wp_list_comments() for displaying the comments.
 *
 * @since Weaver II 1.0
 */
function weaverii_comment( $comment, $args, $depth ) {
	$GLOBALS['comment'] = $comment;
	switch ( $comment->comment_type ) {
		case 'pingback' :
		case 'trackback' :
	?>
	<li class="post pingback">
		<p><?php _e( 'Pingback:','weaver-ii'); ?> <?php comment_author_link(); ?><?php edit_comment_link( __( 'Edit','weaver-ii'), '<span class="edit-link">', '</span>' ); ?></p>
	<?php
			break;
		default :
	?>
	<li <?php comment_class(); ?> id="li-comment-<?php comment_ID(); ?>" >
		<article id="comment-<?php comment_ID(); ?>" class="comment">
			<footer class="comment-meta">
				<div class="comment-author vcard">
<?php
				$avatar_size = 40;
				if ( '0' != $comment->comment_parent )
					$avatar_size = 32;

				echo get_avatar( $comment, $avatar_size );

				/* translators: 1: comment author, 2: date and time */
				printf( weaverii_trans('w_17_trans', __( '%1$s on %2$s <span class="says">said:</span>','weaver-ii')),
				    sprintf( '<span class="fn">%s</span>', get_comment_author_link() ),
				    sprintf( '<a href="%1$s"><time pubdate datetime="%2$s">%3$s</time></a>',
					esc_url( get_comment_link( $comment->comment_ID ) ),
					get_comment_time( 'c' ),
					/* translators: 1: date, 2: time */
					sprintf( weaverii_trans('w_18_trans', __( '%1$s at %2$s','weaver-ii')), get_comment_date(), get_comment_time() )
				    )
				);
?>

					<?php edit_comment_link( __( 'Edit','weaver-ii'), '<span class="edit-link">', '</span>' ); ?>
				</div><!-- .comment-author .vcard -->

				<?php if ( $comment->comment_approved == '0' ) : ?>
					<em class="comment-awaiting-moderation"><?php _e( 'Your comment is awaiting moderation.','weaver-ii'); ?></em>
					<br />
				<?php endif; ?>

			</footer>

			<div class="comment-content"><?php comment_text(); ?></div>

			<div class="reply">
				<?php comment_reply_link( array_merge( $args, array( 'reply_text' => weaverii_trans('w_19_trans', __( 'Reply <span>&darr;</span>','weaver-ii')), 'depth' => $depth, 'max_depth' => $args['max_depth'] ) ) ); ?>
			</div><!-- .reply -->
		</article><!-- #comment-## -->

	<?php
			break;
	} /* end switch */
}
} // ends check for weaverii_comment()

if ( ! function_exists( 'weaverii_entry_header' ) ) {
/**
 * Prints the entry-header (title)
 *
 * @since Weaver II 1.0
 */
function weaverii_entry_header($format_title='') {
    /* display entery header for posts */
?>
	    <hgroup class="entry-hdr">
<?php

    if ($format_title != '')
	echo "\t\t\t\t<h3 class=\"entry-format\">" . $format_title . "</h3>\n";
    weaverii_post_title('<h2 class="entry-title">', '</h2>');
?>
	    </hgroup>
<?php
}
}

if ( ! function_exists( 'weaverii_post_title' ) ) {
// display the post title
function weaverii_post_title($before='', $after='', $single = '') {

    if (weaverii_sc_getopt('hide_title')) return;

    if ($single != 'single' && weaverii_is_checked_post_opt('ttw-favorite-post')) {
	    $before = $before . sprintf("<img class=\"post-fav-star\" src=\"%s\" />", weaverii_relative_url('images/icons/yellow-star.png'));
    }
    if (('page' == get_post_type() && !is_search()) || (weaverii_getopt('wii_post_no_titlelink')
	|| weaverii_is_checked_post_opt('wvpp_post_no_titlelink')) ) {
	echo("\t\t" . $before); the_title();
    } else {
	echo("\t\t" . $before);
?>
	<a href="<?php the_permalink(); ?>" title="<?php printf( esc_attr(weaverii_trans('w_9_trans', __( 'Permalink to %s','weaver-ii'))),
	   the_title_attribute( 'echo=0' ) ); ?>" rel="bookmark"><?php the_title(); ?></a>
<?php

    }

    if ( (weaverii_getopt('wii_show_post_avatar')
	    || weaverii_is_checked_post_opt('ttw-show-post-avatar')
	    || weaverii_sc_getopt('show_avatar'))
	&& !weaverii_getopt('wii_show_tiny_avatar')) {
?>
	    <div class="post-avatar post-avatar-normal">
	    <?php echo(get_avatar( get_the_author_meta('user_email') ,44,null,'avatar')); ?>
	    </div>
<?php
    }
    echo($after . "\n");
}
} // if weaverii_post_title

if (!function_exists('weaverii_chat_title')) {
    function weaverii_chat_title() {
?>
	<a href="<?php the_permalink(); ?>" title="<?php printf( esc_attr(weaverii_trans('w_9_trans', __( 'Permalink to %s','weaver-ii'))),
	   the_title_attribute( 'echo=0' ) ); ?>" rel="bookmark"><img class='format-chat-icon' src="<?php echo esc_attr(weaverii_relative_url('images/icons/chat.png')); ?>" /></a>
		    <?php the_author(); ?>:&nbsp;<span class="entry-meta" style="margin-left:5em;font-weight:normal;">
<?php			printf('<a href="%s" title="Chat" rel="bookmark"><time class="entry-date" datetime="%s" pubdate>%s</time></a> - %s',
				esc_url( get_permalink() ), esc_attr( get_the_date( 'c' ) ), esc_html( get_the_date() ), esc_attr( get_the_time() ));
?>
			</span>
<?php
    }
}

if ( ! function_exists( 'weaverii_posted_on' ) ) {
/**
 * Prints HTML with meta information for the current post-date/time and author.
 * Create your own weaverii_posted_on to override in a child theme
 *
 * @since Weaver II 1.0
 */
function weaverii_posted_on($type='') {

    if (weaverii_getopt_checked('wii_post_info_hide_top')
	|| weaverii_is_checked_post_opt('hide_top_post_meta')
	|| weaverii_is_checked_page_opt('ttw_hide_pp_infotop')
	|| weaverii_sc_getopt('hide_top_info'))	// hide top?
	return;

    if (($my_on = weaverii_getopt('_wvr_custom_posted_on_single')) != '' && $type == 'single') {	// %%%% CUSTOM POSTED ON SINGLE %%%%
	weaverii_post_info_line($my_on);
   	return;
    }

    if (($my_on = weaverii_getopt('_wvr_custom_posted_on')) != '' && $type != 'single') {	// %%%% CUSTOM POSTED ON %%%%
	weaverii_post_info_line($my_on);
	return;
    }

    echo "\t\t\t<div " . weaverii_meta_icons_class() . ">\n\t\t\t";

    printf( weaverii_trans('w_20_trans', __( '<span class="sep">Posted on </span><a href="%1$s" title="%2$s" rel="bookmark"><time class="entry-date" datetime="%3$s" pubdate>%4$s</time></a><span class="by-author"> <span class="sep"> by </span> <span class="author vcard"><a class="url fn n" href="%5$s" title="%6$s" rel="author">%7$s</a></span></span>','weaver-ii')),
		esc_url( get_permalink() ),
		esc_attr( get_the_time() ),
		esc_attr( get_the_date( 'c' ) ),
		esc_html( get_the_date() ),
		esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ),
		sprintf( esc_attr(weaverii_trans('w_13_trans', __( 'View all posts by %s','weaver-ii'))), get_the_author() ),
		esc_html( get_the_author() )
	);
    if ( (weaverii_getopt('wii_show_post_avatar')
	    || weaverii_is_checked_post_opt('ttw-show-post-avatar')
	    || weaverii_sc_getopt('show_avatar'))
	&& weaverii_getopt('wii_show_tiny_avatar')) { ?>
	    <span class="post-avatar" style="padding-left:8px;position:relative; top:4px;">
	    <?php echo(get_avatar( get_the_author_meta('user_email') ,22,null,'avatar')); ?>
	    </span>
<?php
    }
    echo "\n\t\t\t</div><!-- .entry-meta-icons -->";
}
}

if (! function_exists('weaverii_format_posted_on_footer')) {
function weaverii_format_posted_on_footer($who) {
?>
		<footer class="entry-utility">
<?php 		weaverii_posted_on();
		if ( comments_open() ) {
			echo '<span ' . weaverii_meta_icons_class() . '><span class="comments-link">';
			comments_popup_link( '<span class="leave-reply">' . '&nbsp;&nbsp;' . weaverii_trans('w_6_trans', __( 'Leave a reply','weaver-ii')) . '</span>',weaverii_trans('w_7_trans', __( '<b>1</b> Reply','weaver-ii')),
			    weaverii_trans('w_8_trans', __( '<b>%</b> Replies','weaver-ii')) ); ?></span></span>

			<?php } ?>
			<?php edit_post_link( __( 'Edit','weaver-ii'), '<span class="edit-link">', '</span>' ); ?>
		</footer><!-- #entry-utility -->
<?php
}
}

function weaverii_meta_icons_class() {
    // 'wii_post_hide_date', 'wii_post_hide_author', 'wii_post_hide_cats', 'wii_hide_singleton_cat', 'wii_post_hide_tags'
    $class = '';
    if (weaverii_getopt('wii_post_hide_date')) {		// check for hide various elements
	if ($class != '') $class .= ' ';
	$class .= 'post_hide_date';
    }
    if (weaverii_getopt('wii_post_hide_author')) {		// check for hide various elements
	if ($class != '') $class .= ' ';
	$class .= 'post_hide_author';
    }
    if (weaverii_getopt('wii_post_hide_cats')) {		// check for hide various elements
	if ($class != '') $class .= ' ';
	$class .= 'post_hide_cats';
    }
    if (weaverii_getopt('wii_hide_singleton_cat')) {	// check for hide various elements
	if ($class != '') $class .= ' ';
	$class .= 'post_hide_single_cat';
    }
    if (weaverii_getopt('wii_post_hide_tags')) {		// check for hide various elements
	if ($class != '') $class .= ' ';
	$class .= 'post_hide_tags';
    }
    if (weaverii_getopt('wii_hide_permalink')) {		// check for hide various elements
	if ($class != '') $class .= ' ';
	$class .= 'post_hide_permalink';
    }

    if ($class != '' || weaverii_getopt('wii_post_icons')) {
	if ($class != '') $class .= ' ';
	$class .= 'entry-meta-icons';
    }
    if ($class != '') {
	return 'class="' . $class . '"';
    }
    return '';
}

if ( ! function_exists( 'weaverii_posted_in' ) ) {
/**
 * Prints HTML with meta information for the current post-date/time and author.
 * Create your own weaverii_posted_on to override in a child theme
 *
 * @since Weaver II 1.0
 */
function weaverii_posted_in($type='') {

    if (weaverii_getopt_checked('wii_post_info_hide_bottom')
	|| weaverii_is_checked_post_opt('hide_bottom_post_meta')
	|| weaverii_is_checked_page_opt('ttw_hide_pp_infobot')
	|| weaverii_sc_getopt('hide_bottom_info'))	// hide bottom?
	return;

    if (($my_in = weaverii_getopt('_wvr_custom_posted_in_single')) != '' && $type == 'single') {	// %%%% CUSTOM POSTED IN SINGLE %%%%
	weaverii_post_info_line($my_in);
   	return;
    }
    if (($my_in = weaverii_getopt('_wvr_custom_posted_in')) != '' && $type != 'single') {	// %%%% CUSTOM POSTED IN SINGLE %%%%
	weaverii_post_info_line($my_in);
	edit_post_link( __( 'Edit','weaver-ii'), '<span class="edit-link">', '</span>' );
	return;
    }

    echo '<div ' . weaverii_meta_icons_class() . ">\n";

    if ($type == 'single') {
	/* translators: used between list items, there is a space after the comma */
	$categories_list = get_the_category_list( __( ', ','weaver-ii') );

	/* translators: used between list items, there is a space after the comma */
	$tags_list = get_the_tag_list( '', __( ', ','weaver-ii') );
	if ( '' != $tags_list ) {
	    $utility_text = weaverii_trans('w_1_trans',__( 'This entry was posted in %1$s and tagged %2$s by <a href="%6$s">%5$s</a>. Bookmark the <a href="%3$s" title="Permalink to %4$s" rel="bookmark">permalink</a>.','weaver-ii'));
	} elseif ( '' != $categories_list ) {
	    $utility_text = weaverii_trans('w_2_trans', __( 'This entry was posted in %1$s by <a href="%6$s">%5$s</a>. Bookmark the <a href="%3$s" title="Permalink to %4$s" rel="bookmark">permalink</a>.','weaver-ii'));
	} else {
	    $utility_text = weaverii_trans('w_3_trans', __( 'This entry was posted by <a href="%6$s">%5$s</a>. Bookmark the <a href="%3$s" title="Permalink to %4$s" rel="bookmark">permalink</a>.','weaver-ii'));
	}
	if (weaverii_meta_icons_class() == '') {	// not showing icons
	    printf(
		$utility_text,
		$categories_list,
		$tags_list,
		esc_url( get_permalink() ),
		the_title_attribute( 'echo=0' ),
		get_the_author(),
		esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) )
	    );
	} else {
	    if ( $categories_list ) {
		$cat_count = count( get_the_category() );
		if ($cat_count < 2 && weaverii_getopt_checked('wii_hide_singleton_cat'))
		    echo ("\t\t\t<span class=\"cat-links post_hide_singleton_cat\">\n");
		else
		    echo ("\t\t\t<span class=\"cat-links\">\n");
		printf( weaverii_trans('w_4_trans', __( '<span class="%1$s">Posted in</span> %2$s','weaver-ii')), 'entry-utility-prep entry-utility-prep-cat-links', $categories_list );
?>
			</span>
<?php 		} // End if categories
			/* translators: used between list items, there is a space after the comma */

	    if ( $tags_list ) {
?>
			<span class="tag-links">
<?php 			printf( weaverii_trans('w_5_trans', __( '<span class="%1$s">Tagged</span> %2$s','weaver-ii')), 'entry-utility-prep entry-utility-prep-tag-links', $tags_list );
?>
			</span>
<?php 	    } // End if $tags_list
?>
	    <span class="permalink-icon"><a href="<?php echo esc_url( get_permalink() ); ?>" title="Permalink to <?php the_title_attribute(); ?>" rel="bookmark"><?php _e('permalink','weaver-ii'); ?></a></span>
<?php
	} // end using icons

	edit_post_link( __( 'Edit','weaver-ii'), '<span class="edit-link">', '</span>' );

    } else if ($type == 'reply') {
	$dummy = true;
    } else {	// else not single
     		$show_sep = false;
		if ( 'page' != get_post_type() ) { // Hide category and tag text for pages on Search

			/* translators: used between list items, there is a space after the comma */
			$categories_list = get_the_category_list( __( ', ','weaver-ii') );
			$cat_count = count( get_the_category() );
			$skip =  ($cat_count < 2 && weaverii_getopt_checked('wii_hide_singleton_cat'));
			if ( $categories_list && !$skip) { ?>
			<span class="cat-links">
<?php 			printf( weaverii_trans('w_4_trans', __( '<span class="%1$s">Posted in</span> %2$s','weaver-ii')), 'entry-utility-prep entry-utility-prep-cat-links', $categories_list );
				$show_sep = true; ?>
			</span>
<?php 			} // End if categories
			/* translators: used between list items, there is a space after the comma */
			$tags_list = get_the_tag_list( '', __( ', ','weaver-ii') );
			if ( $tags_list ) {
				if ( $show_sep ) { ?>
			<span class="sep"> | </span>
<?php 				} // End if $show_sep ?>
			<span class="tag-links">
<?php 				printf( weaverii_trans('w_5_trans', __( '<span class="%1$s">Tagged</span> %2$s','weaver-ii')), 'entry-utility-prep entry-utility-prep-tag-links', $tags_list );
				$show_sep = true; ?>
			</span>
<?php 			} // End if $tags_list
		} // End if 'page' != get_post_type()

		if ( comments_open() ) {
			if ( $show_sep ) { ?>
			<span class="sep"> | </span>
<?php 			} // End if $show_sep ?>
			<span class="comments-link"><?php comments_popup_link( '<span class="leave-reply">' . weaverii_trans('w_6_trans', __( 'Leave a reply','weaver-ii')) . '</span>',weaverii_trans('w_7_trans', __( '<b>1</b> Reply','weaver-ii')),
			    weaverii_trans('w_8_trans', __( '<b>%</b> Replies','weaver-ii')) ); ?></span>
<?php 		} // End if comments_open()
		edit_post_link( __( 'Edit','weaver-ii'), '<span class="edit-link">', '</span>' );
    }	// end non-single
?>
	</div><!-- .entry-meta-icons -->
<?php
}
}

function weaverii_post_info_line($info) {
    // build a custom info line based on template in info
/*
%date%, %date-icon%, %author%, %author-icon%, %author-avatar%, %tag%, %tag-icon%, %tag:Label-if-are-tags%, %category%, %category-icon%,
%comments%, %comments-icon%, %permalink%, %permalink-icon% (just the icon) $permalink:Permalink-text% %title% %post-format%
*/

    $out = $info;
    /* translators: used between list items, there is a space after the comma */
    $categories_list = get_the_category_list( __( ', ','weaver-ii') );
    $cats = '';
    if ( $categories_list ) {
	$cats .= '<span class="cat-links">' . $categories_list . '</span>';
    } // End if categories

    /* translators: used between list items, there is a space after the comma */
    $tags_list = get_the_tag_list( '', __( ', ','weaver-ii') );
    $tags = '';
    if ( $tags_list ) {
	$tags .= '<span class="tag-links">' . $tags_list . '</span>';
    } // End if categories

    $date = sprintf('<a href="%s" title="%s" rel="bookmark"><time class="entry-date" datetime="%s" pubdate>%s</time></a>',
	esc_url( get_permalink() ),
	esc_attr( get_the_time() ),
	esc_attr( get_the_date( 'c' ) ),
	esc_html( get_the_date() ));


    $author = sprintf('<span class="author vcard by-author"><a class="url fn n" href="%s" title="%s" rel="author">%s</a></span></span>',
	esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ),
	sprintf( esc_attr(weaverii_trans('w_13_trans', __( 'View all posts by %s','weaver-ii'))), get_the_author() ),
	esc_html( get_the_author()));

    $avatar = '<span class="post-avatar post-avatar-tiny"> ' .
	    get_avatar( get_the_author_meta('user_email') ,22,null,'avatar') . '</span>';

    $comments = '';
    // need to strip these
    $com0 = weaverii_get_info_arg('comments0',$out);
	$out = weaverii_replace_info_text('comments0',$out,false);	// strip it out now
	if (!$com0) $com0 = weaverii_trans('w_6_trans', __( 'Leave a reply','weaver-ii'));

	$com1 = weaverii_get_info_arg('comments1',$out);
	$out = weaverii_replace_info_text('comments1',$out,false);	// strip it out now
	if (!$com1) $com1 = weaverii_trans('w_7_trans', __( '<b>1</b> Reply','weaver-ii'));

	$com2 = weaverii_get_info_arg('comments2',$out);
	$out = weaverii_replace_info_text('comments2',$out,false);	// strip it out now
	if (!$com2) $com2 = weaverii_trans('w_8_trans', __( '<b>%</b> Replies','weaver-ii')) ;
    if ( comments_open() ) {	// fix with custom wording...

	// -------------------------------------------------------

	global $wpcommentspopupfile, $wpcommentsjavascript;
	$clink = '';
	$id = get_the_ID();
	$number = get_comments_number( $id );

	if ( post_password_required() ) {
		$clink .=  __('Enter your password to view comments.','weaver-ii');
	} else {
	    $clink .= '<a href="';
	    if ( $wpcommentsjavascript ) {
		if ( empty( $wpcommentspopupfile ) )
		    $home = home_url();
		else
		    $home = get_option('siteurl');
		$clink .= $home . '/' . $wpcommentspopupfile . '?comments_popup=' . $id .
		    '" onclick="wpopen(this.href); return false"';
	    } else { // if comments_popup_script() is not in the template, display simple comment link
		if ( 0 == $number )
			$clink .= get_permalink() . '#respond';
		else
			$clink .= get_comments_link();
		$clink .= '"';
	    }

	    $title = the_title_attribute( array('echo' => 0 ) );

	    $clink .= ' title="' . esc_attr( sprintf( __('Comment on %s','weaver-ii'), $title ) ) . '">';
	    if ( $number > 1 ) {
		$ltext = $com2;
	    }
	    elseif ( $number == 0 ) {
		$ltext = $com0;
	    }
	    else  {// must be one
		$ltext = $com1;
	    }
	    $ltext = str_replace('#','%',$ltext);
	    $clink .= str_replace('%', number_format_i18n($number), $ltext) . '</a>';
	}

	// ========================================================

	$comments .= '<span class="comments-link">' . $clink . '</span>';

	$comments_icon = str_replace('comments-link','comments-link-icon',$comments);
	$out = weaverii_replace_info_text('comments',$out,true);	// add conditional text for tags
    } // End if comments_open()
    $out = weaverii_replace_info_text('comments',$out,false);	// strip comments: if still there

    $title = esc_html(get_the_title());

    $permalink_text = weaverii_get_info_arg('permalink',$out);	// alt permalink wording
    if (!$permalink_text) $permalink_text = __('permalink','weaver-ii');

    $out = weaverii_replace_info_text('permalink',$out,false);	// strip it out now

    $permalink = '<span class="permalink"><a href="' . esc_url( get_permalink() ) . '" title="Permalink to ' .
	$title . '" rel="bookmark">' . $permalink_text . '</a></span>';
    $permalink_icon = '<span class="permalink-icon"><a href="' . esc_url( get_permalink() ) . '" title="Permalink to ' .
	$title . '" rel="bookmark">' . $permalink_text . '</a></span>';


    $out = str_replace('%date%',$date,$out);
    $out = str_replace('%date-icon%','<span class="entry-date-icon">&nbsp;</span>',$out);
    if ($author) {
	$out = str_replace('%author%',$author,$out);
	$out = str_replace('%author-icon%','<span class="by-author-icon">&nbsp;</span>',$out);
    } else {
	$out = str_replace('%author%','',$out);
	$out = str_replace('%author-icon%','',$out);
    }
    if ($cats) {
	$out = str_replace('%category%',$cats,$out);
	$out = str_replace('%category-icon%','<span class="cat-links-icon">&nbsp;</span>',$out);
    } else {
	$out = str_replace('%category%','',$out);
	$out = str_replace('%category-icon%','',$out);
    }
    if ($tags) {
	$out = str_replace('%tag%',$tags,$out);
	$out = str_replace('%tag-icon%','<span class="tag-links-icon">&nbsp;</span>',$out);
	$out = weaverii_replace_info_text('tag',$out,true);	// add conditional text for tags
    } else {
	$out = str_replace('%tag%','',$out);
	$out = str_replace('%tag-icon%','',$out);
	$out = weaverii_replace_info_text('tag',$out,false);	// clean if no tags
    }
    $out = str_replace('%avatar%',$avatar,$out);
    $out = str_replace('%permalink%',$permalink,$out);
    $out = str_replace('%permalink-icon%',$permalink_icon,$out);
    $out = str_replace('%comments%',$comments,$out);
    $out = str_replace('%comments-icon%',$comments_icon,$out);
    $out = str_replace('%title%',$title,$out);
    $out = str_replace('%post-format%', get_post_format(),$out);
    $out = str_replace('%day%',esc_attr(get_the_date('j')),$out);
    $out = str_replace('%day0%',esc_attr(get_the_date('d')),$out);
    $out = str_replace('%weekday%',esc_attr(get_the_date('l')),$out);
    $out = str_replace('%month%',esc_attr(get_the_date('F')),$out);
    $out = str_replace('%month0%',esc_attr(get_the_date('m')),$out);
    $out = str_replace('%month3%',esc_attr(get_the_date('M')),$out);
    $out = str_replace('%month-num%',esc_attr(get_the_date('n')),$out);
    $out = str_replace('%year%',esc_attr(get_the_date('Y')),$out);

    echo $out;
}

function weaverii_replace_info_text($name,$text,$do_replace) {
    // replace with text or delete
    $out = $text;
    $start = strpos($out, '%'. $name .':');
    if ($start === false)
	return $out;		// nothing to do
    $rest = substr($out,$start + strlen($name) + 2 );	// rest of the string
    $endmark = strpos($rest,'%');		// where the % ends
    $string = substr($rest,0,$endmark);		// the string
    $rep = ($do_replace) ? $string : '';
    return str_replace('%'.$name.':'.$string.'%',$rep,$out);
}

function weaverii_get_info_arg($name,$text) {
    // get the value
    $out = $text;
    $start = strpos($out, '%'. $name .':');
    if ($start === false) {
	return '';		// nothing to do
    }
    $rest = substr($out,$start + strlen($name) + 2 );	// rest of the string
    $endmark = strpos($rest,'%');		// where the % ends
    $string = substr($rest,0,$endmark);		// the string
    return $string;
}

if ( ! function_exists('weaverii_post_format_reply')){
function weaverii_post_format_reply() {
    // just a reply link for some of the post format templates
    if ( comments_open() ) { ?>

	<span class="comments-link"><?php comments_popup_link( '<span class="leave-reply">' . weaverii_trans('w_6_trans', __( 'Leave a reply','weaver-ii')) . '</span>',weaverii_trans('w_7_trans',__( '<b>1</b> Reply','weaver-ii')),
	    weaverii_trans('w_8_trans', __( '<b>%</b> Replies','weaver-ii')) ); ?></span>
<?php
    }
    edit_post_link( __( 'Edit','weaver-ii'), '<span class="edit-link">', '</span>' );
}
}

if ( ! function_exists( 'weaverii_post_top_info' ) ) {
/**
 * Prints HTML with meta information for the top meta line.
 *
 * @since Weaver II 1.0
 */
function weaverii_post_top_info($type='') {
    // $type for single
    if (!weaverii_getopt_checked('wii_post_info_move_top'))
	weaverii_posted_on($type);
    if (weaverii_getopt_checked('wii_post_info_move_bottom'))
	weaverii_posted_in($type);
}
}

if ( ! function_exists( 'weaverii_post_bottom_info' ) ) {
/**
 * Prints HTML with meta information for the bottom meta line.
 *
 * @since Weaver II 1.0
 */
function weaverii_post_bottom_info($type='') {
    if (weaverii_getopt_checked('wii_post_info_move_top'))
	weaverii_posted_on($type);
    if (!weaverii_getopt_checked('wii_post_info_move_bottom'))
	weaverii_posted_in($type);
}
}


if ( ! function_exists( 'weaverii_comments_popup_link' ) ) {
function weaverii_comments_popup_link() {
    /* display comment bubble for posts */
    if ( !weaverii_getopt_checked('wii_hide_post_bubble') && comments_open() && ! post_password_required() ) { ?>
			<div class="comments-link">
<?php 			comments_popup_link( '<span class="leave-reply">' . weaverii_trans('w_10_trans', __( 'Reply','weaver-ii')) . '</span>',weaverii_trans('w_11_trans', _x( '1', 'comments number','weaver-ii')),weaverii_trans('w_12_trans', _x( '%', 'comments number','weaver-ii')) ); ?>
			</div>
<?php
    }
}
}

/**
 * Add classes to body depending of page type to make sidebar templates work.
 *
 * So, we will have blog, page, alt-left, alt-right, archive, attachement, page-posts
 *
 * @since Weaver II 1.0
 */
function weaverii_body_classes( $classes ) {

    if ( ! is_multi_author() ) {
	$classes[] = 'single-author';
    }

    if ( is_singular() && ! is_home() )
	$classes[] = 'singular';

    if (!is_user_logged_in())
	$classes[] = 'not-logged-in';

    if (weaverii_use_mobile('mobile'))
	$classes[] = 'weaver-mobile';

    if (weaverii_use_mobile('phone'))
	$classes[] = 'weaver-phone';

    if (weaverii_use_mobile('tablet'))
	$classes[] = 'weaver-tablet';

    if (weaverii_use_mobile('smalltablet')) {
	if (weaverii_get_mobile_browser() == 'WeaverMobileSmallTablet')
	    $classes[] = 'weaver-smalltablet-sim';
	else
	    $classes[] = 'weaver-smalltablet';	// want all the weaver-mobile rules to work
    }

    if (weaverii_mobile_getos() == 'flat')
	$classes[] = 'weaver-flat';

    if (weaverii_getopt_checked('wii_theme_width_fixed'))
	$classes[] = 'weaver-fixed-width';

    return $classes;
}
add_filter( 'body_class', 'weaverii_body_classes' );

// ========================= tinyMCE =================================
/* route tinyMCE to our stylesheet */
function weaverii_mce_css($default_style) {
    /* replace the default editor-style.css with custom CSS generated on the fly by the php version */
    if (weaverii_getopt('_wii_hide_editor_style'))
	return $default_style;

    $mce_css_file = trailingslashit(get_template_directory()) . 'editor-style-css.php';
    $mce_css_dir = trailingslashit(get_template_directory_uri()) . 'editor-style-css.php';
    if (!@file_exists($mce_css_file)) {	// see if it is there
	return $default_style;
    }
    /* do we need to do anything about rtl? */

    /* if we have a custom style file, return that instead of the default */
    // Build the overrides
    $put = '?mce=1';	// cheap way to start with ?

    if (($val = weaverii_getopt('wii_theme_width_int'))) {
	/*  figure out a good width - we will please most of the users, most of the time
	    We're going to assume that mostly people will use the default layout -
	    we can't actually tell if the editor will be for a page or a post at this point.
	    And let's just assume the default sidebar widths.
	*/
	$default = weaverii_getopt('wii_layout_default');
	$twidth = 650;
	switch ($default) {
	case 'right-2-col':
	case 'right-2-col-bottom':
	case 'left-2-col':
	case 'left-2-col-bottom':
	    $twidth = 580;
	    break;		// no left sidebar for these layouts

	case 'split':
	    $twidth = 580;
	    break;

	case 'one-column':
	    $twidth = 870;
	    break;

	case 'right-1-col':
	case 'left-1-col':
	default:
	    $twidth = 650;
	    break;
	}

	if ($val != 940) {	// they've changed the width
	    $twidth = $twidth + (int)(($val-940)*.67); // .67 by trial and error
	}
	if ($twidth != 650) {
	    $put .= '&twidth=' . urlencode($twidth);
	}
    }

    if (($val = weaverii_getopt('wii_site_fontsize_int')))	// base font size
	$put .= '&fontsize=' . urlencode($val);

    if (($val = weaverii_getopt('wii_content_font')) != '') {	// content_font
	$put .= '&fontfamily=' . urlencode($val);
    }

    if (($val = weaverii_getopt('wii_title_font')) != '') {	// title font - just in tables
	$put .= '&titlefont=' . urlencode($val);
    }

    /* need to handle bg color of content area - need to do the cascade ourself */
    if (($val = weaverii_getopt('wii_editor_bgcolor')) && strcasecmp($val,'transparent') != 0) {	/* alt bg color */
	$put .= '&bg=' . urlencode($val);
    } else if (($val = weaverii_getopt("wii_content_bgcolor")) && strcasecmp($val,'transparent') != 0) {	/* #content */
	$put .= '&bg=' . urlencode($val);
    } else if (($val = weaverii_getopt("wii_container_bgcolor")) && strcasecmp($val,'transparent') != 0) {	/* #container */
	$put .= '&bg=' . urlencode($val);
    } else if (($val = weaverii_getopt('wii_main_bgcolor')) && strcasecmp($val,'transparent') != 0) { /* #main */
	$put .= '&bg=' . urlencode($val);
    } else if (($val = weaverii_getopt('wii_page_bgcolor')) && strcasecmp($val,'transparent') != 0) { /* #wrapper */
	$put .= '&bg=' . urlencode($val);
    } else if (($name = weaverii_getopt('wii_subtheme')) && strcasecmp($name,'Transparent Dark') === 0) {
	$put .= '&bg=' . urlencode('#222');
    } else if (($name = weaverii_getopt('wii_subtheme')) && strcasecmp($name,'Transparent Light') === 0) {
	$put .= '&bg=' . urlencode('#ccc');
    }

    if (($val = weaverii_getopt('wii_content_color')) ) {	// text color
	$put .= '&textcolor=' . urlencode($val);
    }

    if (($val = weaverii_getopt('wii_content_headings_color')) ) {	// headings color
	$put .= '&hdgcolor=' . urlencode($val);
    }

    if (($val = weaverii_getopt('wii_input_bgcolor')) ) {	// input area
	$put .= '&inbg=' . urlencode($val);
    }
    if (($val = weaverii_getopt('wii_input_color')) ) {
	$put .= '&incolor=' . urlencode($val);
    }

    if (($val = weaverii_getopt('wii_link_color')) ) {	// link
	$put .= '&a=' . urlencode($val);
    }
    if (($val = weaverii_getopt('wii_link_hover_color')) ) {
	$put .= '&ahover=' . urlencode($val);
    }

    if (($val = weaverii_getopt('wii_weaverii_tables')) ) {	// table type
	$put .= '&table=' . urlencode($val);
    }

    if (($val = weaverii_getopt('wii_contentlist_bullet')) ) {	// list bullet
	$put .= '&list=' . urlencode($val);
    }

    // images
    if (($val = weaverii_getopt('wii_caption_color')) ) {	// image caption, border color, width
	$put .= '&imgcapt=' . urlencode($val);
    }
    if (($val = weaverii_getopt('wii_media_lib_border_color')) ) {
	$put .= '&imgbcolor=' . urlencode($val);
    }
    if (($val = weaverii_getopt('wii_media_lib_border_int')) ) {
	$put .= '&imgbwide=' . urlencode($val);
    }

    return $mce_css_dir . $put;
}

add_filter('mce_css','weaverii_mce_css');

// ========================= special content =========================
if (! function_exists('weaverii_the_page_contnt_featured')) {
function weaverii_the_page_contnt_featured($include_content=true) {

    if (get_post_thumbnail_id() && !weaverii_getopt('wii_hide_page_featured')) {
	$image = wp_get_attachment_image_src( get_post_thumbnail_id(), 'post-thumbnail' );
	if ($image[1] < HEADER_IMAGE_WIDTH ) {
?>
	<span class='featured-image'><a href="<?php the_permalink(); ?>" title="<?php printf( esc_attr(weaverii_trans('w_9_trans', __( 'Permalink to %s','weaver-ii'))),
	    the_title_attribute( 'echo=0' ) ); ?>" rel="bookmark"><?php the_post_thumbnail( 'thumbnail' ); ?></a></span>
<?php
	}
    }
    if (!$include_content) {
	 echo ("<div class=\"clear-cols\"></div>");
	 return;
    }
    weaverii_the_contnt();
    echo ("<div class=\"clear-cols\"></div>");
}
}

if (! function_exists('weaverii_the_contnt_featured')) {
function weaverii_the_contnt_featured() {

    if (get_post_thumbnail_id() &&
	(weaverii_getopt('wii_show_featured_image_fullposts')
	|| (weaverii_getopt('wii_always_excerpt') && weaverii_getopt('wii_show_featured_image_excerptedposts'))
	|| weaverii_is_checked_post_opt('ttw-show-featured')
	|| weaverii_is_checked_page_opt('wvr_show_pp_featured_img')
	|| weaverii_sc_getopt('ttw_show_featured')
	)) {
	$image = wp_get_attachment_image_src( get_post_thumbnail_id(), 'post-thumbnail' );
	if ($image[1] < HEADER_IMAGE_WIDTH ) {
?>
	<span class='featured-image'><a href="<?php the_permalink(); ?>" title="<?php printf( esc_attr(weaverii_trans('w_9_trans', __( 'Permalink to %s','weaver-ii'))),
	    the_title_attribute( 'echo=0' ) ); ?>" rel="bookmark"><?php the_post_thumbnail( 'thumbnail' ); ?></a></span>
<?php
	}
    }
    global $more;
    $more = false;		// need this to make it act like regular blog page
    $m = weaverii_continue_reading_link(false);
    weaverii_the_contnt($m);
    echo ("<div class=\"clear-cols\"></div>");
}
}

if (!function_exists('weaverii_the_contnt_featured_single')) {
function weaverii_the_contnt_featured_single() {
    if (get_post_thumbnail_id() &&
	(weaverii_getopt('wii_show_featured_image_fullposts')
	 || weaverii_is_checked_post_opt('ttw-show-featured')
	 || weaverii_is_checked_page_opt('wvr_show_pp_featured_img')
	 || weaverii_sc_getopt('ttw_show_featured')
	)) {
	$image = wp_get_attachment_image_src( get_post_thumbnail_id( ), 'post-thumbnail' );
	if ($image[1] < HEADER_IMAGE_WIDTH ) {
	?>
	<span class='featured-image'><a href="<?php the_permalink(); ?>" title="<?php printf( esc_attr(weaverii_trans('w_9_trans', __( 'Permalink to %s','weaver-ii'))),
	    the_title_attribute( 'echo=0' ) ); ?>" rel="bookmark"><?php the_post_thumbnail( 'thumbnail-single' ); ?></a></span>
	<?php
	}
    }
    weaverii_the_contnt();
    echo ("<div class=\"clear-cols\"></div>");
}
}

if (!function_exists('weaverii_the_excerpt_featured')) {
function weaverii_the_excerpt_featured($always_excerpt=false, $force_featured=false) {
    if (weaverii_getopt('wii_show_featured_image_excerptedposts')
	|| weaverii_is_checked_post_opt('ttw-show-featured')
	|| weaverii_sc_getopt('show_featured_image')
	|| weaverii_is_checked_page_opt('wvr_show_pp_featured_img')
	|| $force_featured) {
	$image = wp_get_attachment_image_src( get_post_thumbnail_id( ), 'post-thumbnail' );
	if ($image[1] < HEADER_IMAGE_WIDTH ) {
	?>

	<span class='featured-image'><a href="<?php the_permalink(); ?>" title="<?php printf( esc_attr(weaverii_trans('w_9_trans', __( 'Permalink to %s','weaver-ii'))),
	    the_title_attribute( 'echo=0' ) ); ?>" rel="bookmark"><?php the_post_thumbnail( 'thumbnail' ); ?></a></span>
	<?php
    }
    }
    the_excerpt('more...');
    echo ("<div class=\"clear-cols\"></div>");
}
}

if (!function_exists('weaverii_the_contnt')) {
function weaverii_the_contnt($m='') {
    if (weaverii_is_checked_page_opt('wvr_raw_html') || weaverii_is_checked_post_opt('wvr_raw_html')) {
	echo do_shortcode(get_the_content($m));
    } else {
	the_content($m);
    }
}
}

function weaverii_show_only_title() {
    if (weaverii_get_per_page_value('wvr_pwp_type') == 'title_featured') {
	// title has been displayed - add the featured image after
	$image = wp_get_attachment_image_src( get_post_thumbnail_id( ), 'post-thumbnail' );
	if ($image[1] < HEADER_IMAGE_WIDTH ) {
	?>
	<span class='featured-image'><a href="<?php the_permalink(); ?>" title="<?php printf( esc_attr(weaverii_trans('w_9_trans', __( 'Permalink to %s','weaver-ii'))),
	    the_title_attribute( 'echo=0' ) ); ?>" rel="bookmark"><?php the_post_thumbnail( 'thumbnail' ); ?></a></span>
	<div style="clear:both;"></div>
	<?php
	}
	return true;
    }
    return weaverii_get_per_page_value('wvr_pwp_type') == 'title' || weaverii_sc_getopt('show') == 'title';
}

if (!function_exists('weaverii_do_excerpt()')) {
function weaverii_do_excerpt() {
    // return true if this kind of page should be excerpted

    if (weaverii_sc_getopt('show') == 'excerpt')
	return true;

    if (weaverii_is_checked_post_opt('ttw-force-post-excerpt'))
	return true;

    if (weaverii_is_checked_post_opt('ttw-force-post-full'))
	return false;


    $pwp = weaverii_get_per_page_value('wvr_pwp_type');

    if ($pwp == 'full')	// need to check before archive/search
	return false;	// override global setting
    if ($pwp == 'excerpt')
	return true;	// override global setting


    if (is_search()) {
	return !weaverii_getopt_checked('wii_fullpost_search');
    }
    if (is_archive()) {
	return !weaverii_getopt_checked('wii_fullpost_archive');
    }

    return weaverii_getopt_checked('wii_excerpt_blog') || weaverii_excerpt_mobile();
}
}

if (!function_exists('weaverii_show_post_format')) {
function weaverii_show_post_format($postID) {
    // use special post template to display a post in the blog if a special post format
    if (function_exists('get_post_format')) {	// for 3.1
	$post_format = get_post_format($postID);
	if ($post_format != '') {
	    get_template_part('content', $post_format);
	    return true;
	}
    }
    return false;
}
}

function weaverii_page_menu() {
    /* handle sf-menu for wp_page_menu */
    $menu = wp_page_menu(array('echo' => false));
    if (weaverii_getopt('wii_use_superfish') || weaverii_mobile_usesf() ) {
	$ulpos = stripos($menu, '<ul>');
	if ($ulpos !== false) {
	    echo substr_replace($menu, '<ul class="sf-menu">',$ulpos, 4);
	}
    } else {
	echo $menu;
    }
}

if ( ! function_exists( 'weaverii_per_post_style' ) ) {
function weaverii_per_post_style() {
    // Emit a <style> for this post
    global $weaverii_cur_post_id;

    $post_style = weaverii_get_per_post_value('ttw_per_post_style');
    if (!empty($post_style)) {
	$rules = explode('}', trim($post_style));
	$post_id = '#post-' . $weaverii_cur_post_id;
	echo ("\n<style type=\"text/css\">\n");
	foreach ($rules as $rule) {
	    $rule = trim($rule);
	    if (strlen($rule) > 1)  		// must have some content to the rule!
		echo("$post_id $rule}\n");	// add the post id to the front of each rule
	}
	echo("</style>\n");
    }
}
}

// ========================= sidebars ================================

if ( ! function_exists( 'weaverii_get_sidebar_left' ) ) {
function weaverii_get_sidebar_left($who) {
    if (weaverii_use_mobile('mobile') && !weaverii_use_mobile('smalltablet'))
	return;
    $layout = weaverii_get_page_layout($who);

    switch ($layout) {
	case 'right-1-col':
	case 'right-2-col':
	case 'right-2-col-bottom':
	    break;		// no left sidebar for these layouts

	case 'split':
	    get_sidebar('left-split');
	    break;

	case 'left-1-col':
	case 'left-2-col':
	case 'left-2-col-bottom':
	    get_sidebar($layout);
	    break;

	default:
	    break;
    }
}
} // end function exists

if ( ! function_exists( 'weaverii_get_sidebar_right' ) ) {
function weaverii_get_sidebar_right($who) {
    if (weaverii_use_mobile('mobile') && !weaverii_use_mobile('smalltablet'))
	return;
    $layout = weaverii_get_page_layout($who);

    switch ($layout) {
	case 'right-1-col':
	case 'right-2-col':
	case 'right-2-col-bottom':
	    get_sidebar($layout);
	    break;

	case 'split':
	    get_sidebar('right-split');
	    break;

	case 'left-1-col':
	case 'left-2-col':
	case 'left-2-col-bottom':
	    break;		// no right sidebar for these layouts

	default:
	    break;
    }
}
} // end function exists

if ( ! function_exists( 'weaverii_get_sidebar_top' ) ) {
function weaverii_get_sidebar_top($who) {

    if (!weaverii_is_checked_page_opt('sitewide-top-widget-area'))
	weaverii_put_widgetarea('sitewide-top-widget-area','sidebar_top');	// sitewide top

    if (!weaverii_is_checked_page_opt('top-widget-area')) {
    switch ($who) {
	case 'index':
	case 'pwp':
	case 'single':
	    weaverii_put_widgetarea('blog-top-widget-area','sidebar_top');
	    break;

	case 'page':
	    weaverii_put_widgetarea('top-widget-area','sidebar_top');
	    break;

	case 'archive':
	case 'author':
	case 'category':
	case 'tag':
	case 'search':
	    weaverii_put_widgetarea('postpages-widget-area','sidebar_top');
	    break;

	case 'image':
	case '404':
	default:
	    break;
    }
    } // end not per page hide

    weaverii_put_perpage_widgetarea();		// and any per page widget area
}
} // end function exists

if ( ! function_exists( 'weaverii_get_sidebar_bottom' ) ) {
function weaverii_get_sidebar_bottom($who) {

    if (!weaverii_is_checked_page_opt('bottom-widget-area')) {
    switch ($who) {
	case 'index':
	case 'pwp':
	case 'single':
	    weaverii_put_widgetarea('blog-bottom-widget-area','sidebar_bottom');
	    break;

	case 'page':
	    weaverii_put_widgetarea('bottom-widget-area','sidebar_bottom');
	    break;

	case 'archive':
	case 'author':
	case 'category':
	case 'tag':
	case 'search':
	    break;

	case '404':
	    return;

	case 'image':

	default:
	    break;
    }
    } // end not hide bottom per page

    if (!weaverii_is_checked_page_opt('sitewide-bottom-widget-area'))
	weaverii_put_widgetarea('sitewide-bottom-widget-area','sidebar_bottom');		// sitewide bottom
}
} // end function exists

if ( ! function_exists( 'weaverii_get_page_layout' ) ) {
function weaverii_get_page_layout($who) {
    // determine the layout structure of a page from the settings.
    // blogs, pages, and single will use the 'right-1-col' as a default
    // others will be 'none' - no sidebars - by default
    // each page can be set to its own default. Individual pages
    // can be set to a layout on a per-page basis.

    $default = weaverii_getopt('wii_layout_default');
    if (!$default) $default = 'right-1-col';	// use something!
    $arc_default = weaverii_getopt('wii_layout_default_archive');
    if (!$arc_default) $arc_default = 'one-column';	// use something!

    $per_page = weaverii_get_per_page_value('wvr_page_layout');
    if ($per_page != '')
        return $per_page;

    switch ($who) {
	case 'index':
	case 'pwp':
	    $l = weaverii_getopt('wii_layout_blog');
	    return (!$l || $l == 'default') ? $default : $l;

	case 'single':
	    if (weaverii_is_checked_post_opt('ttw_hide_sidebars'))
		return 'one-column';
	    $l = weaverii_getopt('wii_layout_single');
	    return (!$l || $l == 'default') ? $default : $l;

	case 'page':
	    $l = weaverii_getopt('wii_layout_page');
	    return (!$l || $l == 'default') ? $default : $l;

	case 'archive':
	    $l = weaverii_getopt('wii_layout_archive');
	    return (!$l || $l == 'default') ? $arc_default : $l;

	case 'author':
	    $l = weaverii_getopt('wii_layout_author');
	    return (!$l || $l == 'default') ? $arc_default : $l;

	case 'category':
	    $l = weaverii_getopt('wii_layout_category');
	    return (!$l || $l == 'default') ? $arc_default : $l;

	case 'tag':
	    $l = weaverii_getopt('wii_layout_tag');
	    return (!$l || $l == 'default') ? $arc_default : $l;

	case 'search':
	    $l = weaverii_getopt('wii_layout_search');
	    return (!$l || $l == 'default') ? $arc_default : $l;break;

	case 'image':
	    $l = weaverii_getopt('wii_layout_image');
	    return (!$l || $l == 'default') ? $arc_default : $l;

	case '404':
	    return 'one-column';

	default:
	    return $default;
    }

    return $default;
}
} // end function exists

if ( ! function_exists( 'weaverii_get_page_class' ) ) {
function weaverii_get_page_class($who, $extra = '', $noecho = false) {
	$class = $extra;
	if ($class != '') $class .= ' equal_height';
	else $class = 'equal_height';
	$layout = weaverii_get_page_layout($who);
	if ($class == '')
	    $class = $layout;
	else
	    $class .= ' ' . $layout;

	if ($class != '')
	    $class = ' class="' . $class . '"';
	if (!$noecho ) echo ($class);
	return $class;
}
} // end function exists

if (! function_exists('weaverii_show_primary_sidebar')) {
function weaverii_show_primary_sidebar() {
    // WordPress widget code is screwed up. If NO widget areas are defined, then it is possible
    // for primary-widget-area to not be active. If the other two are active, then the is_active_sidebar
    // for primary will be true, also, even if it has no widgets. Thus we use the ob stuff.
    // If no areas are defined, then the is_active fails, and we end up at the default message.
    if (!weaverii_is_checked_page_opt('hide_sidebar_primary') && !weaverii_replace_primary()) {
	if ( is_active_sidebar( 'primary-widget-area' ) ) {
	    ob_start();	// make sure not empty
	    $success = dynamic_sidebar( 'primary-widget-area' );
	    $content = ob_get_clean();
	    if ($success) {
?>
   	<div id="sidebar_primary" class="widget-area" style="clear:both;" role="complementary">
<?php	echo $content;
?>
	</div><!-- #sidebar_primary .widget-area -->
<?php 	    }
	} else if (!is_active_sidebar( 'right-widget-area' ) && !is_active_sidebar( 'left-widget-area' )) {	// no active primary or right
?>
  	<div id="sidebar_primary" class="widget-area" style="clear:both;" role="complementary">
    	    <aside id="sidebar_primary_default" class="widget">
		<h3 class="widget-title"><?php _e( 'Primary Sidebar Area', 'weaver-ii'/*a*/ ); ?></h3>
		<ul><li>
<?php 		_e("This theme has been designed to be used with sidebars. This message will no longer be displayed after you add at least one widget to any of the Sidebar Widget Areas using the Appearance &rarr; Widgets control panel.", 'weaver-ii'/*a*/ ); ?>
		</li>
		<li>
		<?php wp_loginout(); ?>
		</li>
		</ul>
	    </aside>
	</div>
<?php
	} // no active primary or right
    } // not hidden, not replaced
}
}

if (!function_exists('weaverii_put_wvr_widgetarea')) {

function weaverii_put_widgetarea($area, $style ) {
    // emit ttw widget area depending on various settings (for page.php and index.php)

    if (weaverii_is_checked_page_opt($area)) return;		// hide area option checked

    if ($area != 'mobile-widget-area' && weaverii_use_mobile('mobile') && !weaverii_use_mobile('smalltablet') && weaverii_getopt_checked('wii_mobile_hide_topbottom_widgets'))
	return;

    if (is_active_sidebar($area)) { /* add top and bottom widget areas */
	ob_start(); /* let's use output buffering to allow use of Dynamic Widgets plugin and not have empty sidebar */
	$success = dynamic_sidebar($area);
	$content = ob_get_clean();
	if ($success) {
?>
	<div id="<?php echo $area; ?>" class="widget-area <?php echo $style; ?>" role="complementary">
<?php	echo($content) ; ?>
	</div><!-- <?php echo $area; ?> -->
<?php
	}
    }
}
}

//============================ Header and Footer ===================================

if ( ! function_exists( 'weaverii_get_header' ) ) {
function weaverii_get_header($who, $name='') {
    get_header($name);
}
} // end function exists

if ( ! function_exists( 'weaverii_get_footer' ) ) {
function weaverii_get_footer($who,$name='') {
    get_footer($name);
}
} // end function exists

// ================================ Cache Support ================================

function weaverii_quickcache_md5_salt($ignore) {
    // support for quickcache plugin - allows full mobile device support
    // this is a filter for qc - add apply_filters('weaverii_qcmd5salt','') to the qc md5 option
    // @@@ need to add fix for compact/full view
    global $weaverii_mobile, $weaverii_mobile_view;
    weaverii_setup_mobile();

    if ($weaverii_mobile_view) $full = '';
    else $full = 'full';

    if (weaverii_use_mobile()) {
	if (!is_set($weaver_mobile) || !$weaver_mobile)
	    $ret = 'mobile' . $full;	// sim
	else
	    $ret = $weaver_mobie['type'] . $full;
	weaverii_log('quickcache_md5_salt', $ret);
	return $ret;
    }

    return '';
}

// ================================ Weaver II admin ================================

function weaverii_wp_head() {
    require_once('includes/wphead.php');
    weaverii_generate_wphead();
}

function weaverii_unlink_page($link, $id) {
    $stay = get_post_meta($id, 'ttw-stay-on-page', true);
    if ($stay) {
	return "#";
    } else {
	return $link;
    }
}

function weaverii_get_css_filename() {
    $updir = wp_upload_dir();
    return trailingslashit($updir['basedir']) . 'weaverii-subthemes/style-weaverii.css';
}

function weaverii_get_css_url() {
    $updir = wp_upload_dir();
    return trailingslashit($updir['baseurl']) . 'weaverii-subthemes/style-weaverii.css';
}

function weaverii_add_admin() {
    /* adds our admin panel  (add_action: admin_menu) */
    // 'edit_theme_options' works for both single and multisite
    $page = add_theme_page('WeaverII', WEAVERII_THEMENAME . ' ' . __('Admin', 'weaver-ii'/*a*/ ), 'edit_theme_options', 'WeaverII', 'weaverii_admin');
    /* using registered $page handle to hook stylesheet loading for this admin page */
    add_action('admin_print_styles-'.$page, 'weaverii_admin_scripts');

    $page2 = add_theme_page('WeaverII_Shortcodes', '&nbsp;&nbsp;' . __('Shortcodes + Pro', 'weaver-ii'/*a*/ ), 'edit_theme_options', 'WeaverII_Shortcodes', 'weaverii_admin_sc');
    /* using registered $page handle to hook stylesheet loading for this admin page */
    add_action('admin_print_styles-'.$page2, 'weaverii_admin_scripts');
}

function weaverii_admin() {
    $wp_vers = $GLOBALS['wp_version'];
    $cur_vers = $wp_vers;
    $beta = strpos($cur_vers, '-');
    if($beta > 0) {
	$cur_vers = substr($cur_vers,0,$beta);	// strip the beta part if there
    }
    if (version_compare($cur_vers, WEAVERII_MIN_WPVERSION, '<')) {
	echo '<br><br><h2 style="padding:4px;background:pink;">ERROR: You are using WordPress Version ' . $GLOBALS['wp_version'] . '. Weaver II requires <em>WordPress Version ' . WEAVERII_MIN_WPVERSION . '</em> or above. You should always upgrade to the latest version of WordPress for maximum site performance and security.</h2>';
	return;
    }

    require_once(dirname( __FILE__ ) . '/includes/admin-top.php'); // NOW - load the admin stuff
    weaverii_do_admin();
}

function weaverii_admin_sc() {
    require_once(dirname( __FILE__ ) . '/includes/pro/admin-pro-sc-top.php'); // NOW - load the admin stuff
    weaverii_pro_sc_admin();
}

function weaverii_admin_scripts() {
    /* called only on the admin page, enqueue our special style sheet here (for tabbed pages) */
    wp_enqueue_style('wiiStylesheet', get_template_directory_uri().'/admin-style.css');

    wp_enqueue_style ("thickbox");
    wp_enqueue_script ("thickbox");

    wp_enqueue_script('wiiJscolor', get_template_directory_uri().'/js/jscolor/jscolor.js');
    wp_enqueue_script('wiiYetii', get_template_directory_uri().'/js/yetii/yetii-min.js');
    wp_enqueue_script('wiiHide', get_template_directory_uri().'/js/theme/hide-css.js');
    wp_enqueue_script('wiiMediaLib', get_template_directory_uri().'/js/theme/media-lib.js');
}

function weaverii_admin_head() {
}

function weaverii_enqueue_scripts() {
    if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
	wp_enqueue_script( 'comment-reply' );
    }

    if (weaverii_getopt('wii_use_superfish') || weaverii_mobile_usesf() || weaverii_getopt_checked('wvr_flow_to_bottom')) {
	wp_enqueue_script( 'jquery' );
	//wp_enqueue_script('weaverSFhoverIntent', get_template_directory_uri().'/js/superfish/hoverIntent.js');
	//wp_enqueue_script('weaverSF', get_template_directory_uri().'/js/superfish/superfish.js');
	if (weaverii_getopt('wii_use_superfish') || weaverii_mobile_usesf())
	    wp_enqueue_script('weaverSF', get_template_directory_uri().'/js/superfish/wvr-superfish.js'); // above 2 combined
	if (weaverii_getopt_checked('wvr_flow_to_bottom'))
	    wp_enqueue_script('weaverEqualHieghts', get_template_directory_uri().'/js/equalheights.js');
    }
    wp_enqueue_script('weaverJSLib', get_template_directory_uri().'/js/weaverjslib.js');	// small, so load always
}

if (!function_exists('weaverii_facebook_meta')) {
function weaverii_facebook_meta() {
    /* code for Facebook
    Show og information and image_src info only if image supplied
    */

    $siteimg = weaverii_getopt('_wii_imgsrc_url');
    if ($siteimg != '' ) {
	if (!weaverii_getopt_checked('_wii_hide_metainfo')) {
?>
<meta property="og:title" content="<?php bloginfo('name');?>" />
<meta property="og:type" content="website" />
<meta property="og:url" content="<?php echo get_home_url();?>" />
<meta property="og:site_name" content="<?php bloginfo('name'); ?>" />
<meta property="og:description" content="<?php bloginfo('description'); ?>" />
<?php } ?>
<meta property="og:image" content="<?php echo $siteimg; ?>" />
<link rel="image_src" href="<?php echo $siteimg; ?>" />
<?php
    }
}
}

function weaverii_wp_title($title) {

    if (weaverii_getopt('_wii_hide_metainfo')) {
	return $title;		// this is compatible with SEO plugins
    } else {
	/*
	 * Print the <title> tag based on what is being viewed. THIS CODE DIRECTLY FROM TWENTY ELEVEN
	 */
	global $page, $paged;

	$t = '';

	if ($title) {
	    $title = trim(str_replace('&raquo;','',$title));
	    $t = $title . ' | ';
	}

	$t .= get_bloginfo('name');

	/* Add the blog description for the home/front page. */
	$site_description = get_bloginfo( 'description', 'display' );
	if ( $site_description && ( is_home() || is_front_page() ) )
		$t .= " | $site_description";

	/* Add a page number if necessary: */
	if ( $paged >= 2 || $page >= 2 )
		$t .= ' | ' . sprintf( __( 'Page %s','weaver-ii'), max( $paged, $page ) );
    }
    return $t;
}

// Change what's hidden by default - show Custom Fields and Discussion by default!

function weaverii_hidden_meta_boxes($hidden, $screen) {
	if ( 'post' == $screen->base || 'page' == $screen->base )
		$hidden = array('slugdiv', 'trackbacksdiv', 'postexcerpt', 'commentsdiv', 'authordiv', 'revisionsdiv');
		// removed 'postcustom', 'commentstatusdiv',
	return $hidden;
}

function weaverii_pre_get_posts($query) {
    return $query;
    $types = weaverii_getopt('wvr_show_post_types');

    $types = array('post','author');
    if (is_page())
    $types = array('page');

    if ( $types && !$query->query_vars['suppress_filters'] ) {
	$query->set( 'post_type', $types);
    }
    return $query;
}

function weaverii_the_excerpt_filter($excerpt) {
    return do_shortcode($excerpt);
}

function weaverii_get_wp_title_rss($title) {
    /* need to fix our add a | blog name to wp_title */
    $ft = str_replace(' | ','',$title);
    return str_replace(get_bloginfo('name'),'',$ft);
}

// apply_filters('get_bloginfo_rss', convert_chars($info), $show);


require_once(dirname( __FILE__ ) . '/settings.php');	// settings stay in theme root directory
require_once(dirname( __FILE__ ) . '/includes/lib-runtime.php');	// standard runtime library
require_once(dirname( __FILE__ ) . '/includes/pro/lib-runtime-pro.php'); // pro runtime library
require_once(dirname( __FILE__ ) . '/includes/widgets.php'); 		// widgets runtime library
require_once(dirname( __FILE__ ) . '/includes/shortcodes.php'); 	// shortcode runtime library
require_once(dirname( __FILE__ ) . '/includes/admin-page-posts.php');	// page-posts admin

/* This is where the theme hooks into the rest of WordPress */
// ==FILTERS
add_filter('page_link', 'weaverii_unlink_page', 10, 2);		// for stay on page
add_filter('wp_title', 'weaverii_wp_title', 10, 1);		// filter the title
add_filter('default_hidden_meta_boxes', 'weaverii_hidden_meta_boxes', 10, 2);
add_filter('the_excerpt','weaverii_the_excerpt_filter', 10,1);
add_filter('get_wp_title_rss', 'weaverii_get_wp_title_rss',10,1);
// add_filter('pre_get_posts', 'weaverii_pre_get_posts' );

// ==ACTIONS
add_action('admin_init', 'weaverii_admin_init_cb');
add_action('wp_head', 'weaverii_wp_head');
add_action('admin_menu', 'weaverii_add_admin');
add_action('admin_head', 'weaverii_admin_head');
add_action('wp_enqueue_scripts', 'weaverii_enqueue_scripts' );
?>
