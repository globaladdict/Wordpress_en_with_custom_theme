<?php
/*
Weaver II Pro Shortcodes - Version 1.0

EXTRAMENU
ADMIN

This code is Copyright 2011 by Bruce Wampler, all rights reserved.
This code is licensed under the terms of the accompanying license file: license.html.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
*/
function weaveriip_extra_menu_admin() {
?>
<p class='wvr-option-section'>Extra Menu Shortcode - [weaver_extra_menu] + Vertical Menu Widget<?php weaveriip_help_link('pro-help.html#extra_menus','Extra Menus help'); ?></p>

<p><code>[weaver_extra_menu wrap='wrap_class' menu='menuname' style='stylename' width='width_override' css='extra_css']</code></p>

<p>The <code>[weaver_extra_menu]</code> short code allows you to display a menu you've defined in the
<em>Appearance&rarr;Menus</em> panel almost any place in your site: in a sidebar text widget, on a post or page,
or in one of the <em>HTML Insertion</em> areas found on the <em>Weaver Admin&rarr;Advanced Options</em> tab.
Simply insert the shortcode with at least a menu name wherever you want the menu to appear.</p>

<ol>
    <li><strong>menu=</strong> - The 'menu' parameter allows you to specify which custom menu to display. The name of
    the menu can be a 'Menu Name' used in the tabbed menu definition area, or the slug name of one of the 'Theme Locations'
    box (a slug is all lower case with no spaces of the Navigation name). If you specify '0', then the default
    menu will be used.
    </li>
    <li><strong>wrap=</strong> - This is the name of a class to wrap your menu. The default is 'extra_menu'. This is
    useful for a couple of things. First, you can specify <code>#access</code> to add the bottom rounded corners (if set)
    of the Primary menu bar. Using <code>#access2</code> will get the top rounded corners of the upper Secondary menu bar.
    You could also specify your own name, and create additional rules to change attributes of the main <code>.menu_bar</code>
    class. For example, specifying <code>wrap='my_menu'</code> and adding a custom CSS
    rule like <code>.my_menu .menu_bar {background-color:transparent;}</code> to the <em>Custom CSS Rules</em> section would
    replace whatever the default menu bar background color was with transparent.
    </li>
    <li><strong>style=</strong> - The 'style' parameter is used to specify how the menu will look. You can use one of
    several pre-defined styles, or add your own custom menu styling in the <em>&lt;HEAD&gt; Section</em> on the
    <em>Advanced Options</em> tab. The pre-defined styles include:
    <ol>
	<li><code>menu_bar</code> - This is the style class name of the standard bottom and top menu bars.
	For example, using <code>[weaver_extra_menu menu='mymenu' style='menu_bar']</code> in the <em>Pre-Footer Code</em> area will
	display custom menu 'mymenu' right above the footer using the same styling as the top menu bar.
	</li>
	<li><code>menu-vertical</code> - Displays a simple Vertical Rollover menu in a width that matches the width of
	the primary sidebar. It will use the same colors as you've defined for your main menu bars. Simply add
	<code>[weaver_extra_menu menu='mymenu' style='menu-vertical']</code> to a standard text widget placed
	on a sidebar widget area.
	</li>
	<li><code>menu-horizontal</code> - Displays a very simple horizontal one-level menu. The links are styled
	using the standard link colors and styles of the section the menu is placed. This style is useful for placing
	a simple link menu right below your main menu, for example.
	</li>
	<li><code>menu-vertical-default</code> - Displays a simple vertical menu using standard list and default link
	formatting.
	</li>
    </ol>
    </li>
    <li><strong>width=</strong> - Allows you to specify the width of the outer box surrounding the menu. You could use
    it to make a narrower <code>.menu_bar</code> styled menu, for example. You can use px or % to specify the width.
    </li>
    <li><strong>css=</strong> - You can specify any CSS styling for the outer &lt;div&gt; that wraps the menu. This will
    be placed in a <code>style="css..."</code> parameter.
    </li>
    <li><strong>border_color=</strong> - You can add a border to your extra menu by specifying a color.
    </li>
</ol>
</p>
<p><strong>Weaver II Pro Vertical Menu Widget</strong> - This widget will display a simple rollover vertical menu in
the widget. This is essentially the same vertical menu you can get using the shortcode with the .menu-vertical style.
The widget lets you select the menu from the widget control box. <em>Note - Custom Sidebars:</em> If you have
customized your sidebar with extra padding or borders (e.g., the Kitchen Sink sub-theme), the default vertical styling
may not have the correct width. You can fix this by adding <code>.menu-vertical {width:254px !important;}</code> to
the <em>&lt;HEAD> Section</em> in Advanced Options, and adjusting the '254px' to fit.

</p>
<?php
}

?>
