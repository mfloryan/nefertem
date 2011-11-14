<?php
/*
    nefertem - A WordPress template

    Copyright (C) 2011 Marcin Floryan, mmsquare limited, http://www.mmsquare.com/

    This program is free software: you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published by
    the Free Software Foundation, either version 3 of the License, or
    (at your option) any later version.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    For the full license see the LICENSE file.
 */
    wp_enqueue_script( "jquery" );
    wp_enqueue_script( 'modernizr', get_template_directory_uri().'/js/modernizr-1.7.min.js', array(), '1.7', false );
    wp_enqueue_script( 'nefertem', get_template_directory_uri().'/js/nefertem.js', array('jquery'), '1.0', true );
    //wp_enqueue_script('twitter-widgets', 'http://platform.twitter.com/widgets.js', array(), '1.0.0', true);
    if (is_singular()) wp_enqueue_script('comment-reply');
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo( 'charset' ); ?>" />
    <title><?php
        bloginfo( 'name');
        wp_title();
    ?></title>
    <link rel="stylesheet" href="<?php bloginfo('stylesheet_directory'); ?>/reset.css" type="text/css" media="all" />
    <link rel="stylesheet" href="<?php bloginfo('stylesheet_directory'); ?>/960.css" type="text/css" media="all" />
    <link rel="stylesheet" href="<?php bloginfo('stylesheet_url'); ?>" type="text/css" media="all" />
    <link rel='stylesheet' href='http://fonts.googleapis.com/css?family=Ubuntu:500' type='text/css' />
    <?php wp_head(); ?>
    <link rel="pingback" href="<?php bloginfo('pingback_url'); ?>" />
    <link rel="alternate" type="application/rss+xml" title="RSS 2.0 feed - all posts" href="<?php echo get_feed_link('rss2'); ?>" />
    <link rel="alternate" type="application/rss+xml" title="RSS 2.0 feed - comments" href="<?php echo get_feed_link('comments_rss2'); ?>" />
    <link rel="alternate" type="application/atom+xml" title="ATOM Feed - all posts" href="<?php echo get_feed_link('atom'); ?>" />
    <link rel="alternate" type="application/atom+xml" title="ATOM Feed - comments" href="<?php echo get_feed_link('comments_atom'); ?>" />
</head>