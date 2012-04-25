<?php
/*
Weaver II Pro Buttons Shortcode/Widget - Version 1.0

CODE

This code is Copyright 2011 by Bruce Wampler, all rights reserved.
This code is licensed under the terms of the accompanying license file: license.html.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
*/
/* ============================ weaveriip_buttons =============================== */
function weaveriip_has_linkbuttons() {return true;}

define('WEAVERIIP_NUM_BUTTONS',8);

 class weaveriip_Widget_Buttons extends WP_Widget {

   function weaveriip_Widget_Buttons() {
      $widget_ops = array( 'classname'=>'weaveriip_buttons',
	 'description' => __('Display Link Buttons as set in Weaver II Pro Link Buttons Shortcode Settings.', 'weaver-ii'/*a*/ ));
      parent::WP_Widget( 'weaveriip_buttons', __('Weaver II Pro Link Buttons', 'weaver-ii'/*a*/ ), $widget_ops );
   }

   function widget($args, $instance) {
   // Get menu

      $instance['title'] = apply_filters('widget_title', $instance['title'], $instance, $this->id_base);
      $start = $instance['start'];
      $end = $instance['end'];
      $list = $instance['list'];

      echo $args['before_widget'];

      if ( !empty($instance['title']) )
	 echo $args['before_title'] . $instance['title'] . $args['after_title'];

      echo weaveriip_buttons_generate_code($start,$end,$list);

      echo $args['after_widget'];
   }

   function update( $new_instance, $old_instance ) {
      $instance['title'] = strip_tags( stripslashes($new_instance['title']) );
      $instance['start'] = (int) $new_instance['start'];
      if ($instance['start'] < 1 ||  $instance['start'] > 64) $instance['start'] = 1;
      $instance['end'] = (int) $new_instance['end'];
      if ($instance['end'] < 1 ||  $instance['end'] > 64) $instance['start'] = 64;
      $instance['list'] = trim($new_instance['list']);

      return $instance;
   }

   function form( $instance ) {
      $title = isset( $instance['title'] ) ? $instance['title'] : '';
      $start = isset($instance['start']) ? absint($instance['start']) : 1;
      $end = isset($instance['end']) ? absint($instance['end']) : 64;
      $list = isset( $instance['list'] ) ? $instance['list'] : '';

?>
	      <p>
	      <label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:','weaver-ii') ?></label>
	      <input type="text" class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" value="<?php echo weaverii_esc_textarea($title); ?>" />
	      </p>
	      <p><label for="<?php echo $this->get_field_id('start'); ?>">Start number:</label>
	      <input id="<?php echo $this->get_field_id('start'); ?>" name="<?php echo $this->get_field_name('start'); ?>" type="text" value="<?php echo weaverii_esc_textarea($start); ?>" size="3" />
	      </p>
	      <p><label for="<?php echo $this->get_field_id('end'); ?>">End number:</label>
	      <input id="<?php echo $this->get_field_id('end'); ?>" name="<?php echo $this->get_field_name('end'); ?>" type="text" value="<?php echo weaverii_esc_textarea($end); ?>" size="3" />
	      </p>
	      <p style="text-align:center;"><em>- or -</em></p>
	      <p><label for="<?php echo $this->get_field_id('list'); ?>">Comma separated list of numbers:</label>
	      <input id="<?php echo $this->get_field_id('list'); ?>" name="<?php echo $this->get_field_name('list'); ?>" type="text" value="<?php echo weaverii_esc_textarea($list); ?>" size="24" />
	      </p>

	      <p><em>Select Buttons to display from the Weaver II Pro Shortcodes menu. You can style with '.weaver-buttons'.</em>
	      </p>
<?php
   }
}

function weaveriip_save_buttons() {

    if (!weaverii_pro_isset('buttons')) {
       weaveriip_init_buttons();
    }

    $buttons = weaverii_pro_getopt('buttons');

    if (isset($_POST['maxbuttons']) && $_POST['maxbuttons'] != $buttons['maxbuttons']) {
       $buttons['maxbuttons'] = weaveriip_default_int($_POST['maxbuttons'], 1, 64, 8);
       weaverii_pro_setopt('buttons', $buttons);
       weaverii_pro_update_options('link buttons');	// kind of convoluted when changing value...
       weaveriip_init_buttons();
       $buttons = weaverii_pro_getopt('buttons');
    }
    $maxbuttons = $buttons['maxbuttons'];

    for ($i = 0 ; $i < $maxbuttons ; $i++) {
       $id = 'b'.$i;
       if (isset($_POST[$id.'_img_url'])) $buttons[$id.'_img_url'] = weaverii_filter_textarea($_POST[$id.'_img_url']);
       if (isset($_POST[$id.'_hover'])) $buttons[$id.'_hover'] = weaverii_filter_textarea($_POST[$id.'_hover']);
       if (isset($_POST[$id.'_link_url'])) $buttons[$id.'_link_url'] = weaverii_filter_textarea($_POST[$id.'_link_url']);
       if (isset($_POST[$id.'_blank'])) $buttons[$id.'_blank'] = 'checked';
       else $buttons[$id.'_blank'] = false;
    }
    weaverii_pro_setopt('buttons', $buttons);
    weaverii_pro_update_options('link buttons2');

}

function weaveriip_init_buttons() {
    // buttons opts are kept in an array saved in weaveriip_plus: ['buttons']

    if (!weaverii_pro_isset('buttons'))
       $buttons = array();
    else
       $buttons = weaverii_pro_getopt('buttons');

    if (!isset($buttons['maxbuttons'])) $buttons['maxbuttons'] = WEAVERIIP_NUM_BUTTONS;

    for ($i = 0 ; $i < $buttons['maxbuttons'] ; ++$i) {
       $id = 'b'.$i;
       if (!isset($buttons[$id.'_img_url'])) $buttons[$id.'_img_url'] = '';
       if (!isset($buttons[$id.'_hover'])) $buttons[$id.'_hover'] = '';
       if (!isset($buttons[$id.'_link_url'])) $buttons[$id.'_link_url'] = '';
       if (!isset($buttons[$id.'_blank'])) $buttons[$id.'_blank'] = false;
    }
    weaverii_pro_setopt('buttons', $buttons);
    weaverii_pro_update_options('link buttons3');
}

function weaveriip_buttons_shortcode($args = '') {
   // [weaver_extra_menu menu='custom-menu-name' style='style-name']
   extract(shortcode_atts(array(
      'start' => '1', 	// range or list of values
      'end' => '',
      'list' => ''
   ), $args));

   if ($end == '') {
      if (weaverii_pro_isset('buttons')) {
         $buttons = weaverii_pro_getopt('buttons');
	 if (isset($buttons['maxbuttons']))
	    $end = $buttons['maxbuttons'];
	 else
	    $end = weaveriip_WEAVERIIP_NUM_BUTTONS;
      }
   }
   $out = weaveriip_buttons_generate_code($start,$end,$list);
   return $out;
}

function weaveriip_buttons_generate_code($start=1, $end=64,$list='') {

   if (!weaverii_pro_isset('buttons')) return 'No buttons defined.';
   $buttons = weaverii_pro_getopt('buttons');
   $maxbuttons = $buttons['maxbuttons'];

   $out = '';

   if ($start < 1) $start = 1;			// stay sane
   if ($end > $maxbuttons) $end = $maxbuttons;
   $out .= '<div class="weaver-buttons">';
   if ($list != '') {	// list specified - it has priority
      $list_vals = explode(',',trim($list));
      foreach ($list_vals as $item) {
	 $out .= weaveriip_buttons_button($buttons,trim($item));
      }
   } else {	// start:end
      for ($i = $start ; $i <= $end ; $i++) {
	 $out .= weaveriip_buttons_button($buttons,$i);
      } // end for
   }

    $out .= '</div>' . "\n";

    return $out;
}

function weaveriip_buttons_button($buttons,$i) {
   // code for one button
   $out = '';
   $i--;		// users start at 1, we start at 0
   $id = 'b'.$i;
   $img_url = $buttons[$id.'_img_url'];

   if ($img_url == '')
      return $out;

   $title = $buttons[$id.'_hover'];
   $url = $buttons[$id.'_link_url'];
   if ($buttons[$id.'_blank']) $blank = ' target="_blank"';
   else $blank = '';


   if ($url != '')
      $out .= '<a href="' . $url . '" title="' . $title . '"' . $blank . '>';

   $out .= '<img src="' . $img_url . '" title="'. $title . '" style="border:0;padding-right:3px;padding-bottom:3px;z-index:20;" />';

   if ($url != '')
      $out .= '</a>';
   $out .= "\n";
   return $out;
}

add_shortcode('weaver_buttons','weaveriip_buttons_shortcode');
/* ============================ weaveriip_buttons =============================== */

add_action('widgets_init', "weaveriip_load_buttons_widget");
function weaveriip_load_buttons_widget() {
    register_widget("weaveriip_Widget_Buttons");
}
?>
