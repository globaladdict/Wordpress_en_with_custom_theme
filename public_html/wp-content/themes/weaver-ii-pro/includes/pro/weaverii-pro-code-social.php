<?php
/*
Weaver II Pro Social Shortcode/Widget - Version 1.0

CODE

This code is Copyright 2011 by Bruce Wampler, all rights reserved.
This code is licensed under the terms of the accompanying license file: license.html.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
*/
/* ============================ weaveriip_extra_menu =============================== */
$weaveriip_social_services = array(
    array ('icon'=>'amazon', 'site'=>'www.amazon.com' , 'blurb'=>'Amazon.com'),
    array ('icon'=>'bebo', 'site'=>'www.bebo.com' , 'blurb'=>'Bebo: Social networking'),
    array ('icon'=>'behance', 'site'=>'www.behance.net' , 'blurb' => 'Behance NETWORK: The Creative Professional Platform'),
    array ('icon'=>'blip', 'site'=>'blip.tv' , 'blurb'=>'blip.tv: Independent TV'),
    array ('icon'=>'blogger', 'site'=>'www.amazon.com' , 'blurb'=>'blogger.com/blogspot.com: blogging by Google'),
    array ('icon'=>'daytum', 'site'=>'daytum.com' , 'blurb'=>'DAYTUM: Communicate everyday data'),
    array ('icon'=>'delicious', 'site'=>'www.delicious.com' , 'blurb'=>'Delicious: Bookmarking'),
    array ('icon'=>'design-bump', 'site'=>'designbump.com' , 'blurb'=>'designbump: Design related links'),
    array ('icon'=>'designfloat', 'site'=>'www.designfloat.com' , 'blurb'=>'deisgn float: Web Design related links'),
    array ('icon'=>'deviant-art', 'site'=>'www.deviantart.com' , 'blurb'=>'deviantArt: community of artists and those devoted to art'),
    array ('icon'=>'digg', 'site'=>'digg.com' , 'blurb'=>'The best news, videos and pictures on the web as voted on by the Digg community'),
    array ('icon'=>'dribbble', 'site'=>'dribbble.com' , 'blurb'=>'Dribbble is show and tell for creatives'),
    array ('icon'=>'ebay', 'site'=>'ebay.com' , 'blurb'=>'Shop eBay.'),
    array ('icon'=>'email', 'site'=>'# E-mail link (mailto:you@example.com or url)' , 'blurb'=>'Send Email to this Site\'s Admin'),
    array ('icon'=>'facebook', 'site'=>'facebook.com' , 'blurb'=>'Facebook: social networking'),
    array ('icon'=>'feedburner', 'site'=>'feedburner.google.com' , 'blurb'=>'Subscribe to this site\'s feeds with Feedburner'),
    array ('icon'=>'feedburner-rss', 'site'=>'feedburner.google.com' , 'blurb'=>'Subscribe to this site\'s feeds with Feedburner'),
    array ('icon'=>'flickr', 'site'=>'www.flickr.com' , 'blurb'=>'flickr: Share photos and video.'),
    array ('icon'=>'forrst', 'site'=>'forrst.com' , 'blurb'=>'Forrst: developer and designer community'),
    array ('icon'=>'foursquare', 'site'=>'foursquare.com' , 'blurb'=>'foursquare: Explore your city'),
    array ('icon'=>'friendfeed', 'site'=>'friendfeed.com' , 'blurb'=>'friendfeed: share interesting stuff from the web'),
    array ('icon'=>'friendster', 'site'=>'www.friendster.com' , 'blurb'=>'friendster: social gaming destination'),
    array ('icon'=>'gdgt', 'site'=>'gdgt.com' , 'blurb'=>'gdgt: Gadget reviews, support, and answers'),
    array ('icon'=>'google-buzz', 'site'=>'www.google.com/buzz' , 'blurb'=>'Google Buzz: Updates, photos, videos, and more'),
    array ('icon'=>'googleplus', 'site'=>'plus.google.com' , 'blurb'=>'Google+: Real-life sharing rethought for the web'),
    array ('icon'=>'gowalla-2', 'site'=>'gowalla.com' , 'blurb'=>'Gowalla: blogging and sharing'),
    array ('icon'=>'lastfm', 'site'=>'www.last.fm' , 'blurb'=>'last.fm: Online music'),
    array ('icon'=>'linkedin', 'site'=>'www.linkedin.com' , 'blurb'=>'Linked in: Professional contact information'),
    array ('icon'=>'meetup', 'site'=>'www.meetup.com' , 'blurb'=>'meetup: Meeting scheduling, sharing'),
    array ('icon'=>'metacafe', 'site'=>'www.metacafe.com' , 'blurb'=>'metacafe: Video sharing'),
    array ('icon'=>'msn', 'site'=>'msn.com' , 'blurb'=>'MSN: Microsoft\s portal'),
    array ('icon'=>'myspace', 'site'=>'www.myspace.com' , 'blurb'=>'Myspace: Social Entertainment'),
    array ('icon'=>'newsvine', 'site'=>'www.newsvine.com' , 'blurb'=>'Newsvine: community news service'),
    array ('icon'=>'photobucket', 'site'=>'www.photobucket.com' , 'blurb'=>'Photobucket: image hosting and sharing'),
    array ('icon'=>'picasa', 'site'=>'picasa.google.com' , 'blurb'=>'Picasa: Photo sharing from Google'),
    array ('icon'=>'podcast', 'site'=>'#Enter address of podcast' , 'blurb'=>'Listen to our podcast'),
    array ('icon'=>'posterous', 'site'=>'posterous.com' , 'blurb'=>'Posterous: content publishing and sharing'),
    array ('icon'=>'qik', 'site'=>'qik.com' , 'blurb'=>'qik: mobile phone video sharing'),
    array ('icon'=>'rss', 'site'=>'# Enter URL of your site\'s feed' , 'blurb'=>'This site\'s RSS feed'),
    array ('icon'=>'rss-black', 'site'=>'# Enter URL of your site\'s feed' , 'blurb'=>'This site\'s RSS feed'),
    array ('icon'=>'rss-blue', 'site'=>'# Enter URL of your site\'s feed' , 'blurb'=>'This site\'s RSS feed'),
    array ('icon'=>'rss-green', 'site'=>'# Enter URL of your site\'s feed' , 'blurb'=>'This site\'s RSS feed'),
    array ('icon'=>'rss-red', 'site'=>'# Enter URL of your site\'s feed' , 'blurb'=>'This site\'s RSS feed'),
    array ('icon'=>'rss-yellow', 'site'=>'# Enter URL of your site\'s feed' , 'blurb'=>'This site\'s RSS feed'),
    array ('icon'=>'reddit', 'site'=>'www.reddit.com' , 'blurb'=>'reddit: User-generated news links'),
    array ('icon'=>'skype', 'site'=>'www.skype.com' , 'blurb'=>'Skype: Video and phone calling'),
    array ('icon'=>'slideshare', 'site'=>'www.slideshare.net' , 'blurb'=>'slideshare: presentations and power points'),
    array ('icon'=>'smugmug', 'site'=>'www.smugmug.com' , 'blurb'=>'SmugMug: Photo sharing'),
    array ('icon'=>'soundcloud', 'site'=>'soundcloud.com' , 'blurb'=>'SoundCloud: Shared sound creations'),
    array ('icon'=>'stumbleupon', 'site'=>'www.stumbleupon.com' , 'blurb'=>'StumbleUpon: discover the best of the web'),
    array ('icon'=>'technorati', 'site'=>'technorati.com' , 'blurb'=>'Technorati: search and list for user-generated media'),
    array ('icon'=>'tumblr', 'site'=>'www.tumblr.com' , 'blurb'=>'Tumblr: blogging'),
    array ('icon'=>'twitter', 'site'=>'twitter.com' , 'blurb'=>'Twitter'),
    array ('icon'=>'twitter-2', 'site'=>'twitter.com' , 'blurb'=>'Twitter'),
    array ('icon'=>'viddler', 'site'=>'www.viddler' , 'blurb'=>'viddler: Professional and personal video platform'),
    array ('icon'=>'vimeo', 'site'=>'vimeo.com' , 'blurb'=>'Vimeo: Video Sharing'),
    array ('icon'=>'wordpress-2', 'site'=>'www.wordpress.org' , 'blurb'=>'WordPress: blogging'),
    array ('icon'=>'xing', 'site'=>'www.xing.com' , 'blurb'=>'XING: Professional Business Network'),
    array ('icon'=>'yahoo', 'site'=>'yahoo.com' , 'blurb'=>'Yahoo: Portal'),
    array ('icon'=>'yelp', 'site'=>'www.yelp.com' , 'blurb'=>'Yelp: User reviews of restaurants and services'),
    array ('icon'=>'youtube', 'site'=>'youtube.com' , 'blurb'=>'YouTube: video sharing'),
    array ('icon'=>'video', 'site'=>'#Enter your own video link' , 'blurb'=>'Watch our video'),
    array ('icon'=>'_custom1', 'site'=>'#Enter your own link' , 'blurb'=>'Description'),
    array ('icon'=>'_custom2', 'site'=>'#Enter your own link' , 'blurb'=>'Description'),
    array ('icon'=>'_custom3', 'site'=>'#Enter your own link' , 'blurb'=>'Description'),
    array ('icon'=>'_custom4', 'site'=>'#Enter your own link' , 'blurb'=>'Description'),
    array ('icon'=>'_custom5', 'site'=>'#Enter your own link' , 'blurb'=>'Description'),
    array ('icon'=>'_custom6', 'site'=>'#Enter your own link' , 'blurb'=>'Description'),
    array ('icon'=>'_custom7', 'site'=>'#Enter your own link' , 'blurb'=>'Description'),
    array ('icon'=>'_custom8', 'site'=>'#Enter your own link' , 'blurb'=>'Description')

);

function weaveriip_has_socialbuttons() { return true;}

class weaveriip_Widget_Social extends WP_Widget {

	function weaveriip_Widget_Social() {
		$widget_ops = array( 'classname'=>'weaveriip_social',
				    'description' => __('Display Social Buttons as set in Weaver II Pro Social Shortcode Settings.', 'weaver-ii'/*a*/ ));
		parent::WP_Widget( 'weaveriip_social', __('Weaver II Pro Social Buttons', 'weaver-ii'/*a*/ ), $widget_ops );
	}

	function widget($args, $instance) {
		// Get menu

		$instance['title'] = apply_filters('widget_title', $instance['title'], $instance, $this->id_base);

		echo $args['before_widget'];

		if ( !empty($instance['title']) )
			echo $args['before_title'] . $instance['title'] . $args['after_title'];

		echo weaveriip_social_generate_code(32);

		echo $args['after_widget'];
	}

	function update( $new_instance, $old_instance ) {
		$instance['title'] = strip_tags( stripslashes($new_instance['title']) );
		return $instance;
	}

	function form( $instance ) {
		$title = isset( $instance['title'] ) ? $instance['title'] : '';
?>
		<p>
			<label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:','weaver-ii') ?></label>
			<input type="text" class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" value="<?php echo weaverii_esc_textarea($title); ?>" />
		</p>
		<p><em>Select Social Buttons to display from the Weaver II Pro Shortcodes menu. You can style with '.weaver-social'.</em>
		</p>
<?php
	}
}

function weaveriip_social_shortcode($args = '') {
    // [weaver_extra_menu menu='custom-menu-name' style='style-name']
    extract(shortcode_atts(array(
       'height' => '24',      // default height for menu bar use
       'number' => '1000'	// only show first number buttons
    ), $args));

    return weaveriip_social_generate_code($height,$number,false);
}

function weaveriip_save_social() {
    global $weaveriip_social_services;

    if (!weaverii_pro_isset('social'))
       weaveriip_init_social();

    if (isset($_POST['wvp_add_social_to_menu'])) weaverii_pro_setopt('wvp_add_social_to_menu', weaveriip_default_int($_POST['wvp_add_social_to_menu'],1,34,''));

    $soc = weaverii_pro_getopt('social');

    foreach ($weaveriip_social_services as $service) {
	$id = $service['icon'];

	if (isset($_POST[$id.'_use']))
           $soc[$id.'_use'] = 'checked';
	else
           $soc[$id.'_use'] = false;

	if (isset($_POST[$id.'_stay']))
           $soc[$id.'_stay'] = 'checked';
	else
           $soc[$id.'_stay'] = false;

	if (isset($_POST[$id.'_order']))
	      $soc[$id.'_order'] = weaveriip_default_int($_POST[$id.'_order'], 0, 10000, '');
	else
	      $soc[$id.'_order'] = '';

	if (isset($_POST[$id.'_hover']) && $_POST[$id.'_hover'] != '')
	      $soc[$id.'_hover'] = weaverii_filter_textarea($_POST[$id . '_hover']);
	else
	      $soc[$id.'_hover'] = $service['blurb'];

	if (isset($_POST[$id.'_url']))
	      $soc[$id.'_url'] = weaverii_filter_textarea($_POST[$id . '_url']);
	else
	      $soc[$id.'_url'] = '';

	if (isset($_POST[$id.'_custom']))
	      $soc[$id.'_custom'] = weaverii_filter_textarea($_POST[$id . '_custom']);
	else
	      $soc[$id.'_custom'] = '';
    }
    weaverii_pro_setopt('social', $soc);
    weaverii_pro_update_options('save_social');

}

function weaveriip_init_social() {
    // social opts are kept in an array saved in weaveriip_plus:['social']
    global $weaveriip_social_services;

    if (!weaverii_pro_isset('social'))
       $soc = array();
    else
       $soc = weaverii_pro_getopt('social');

    foreach ($weaveriip_social_services as $service) {
       $id = $service['icon'];
       if (!isset($soc[$id.'_use'])) {
	      $soc[$id.'_use'] = false;
       }
       if (!isset($soc[$id.'_order'])) {
	      $soc[$id.'_order'] = '';
       }
       if (!isset($soc[$id.'_hover'])) {
	      $soc[$id.'_hover'] = $service['blurb'];
       }
       if (!isset($soc[$id.'_url'])) {
	      $soc[$id.'_url'] = '';
       }
       if (!isset($soc[$id.'_stay'])) {
	      $soc[$id.'_stay'] = false;
       }
       if (!isset($soc[$id.'_custom'])) {
	      $soc[$id.'_custom'] = '';
       }
    }
    weaverii_pro_setopt('social', $soc);
    weaverii_pro_update_options('init_social');
}

function weaveriip_social_generate_code($height=24,$number=1000,$is_widget=true) {
    global $weaveriip_social_services;

    if (!weaverii_pro_isset('social'))
       weaveriip_init_social();

    $soc = weaverii_pro_getopt('social');

    $out = '';

    // need to sort the buttons according to the order field. This code may not be the best way to do this,
    // but it was easier that figuring sorting the array of services.
    $sorted = array();
    $active_services = array();
    foreach ($weaveriip_social_services as $service) {	// find all active buttons
       $id = $service['icon'];
       if (!isset($soc[$id.'_use']) || !$soc[$id.'_use']) {	// not set to use
	      continue;
       }
       $order = $soc[$id.'_order'];
       if ($order == '') $order = 100000;
       $sorted[$id] = $order;
       array_push($active_services,$service);	// order doesn't matter here, so just push
     }
    asort($sorted);	// sort the list of service names

    $sorted_ids = array_keys($sorted);	// get the keys into an array - will be a sorted list of services

    $displayed = 0;

    $rm = ($is_widget) ? '6' : '0';

    $out .= '<span class="weaver-social" style="padding:0 !important; margin:0; text-align:left;">';

    foreach($sorted_ids as $use_id) {
       foreach ($active_services as $service) {	// find the active service that matches the next sorted id
           $id = $service['icon'];
           if ($id != $use_id)
	      continue;
           $title = $soc[$id.'_hover'];		// $service['blurb'];
           $url = $soc[$id.'_url'];
	   $custom = isset($soc[$id . '_custom']) ? $soc[$id . '_custom'] : '' ;
	   if ($custom != '')
	       $imgsrc = $custom;
	    else
		$imgsrc = weaverii_relative_url('includes/pro/social/1/' . $id . '.png');
	    $target = '_blank';
	    if (isset($soc[$id.'_stay']) && $soc[$id.'_stay']) $target = '_self';


            $out .= '<a style="padding:0;margin:0;" href="' . $url . '" target="' . $target . '" title="' . $title . '">'
	      . '<img style="display:inline-block;margin:0;margin-right:' . $rm . 'px;padding:0;height:auto; width:'.$height.'px !important;"  src="' . $imgsrc . '"  height="' . $height . '" width="' . $height . '" title="'. $title . '" /></a>' . "\n";

	   if (++$displayed >= $number) {
	      $out .= '</span>' . "\n";
	       return $out;			// bail when display number reached
	   }
           break;
       }
    } // end foreach

    $out .= '</span>' . "\n";
    if ($is_widget)
       $out .= '<div style="clear:both;"></div>' . "\n";
    return $out;
}

add_shortcode('weaver_social','weaveriip_social_shortcode');
/* ============================ weaveriip_social =============================== */

add_action('widgets_init', "weaveriip_load_social_widget");
function weaveriip_load_social_widget() {
    register_widget("weaveriip_Widget_Social");
}
?>
