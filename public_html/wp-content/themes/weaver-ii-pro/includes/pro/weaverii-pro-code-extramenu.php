<?php
/*
Weaver II Pro Extra Menus - Version 1.0

EXTRAMENU
CODE

This code is Copyright 2011 by Bruce Wampler, all rights reserved.
This code is licensed under the terms of the accompanying license file: license.html.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
*/
/* ============================ weaveriip_extra_menu =============================== */

function weaveriip_has_extra_menu() { return true; }

    class weaveriip_Widget_Vertical_Menu extends WP_Widget {

	function weaveriip_Widget_Vertical_Menu() {
	    $widget_ops = array( 'classname'=>'weaveriip_vertical_menu',
		'description' => __('Use this widget to add one of your custom menus as a widget.', 'weaver-ii'/*a*/ )
		. __(' Use Weaver Menu Bar settings to display simple Rollover vertical menu.', 'weaver-ii'/*a*/ ));
	    parent::WP_Widget( 'weaveriip_nav_menu', __('Weaver II Pro Vertical Menu', 'weaver-ii'/*a*/ ), $widget_ops );
	}

	function widget($args, $instance) {
	    // Get menu
	    $nav_menu = wp_get_nav_menu_object( $instance['nav_menu'] );

	    $instance['title'] = apply_filters('widget_title', $instance['title'], $instance, $this->id_base);

	    $type = $instance['menu_style'];
	    if (!$type) $type='vertical';
	    $wrap = 'menu_widget';
	    $class = 'menu_bar';	// most will use menubar as the base style
	    switch ($type) {
		case 'vertical':	// simple, no popoup vertical menu
		    $wrap = 'menu_widget';
		    $class = 'menu-vertical';
		    break;
		case 'left':		// pop-out to the left side
		    $wrap = 'menu_pop_left';
		    break;
		case 'right':		// pop-out to the right side
		    $wrap = 'menu_pop_right';
		    break;
		default:
		    break;
	    }


	    echo $args['before_widget'];

	    if ( !empty($instance['title']) )
		echo $args['before_title'] . $instance['title'] . $args['after_title'];

	    echo weaverii_extra_menu_generate_code($nav_menu, $wrap, $class );

	    echo $args['after_widget'];
    }

    function update( $new_instance, $old_instance ) {
	$instance['title'] = strip_tags( stripslashes($new_instance['title']) );
	$instance['nav_menu'] = (int) $new_instance['nav_menu'];
	$instance['menu_style'] = $new_instance['menu_style'];
	return $instance;
    }

    function form( $instance ) {
	$title = isset( $instance['title'] ) ? $instance['title'] : '';
	$nav_menu = isset( $instance['nav_menu'] ) ? $instance['nav_menu'] : '';
	$menu_style = isset( $instance['menu_style'] ) ? $instance['menu_style'] : '';

	// Get menus
	$menus = get_terms( 'nav_menu', array( 'hide_empty' => false ) );
	$styles = array ('Vertical' => 'vertical', 'Pop Out to Left' => 'left',
	    'Pop Out to Right' => 'right', 'Horizontal' => 'horizontal');

	// If no menus exists, direct the user to go and create some.
	if ( !$menus ) {
	    echo '<p>'. sprintf( __('No menus have been created yet. <a href="%s">Create some</a>.'), admin_url('nav-menus.php') ) .'</p>';
	    return;
	}
?>
	<p>
	<label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:', 'weaver-ii'/*a*/ ) ?></label>
	<input type="text" class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" value="<?php echo weaverii_esc_textarea($title); ?>" />
	</p>
	<p>
	<label for="<?php echo $this->get_field_id('nav_menu'); ?>"><?php _e('Select Menu:', 'weaver-ii'/*a*/ ); ?></label>
	<select id="<?php echo $this->get_field_id('nav_menu'); ?>" name="<?php echo $this->get_field_name('nav_menu'); ?>">
<?php
	    foreach ( $menus as $menu ) {
		$selected = $nav_menu == $menu->term_id ? ' selected="selected"' : '';
		echo '<option'. $selected .' value="'. $menu->term_id .'">'. $menu->name .'</option>';
	    }
?>
	</select>
	</p>
	<p>
	<label for="<?php echo $this->get_field_id('menu_style'); ?>"><?php _e('Select Menu Style:', 'weaver-ii'/*a*/ ); ?></label>
	<select id="<?php echo $this->get_field_id('menu_style'); ?>" name="<?php echo $this->get_field_name('menu_style'); ?>">
<?php
	    foreach ( $styles as $style => $val) {
		$selected = $menu_style == $val ? ' selected="selected"' : '';
		echo '<option'. $selected .' value="' . $val .'">'. $style .'</option>';
	    }
?>
	</select>
	</p>
<?php
       }
}

function weaveriip_extra_menu_shortcode($args = '') {
    // [weaver_extra_menu menu='custom-menu-name' style='style-name']
    extract(shortcode_atts(array(
	'menu' => 'primary',      // default menu name
        'style' => 'menu-vertical', // default menu style id (should be class)
	'width' => '',
        'border_color' => '',
        'css' => '',
	'wrap' => 'extra_menu'
    ), $args));

    return weaverii_extra_menu_generate_code($menu,$wrap , $style, $border_color,$css,$width);
}

function weaveriip_extra_menu_output_style($sout) {
    // CSS for weaveriip_extra_menu

    $menu = "/* Weaver II Pro: Simple Horizontal One Level Menu  */
.menu-horizontal {clear:both;background:transparent;margin:0;padding:0;}
.menu-horizontal ul {margin:0;padding:2px 2px 2px 20px;}
.menu-horizontal li {display:inline; list-style-type:none;list-style-image:none !important;padding-right:15px;}
/* Weaver II Pro: Default List Vertical Menu */
.menu-vertical-default {clear:both; background:transparent;}\n";

weaverii_f_write($sout,$menu);

}

add_shortcode('weaver_extra_menu','weaveriip_extra_menu_shortcode');
add_action('widgets_init', "weaveriip_load_menu_widget");
function weaveriip_load_menu_widget() {
	register_widget("weaveriip_Widget_Vertical_Menu");
}
?>
