<?php
/* Weaver II
  bottom menu
*/

if (!weaverii_getopt('wii_hide_menu')
    && !weaverii_is_checked_page_opt('ttw-hide-menus')
    && !(weaverii_getopt('wii_mobile_hide_menu') && weaverii_use_mobile('mobile'))) {
    if (weaverii_getopt('wii_move_menu')) { 	/* ttw - move menu */
	if (!weaverii_mobile_replace_menu('main')) {
?>
		<div id="nav-top-menu"><nav id="access" class="<?php echo weaverii_mobile_nav_class(); ?>" role="navigation">
		<div class="skip-link"><a class="assistive-text" href="#content" title="<?php esc_attr_e( 'Skip to primary content','weaver-ii'); ?>"><?php _e( 'Skip to primary content','weaver-ii'); ?></a></div>
			<div class="skip-link"><a class="assistive-text" href="#primary" title="<?php esc_attr_e( 'Skip to secondary content','weaver-ii'); ?>"><?php _e( 'Skip to secondary content','weaver-ii'); ?></a></div>


<?php           /* add html to menu left */
		    $add_html = weaverii_getopt('wii_menu_addhtml-left');
		    if (!empty($add_html)) {
		        echo('<div class="menu-add-left">');
			echo(do_shortcode($add_html));
			echo('</div>');
		    }

		    $nav_menu = (weaverii_use_mobile('mobile') && has_nav_menu('mobile_menu')) ? 'mobile_menu' : 'primary';

		    if (weaverii_getopt('wii_use_superfish') || weaverii_mobile_usesf())
				wp_nav_menu( array( 'container_class' => 'menu', 'theme_location' => $nav_menu, 'menu_class' => 'sf-menu', 'fallback_cb' => 'weaverii_page_menu' ) );
			else
				wp_nav_menu( array( 'container_class' => 'menu', 'theme_location' => $nav_menu ) );

		    /* add html/search to menu */
		    $add_div = true;
		    $add_enddiv = false;
		    $add_html = weaverii_getopt('wii_menu_addhtml');

		    if (!empty($add_html)) {
		        echo('<div class="menu-add">'); $add_div = false;
			echo(do_shortcode($add_html));
			$add_enddiv = true;
		    }

                    if (weaverii_pro_getopt('wvp_add_social_to_menu') > 0) {
                        if ($add_div) echo('<div class="menu-add">'); $add_div = false;
                        $val = weaverii_pro_getopt('wvp_add_social_to_menu');
                        $width = $val * 28;
                        echo do_shortcode(sprintf('<span style="width:%spx; padding-right:4px;display:inline-block;">[weaver_social number=%d]</span>',
                                $width,$val));
                        $add_enddiv = true;
                    }

		    if (weaverii_getopt('wii_menu_addsearch')) {
			if ($add_div) echo('<div class="menu-add">'); $add_div = false;
                        if (function_exists('weaverii_plus_search_form')) {
                           echo '<span class="menu-add-search">';
                            echo weaverii_plus_search_form('',120);
                            echo '</span>';
                        } else {
                            echo '<span class="menu-add-search">';
                            get_search_form();
                            echo '</span>';
                        }
			$add_enddiv = true;
		    }
		    if (weaverii_getopt('wii_menu_addlogin')) {
			if ($add_div) echo('<div class="menu-add">'); $add_div = false;
			wp_loginout();
			$add_enddiv = true;
		    }

		    if ($add_enddiv) echo('</div>');
		    ?>
		</nav></div><!-- #access -->
	    <?php
	}
    } else { /* ttw - move menu */
        if (has_nav_menu('secondary')) {
	    if (!weaverii_mobile_replace_menu('secondary')) {
?>
		<div id="nav-top-menu"><nav id="access2" class="menu_bar" role="navigation">
		<?php
		if (weaverii_getopt('wii_use_superfish') || weaverii_mobile_usesf())
		    wp_nav_menu( array( 'container_class' => 'menu', 'theme_location' => 'secondary', 'fallback_cb' => '', 'menu_class' => 'sf-menu' ) );
		else
		    wp_nav_menu( array( 'container_class' => 'menu', 'theme_location' => 'secondary', 'fallback_cb' => '' ) );
		?>
		</nav></div><!-- #access2 -->
	    <?php
	    }
        }
    }
} /* end wii_hide-menus */
?>
