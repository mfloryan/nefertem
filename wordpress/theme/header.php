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
    <?php wp_head(); ?>
    <link rel="pingback" href="<?php bloginfo('pingback_url'); ?>" />

</head>
<body <?php body_class(); ?>>
<div class="page_container">