<?php
/*
Weaver II Pro Showfeed - Version 1.0
FEED
ADMIN+CODE

This code is Copyright 2011 by Bruce Wampler, all rights reserved.
This code is licensed under the terms of the accompanying license file: license.html.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
*/
function weaveriip_has_feed() {return true;}

function weaveriip_feed_admin() {
?>
<p class='wvr-option-section'>Show Feed - [weaver_feed] <?php weaveriip_help_link('pro-help.html#show_feed','Show Feed help'); ?></p>
<p><code>[weaver_feed feed='url' items=10 show_sitename=0 show_content=1 excerpt=0 trusted=0 title_style='']</code></p>

<p>The <code>[weaver_feed]</code> short code allows you to display an RSS or Atom feed from an external source.</p>

<p><strong>Shortcode usage:</strong> <br />
<code>[weaver_feed feed='url' items=10 show_sitename=0 show_content=1 excerpt=0 trusted=0 title_style='']</code>
<br />
<ol>
    <li><strong>feed='url'</strong> - The url of the external feed.
    </li>
    <li><strong>items=10</strong> - By default, [weaver_feed] will display up to 10 items from the feed. Many feeds
    won't have even 10 items. You can limit the number of items displayed by providing a value between 1 and 20.
    </li>
    <li><strong>show_sitename=0|1</strong> - If set to '1', the feed will include an RSS icon with a link to the site's
    RSS feed, as well as the site's feed name. The default is '0', don't show the site name.
    </li>
    <li><strong>show_content=0|1</strong> - By default, the summary content of the feed will be included (1). If you
    include <code>show_content=0</code>, the site content will not be displayed.
    </li>
    <li><strong>excerpt=0|1</strong> - By default, the full content of the feed will be displayed. This is usually
    short in feeds. If you want the feed's content to be forced to be short, use <code>excerpt=1></code> which will
    force an excerpt.
    </li>
    <li><strong>trusted=0|1</strong> - By default, [weaver_feed] won't trust external feeds - that means it will strip
    out any html from the feed content, and just show text. If you trust the feed, you can use <code>trusted=1</code>,
    and any HTML tags such as links will be retained.
    </li>
    <li><strong>title_style='inline-style-rules'</strong> - Allows you to change the styling of the post title.
    Don't include the 'style=' or wrapping quotation marks. Do include a ';' at the end of each rule. The output will look like
    <code>style="your-rules;"</code> - using double quotation marks.
    This is most likely useful to reduce the title size (e.g., <code>style='font-size=95%;'</code>)
    </li>
    </ol>
</p>

<?php
}

/* -------------- weaveriip_feed --------------- */
function weaveriip_feed_shortcode($args = '') {
    /* implement [weaver_feed feed='ur'] shortcode */

    extract(shortcode_atts(array(
	'feed' => '#',
        'show_sitename' => true,
        'show_content' => true,
        'excerpt' => false,
        'trusted' => false,
        'title_style' => '',
        'items' => 10
    ), $args));

    $err_msg = '[weaver_feed] invalid values provided.';

    $show_sitename = weaveriip_tf($show_sitename);
    $show_content = weaveriip_tf($show_content);
    $excerpt = weaveriip_tf($excerpt);
    weaverii_sc_reset_opts();
    weaverii_sc_setopt('more_msg','<br />Click Article Title for full article at original site.');

    if ($title_style != '') {
        $title_style = 'style=' . weaveriip_bracket($title_style, '"', '"');
    }

    $ent_title = '<header class="entry-header"><hgroup class="entry-hdr"><h2 class="entry-title" ' . $title_style .'>';

    while ( stristr($feed, 'http') != $feed )   // strip anything before http
	$feed = substr($feed, 1);

    if ( empty($feed) )
	return $err_msg;

    // self-url destruction sequence
    if ( $feed == site_url() || $feed == home_url() )
	return '[weaver_feed] - feed must not be own site.';

    $rss = fetch_feed($feed);
    $sitedesc = '';
    $sitelink = '';

    if ( ! is_wp_error($rss) ) {
	$sitedesc = esc_attr(strip_tags(@html_entity_decode($rss->get_description(), ENT_QUOTES, get_option('blog_charset'))));
	$sitetitle = esc_html(strip_tags($rss->get_title()));
	$sitelink = esc_url(strip_tags($rss->get_permalink()));
	while ( stristr($sitelink, 'http') != $sitelink )
	    $sitelink = substr($sitelink, 1);
    } else {
	if ( is_admin() || current_user_can('manage_options') )
	    $err_msg = '<p>' . sprintf( __('<strong>RSS Error</strong>: %s','weaver-ii'), $rss->get_error_message() ) . '</p>';
	return $err_msg;
    }

    if ( empty($sitetitle) )
	$sitetitle = empty($sitedesc) ? __('Unknown Feed','weaver-ii') : $sitedesc;

    $feed = esc_url(strip_tags($feed));

    if ( $sitetitle ) {
        $imgurl = weaverii_relative_url('includes/pro/social/1/rss.png');
	$sitetitle = '<h2 class="entry-title feed-title">'
        . '<a href="' . $feed . '" title="' . esc_attr__( 'Syndicate this content' ) . '" target=\"_blank\"><img src="' . $imgurl . '" height="16" width="16" /></a>&nbsp;&nbsp;'
        . "<a href='$sitelink' title='$sitedesc' target='_blank'>$sitetitle</a></h2>";
    }

    $out = "<div class='weaver-feed'> <!-- *********************************************** -->\n";
    if ($show_sitename) {
        $out .= $sitetitle . "\n";     // add a title for whole feed
    }

    $items = (int) $items;
    if ( $items < 1 || 20 < $items )
	    $items = 10;

    if ( !$rss->get_item_quantity() ) {
	$out .= '<p>' . __( 'An error has occurred; the feed is probably down. Try again later.','weaver-ii') . '</p></div>';
	$rss->__destruct();
	unset($rss);
	return $out;
    }
    $rss_items = $rss->get_items(0, $items);

    // +++++++++++ feed article loop ++++++++++++

    foreach ( $rss_items as $item ) {
	$out .= '<article class="post type-post hentry category-uncategorized post-feed">' . "\n";

        $link = $item->get_link();
	while ( stristr($link, 'http') != $link )
	    $link = substr($link, 1);
	$link = esc_url(strip_tags($link));
	$title = esc_attr(strip_tags($item->get_title()));
	if ( empty($title) )
	    $title = __('Untitled','weaver-ii');

	$desc = @html_entity_decode( $item->get_description(), ENT_QUOTES, get_option('blog_charset') );
        if (!$trusted) {
            $desc = str_replace( array("\n", "\r"), ' ', esc_attr( strip_tags( $desc ) ) );
        }

	if ($excerpt) {
            $desc = wp_html_excerpt( $desc, 300 );

	    // Append ellipsis. Change existing [...] to [&hellip;].
	    if ( '[...]' == substr( $desc, -5 ) )
		$desc = substr( $desc, 0, -5 ) . '[&hellip;]';
	    elseif ( '[&hellip;]' != substr( $desc, -10 ) )
		$desc .= ' [&hellip;]';
        }

	if (!$trusted)
            $desc = esc_html( $desc );

	$date = '';
	$date = $item->get_date( 'U' );
        if ( $date ) {
	    $date = date_i18n( get_option( 'date_format' ), $date );
	}

        $author = $item->get_author();
	if ( is_object($author) ) {
	    $author = $author->get_name();
	    $author = esc_html( strip_tags( $author ) );
	} else {
            $author = '';
        }

	if ( $link == '' ) $link = '#';

        $out .= $ent_title . '<a href="' . $link . '" title="Permalink to ' . $title . '">' . $title . "</a></h2></hgroup>\n";

        // now match logic for posted_on
        $out .= weaveriip_posted_on_code($date, $author) . "</header> <!-- entry-header -->\n";

        if ($show_content) {
            $out .= "<div class='entry-content'>\n" . $desc . "\n</div> <!-- entry-content -->\n";
        }

        $out .= "</article> <!-- post-feed -->\n";
    }
    $out .= "</div> <!-- weaver-feed -->\n";
    $rss->__destruct();
    unset($rss);
    weaverii_sc_reset_opts();
    return $out;
}

function weaveriip_posted_on_code($date, $author) {
	if (weaverii_getopt('wii_post_info_hide_top') || weaverii_is_checked_page_opt('wvp_perpost_info_hide_top')) {
		return '';
	}

	$leftm = '8';

	$on = "\t<div class=\"entry-meta\" style=\"margin-botom:-5px;margin-top:-10px;\"><div " . weaverii_meta_icons_class() . ">\n\t\t";

	$on .= '<span class="sep">Posted on </span><time class="entry-date" >' . $date .
	    '<span class="by-author"> <span class="sep"> by </span> <span class="author vcard">' . $author . '</span></span>';
	$on .= "\n    </div></div><!-- .entry-meta -->\n";
        return $on;
}

function weaveriip_tf($val) {
    if ($val === true) return true;
    if ($val === false) return false;
    if ($val === 'false') return false;
    if ($val === 'no') return false;
    if ((int)$val == 0) return false;
    return true;
}

add_shortcode('weaver_feed', 'weaveriip_feed_shortcode');
?>
