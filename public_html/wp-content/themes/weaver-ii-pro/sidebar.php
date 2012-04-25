<?php
/**
 * The Sidebar containing the main widget area.
 * Weaver II does not use this itself, but this is provided for reasonable compatibility with some plugins.
 *
 * @package WordPress
 * @subpackage Weaver II
 * @since Weaver II 1.0
 */
?>
<?php
    weaverii_trace_sidebar(__FILE__);

      if ( is_active_sidebar('per-page-plugin_replacement')) { ?>
	<div id="sidebar_plugin" class="widget-area" role="complementary">
<?php	dynamic_sidebar( 'per-page-plugin_replacement' ); ?>

	</div><!-- #sidebar_plugin.widget-area -->
<?php
    }
?>
	<div style="clear:both;">
<?php
?>
