=== Weaver II Theme ===

Contributors: wpweaver
Author URI: http://weavertheme.com/about
Theme URI: http://weavertheme.com
Tags: custom-header, custom-colors, custom-background, custom-menu, theme-options, left-sidebar, right-sidebar,
fixed-width, three-columns, two-columns, black, blue, brown, green, orange, red, tan, dark, white, light,
translation-ready, rtl-language-support, editor-style
Requires at least: 3.2
Tested up to: 3.3
Stable tag: 1.0

== Description ==

Weaver II is an advanced Theme platform that supports extensive customization by the user,
as well as automatic support for mobile devices.

== Licenses ==

* Weaver II is licensed under the terms of the GNU GENERAL PUBLIC LICENSE, Version 2,
June 1991. (GPL) The full text of the license is in the license.txt file.
* Weaver II has been derived from the Word Press Twenty Eleven Theme, also licensed
under GPL V2. The source code for Twenty Eleven is available at
http://wordpress.org/extend/themes/twentyeleven
* All images included with Weaver II are either original works of the author which
have been placed into the public domain, or have been derived from other public domain sources,
and thus need no license. (This does not include the images provided with any of the
below listed scripts and libraries. Those images are covered by their respective licenses.)
* Weaver II also includes several scripts and libraries that are covered under the terms
of their own licenses in the listed files in the Weaver II theme distribution:
** Yetii - Yet (E)Another Tab Interface Implementation - license in /js/yetii/yetii.js (BSD)
** Accordion, jQuery Plugin - license in /js/accordion/LICENSE (New BSD)
** jscolor, JavaScript Color Picker - license in /js/jscolor/jscolor.js (GLGPL)
** CSS3 rendering for IE - license in /js/PIE/PIE_uncompressed.js (GPL V2)
** Superfish - jQuery menu widget - license in /js/superfish/superfish.js (MIT/GPL)
** html5 IE lib - license in /js/htm5.js (MIT)
** theme scripts - original to this theme, covered by GPL

== Changelog ==

This change log was started beginning with Version 1.0

= Changes Version 1.0 =
This theme, Weaver II, is a brand new theme. It started with Twenty Eleven as the base theme file architecture,
but extensively modified those files. It also incorporated many files and features from the original Weaver theme
by the same author.

= Changes Version 1.0.1 =
* Added titlelist to [weaver_show_posts]
* Added default_hidden_meta_boxes filter to enable Custom Fields and Discussion in post/page editor
* Added doc note about custom CSS precedence
* Added rounded corners for content
* Fixed Custom Excerpt Continue Reading issue
* Fixed TEMPLATEPATH usage
* Fixed title generation code - trim()
* Fixed overflow:hidden on multi-column
* Fixed links bold,italic, and underline precedence issues
* Fixed hide sidebars on single per-post option
* Fixed wrong help file links in some options

= Changes Version 1.0.2 =
* Fixed menu current page color styling (!important)
* Fixed CSS Help link
* Fixed shortcode list on shortcode admin page
* Fixed some minor HTML generation errors
* Fixed .weaver-mobile #branding/#colophon width
* Added custom post type per-post support
* Added Facebook preferred image
* Added [span]
* Added [weaver_youtube] and [weaver_vimeo]
* Added support for 'smalltablet' - phone, small tablets, tablets, standard browsing
* Added detection of major incompatible cache plugins

= Changes Version 1.0.3 =
* Fixed allow attachment comments
* Fixed .widget-area lists
* Fixed @media sidebar rules

= Changes Version 1.0.4 =
* Fixed SIE user agent - removed

= Changes Version 1.0.5 ==
* Added doc note and follow SEO option for Facebook image
* Added full-size, centered BG image to Pro
* Added W3TC support
* Enhanced [weaver_youtube]
* Fixed og:url to get_home_url()
* Fixed [weaver_show_posts] title styling
* Fixed .widget-area list bug with vertical menus

= Changes Version 1.0.6 ==
* Added .post-even and .post-odd to post <article> div
* Added Mobile support for Opera Mini (non-dropdown menu version)
* Added Pre-Wrapper HTML area
* Added custom mobile toggle HTML
* Added shortcode processing to manual post excerpts
* Added Mobile Menu alternative
* Added percent size and center to video shortcodes
* Added post info line custom template
* Added Demo Child theme directory
* Fixed boldface on some admin titles
* Fixed no title displayed when no content on Page with Posts
* Fixed some incorrect /spans
* Fixed (really) [weaver_show_posts] title styling
* Fixed the_title('') for SEO
* Fixed display of Title/Description over header image on tablets
* Fixed alternate header for mobile view
* Dropped SF menus for vertical popout - didn't work so don't use
* Dropped some input#s rules from style-minimal.css
* Enhanced debug/trace display
* Changed #site-info width to 100% if Hide Powered By
* Changed widths for next/prev posts when using paged Nav
* Changed comment paragraph spacing
* Changed color flow from padding/-margin trick to equalheights.js
* Moved output of CSS+ rules to end of generated CSS

== Changes Version 1.0.7 ==
* Added Tablet Alternate Header Image (Pro)
* Enhanced Mobile Simultor - added small tablet and tablet sims
* Enhanced [weaver_iframe] - added style, percent
* Enhanced video shortcodes - added ratio; removed w,h; changed YT relative to rel;
  sizing now via JS using ratio to set height
* Updated [weaver_hide/show_if_mobile] docs to include 'any'
* Added #header_widget_table {width:100%;} for header widget area
* Fine tuned some rules in style.css, style-minimal.css, and order of CSS+ rules in css generation.
  Includes a change to the #branding img rule that might affect spacing in custom header rules
* Fixed CSS+ static page title generation
* Fixed problem with menu class display caused by deprecated PHP

== Changes Version 1.0.8 ==
* Added clear:both after mobile/full toggle images
* Added word-wrap:break-word to default styling
* Fixed 'right-margin' css error for left double sidebar
* Fixed Post-Right Sidebar title to Pre-Right Sidbar. Description was correct.
* Fixed 100% width generated when only copyright used.
* Fixed show/hide that 1.0.7 broke.

== Changes Version 1.0.9 ==
* Added Slide Open Menu for Mobile Phone view - made default menu for phones
* Added auto-scaling for iOS devices (<meta viewport>)
* Added [weaver_show/hide_if_logged_in] shortcode
* Added Pre-Header and Post-Footer HTML Insert area back into basic version
* Added %day%, %month%, %year% to post info template parameters (Pro only)
* Added extra link to Pro Shortcode page from Pro tab (Pro only)
* Added "Hide Author for Single Author Site" (changes default behavior)
* Removed flat mobile menu for Opera Mini (use slide open menu now)
* Fixed missing bold/italic/CSS+ styling for vertical menus
* Fixed Page with Posts current page in vertical menus issue
* Fixed [div] and [span] to use do_shortcode() for text
* Fixed version update link
* Fixed color flow script to load vs. ready so images are counted
* Fixed .entry-content total css issue (Pro)
* Refined list styling
b
== Changes Version 1.0.10 ==
* Added Hide on Primary Menu if logged in or not Per Page
* Fixed Title Underline didn't apply on index.php blog
* Fixed [ weaver_feed ] title bottom margin
* Fixed #branding img style

== Changes Version 1.0.11 ==
* Added Custom Post Type to Page with Posts and [weaver_show_posts]
* Added Custom CSS replacment file
* Tweaked #nav-above #nav-below: display:none;margin:0;
* Fixed hide tool tips (Pro)
* Fixed postpostcontent to use .inject_postpostcontent instead of #
* Fixed alternate mobile theme bug when no theme saved (Pro)

== Changes Version 1.0.12 ==
* Added Slide Open Menu option for standard view sites
* Added Check Theme for Possible Problems in Weaver Admin
* Added Clear Messages button in Weaver Admin
* Added link to help file for info on disabling comments
* Fixed menu bar left indent so didn't also incorrectly indent sub-menu
* Fixed some avatar and image size problems with IE8, avatar placement on IE9,
  Moved post-avatar styling from inline to style.css
* Tweaked move title/desription margins, font size (style-minimal.css)

== Changes Version 1.0.13 ==
* Beginning with the version, odd sub versions will represent development version.
  Release versions will be even.

== Changes Version 1.0.14 ==
* Some internal code changes needed for future Weaver II Theme Switcher plugin
* Fixed #content img style (incorrect fix to avatar code in 1.0.12)

== Changes Version 1.0.16 ==
* Added hide secondary menu on Phone view
* Added .bcur_page class for Breadcrumb current page (instead of hardwired strong)
* Added hide large tablet for gadgets (Pro)
* Fixed #site-ig-wrap (added clear:both) so long copyrights work correctly
* Fixed styling for Social Buttons (Pro)

== Changes Version 1.0.18 ==
* Added clear:left to #branding img (to clear #site-title)
* Fixed Social Buttons on Menu Bar for IE8 (Pro)

== Changes Version 1.0.20 ==
* Added warning to Header Width option description. Will ignore if value same as theme width.
* Added note that <HEAD> section code does not support shortcodes
* Fixed original Weaver to Weaver II conversion of top/bottom widget area color CSS
* Revised reademe.txt - added full license info, moved change log to reademe.txt

== Changes Version 1.0.22 ==
* Tweaked instructions for Save Alternate Mobile Theme
* Fixed Apple iOS icon setting
* Added IE8 #ie8 #content img max-width rule

== Changed Version 1.0.24 ==
* Fixed [gallery] images - centered now
* Fixed borders, captions for images from URL instead of Media Lib
* Fixed bug with hide sidebars on post single page view

== Changed Version 1.0.26 ==
* Added (Pro) tag to Pro-only options
* Added  &diams; tag to not-theme-related settings
* Added .entry-hdr to single post title
* Added new sidebar support for plugins that use sidebar.php
* Added < html id="ie9"> for IE9
* Fixed title color CSS rules generation problem
* Fixed 404 mobile view styling
* Fixed weaverii_continue_reading_link in child theme demo
* Fixed Add HTML to Menu Bar documentation bugs - location moved since Weaver 2.2
* Fixed print CSS issue for 2nd page
* Fixed weaverii_f_fail message display
* Fixed Page Nav (removed it) and page title links on Search results page
* Fine tuned documentation wording in several places
* Revised license text for images
